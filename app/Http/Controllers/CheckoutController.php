<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Events\OrderWasPlaced;
use Event;
use Stripe\Customer;
use Stripe\Error\Base;
use Stripe\Error\Card;
use Stripe\Stripe;
use Cart;
use Auth;
use Carbon\Carbon;

class CheckoutController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCheckout() {
        $cartTotal = Cart::total();
        $cartContent = Cart::content();

        return view('frontend.checkout.checkout', compact('cartTotal', 'cartContent'));
    }

    /**
     * @param Request $request
     * @return string
     */
    public function verifyPayment(Request $request) {

        // Get the details submitted by the form
        $email = $request->input('email');
        $countryCode = $request->input('country');
        $source = $request->input('stripeToken');

        $order = $request->all();

        // If the user is logged in, but does not have a stripe customer id,
        // we attach it to the them and set the billing_id to be equal to the newly created
        // customer id
        if(Auth::check() and Auth::user()->stripe_customer_id == null) {

            $user = Auth::user();

            $email = $user->email;
            $customer = $this->createNewCustomer($source, $email);
            $billing_id = $customer->id;

            $user->stripe_customer_id = $billing_id;
            //$customerName = $user->first_name . $user->last_name;
            $user->save();

            // Else if the authenticated user already has a Stripe id, we grab their stripe customer id from
            // the user object
        } elseif(Auth::check()) {
            $user = Auth::user();
            $billing_id = $user->stripe_customer_id;

            // If the user is not authenticated, we just create a new customer object
            // and assign their email to it
        } elseif(Auth::guest()) {
            $customer = $this->createNewCustomer($source, $email);
            $billing_id = $customer->id;
        }

        // Get the amount total in the smallest denominator
        $amount = $this->calculateAmount($countryCode);

        event(new OrderWasPlaced($amount, $billing_id, $order));

        return response()->json(['success' => true, 'message' => 'Your order is now pending, we will let you know!'], 200);
    }

    /**
     * @param $amount
     * @param $countryCode
     * @return mixed
     */
    public function calculateAmount($countryCode) {

        $cartTotal = Cart::total();

        $amount = \VatCalculator::calculate($cartTotal, $countryCode);

        return $amount;
    }

    /**
     * @param $source
     * @param null $email
     * @return Customer
     */
    public function createNewCustomer($source, $email) {

        Stripe::setApiKey(env('STRIPE_API_KEY'));

        try {
            $customer = Customer::create([
                'source' => $source,
                'email' => $email,
            ]);

        } catch(Card $e) {
            return response()->json(['success' => false, 'message' => 'Your card was declined, please try again.'], 402);
        } catch (Base $e) {
            return response()->json(['success' => false, 'message' => 'The transaction did not go through, please try again.'], 402);
        }

        return $customer;
    }
}
