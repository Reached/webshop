<?php

namespace App\Http\Controllers;

use App\Webshop\Providers\BillysBilling;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Order;
use Stripe\Error\Card;
use App\Events\OrderWasApproved;

class OrdersController extends Controller
{

    public function showOrders() {
        $orders = Order::paginate(10);

        return view('backend.orders', compact('orders'));
    }

    public function showSingleOrder($orderId) {
        $order = Order::findOrFail($orderId);

        return view('backend.showOrder', compact('order'));
    }

    public function approveOrder(Request $request) {
        $order_id = $request->input('order_id');
        $order = Order::findOrFail($order_id);

        try {
            event(new OrderWasApproved($order));

            $order->confirmed = true;
            $order->save();

        } catch(Card $e) {
            return response()->json(['success' => false, 'message' => 'Your card was declined, please try again.'], 402);
        } catch (Base $e) {
            return response()->json(['success' => false, 'message' => 'The transaction did not go through, please try again.'], 402);
        } catch (Authentication $e) {
            return response()->json(['success' => false, 'message' => 'The API key provided is wrong, please make sure that you are using the correct keys.'], 402);
        }

        return response()->json(['success' => true, 'message' => 'The card was successfully charged'], 200);
    }

    public function sendToBilly() {
        $billy = new BillysBilling(env('BILLYS_KEY'));

        //Create a contact
        $res = $billy->request("GET", "/contacts");

        if ($res->status !== 200) {
            return response()->json(['message' => $res->body]);
        }
        $contactId = $res->body->contacts[0]->id;

        $res = $billy->request("GET", "/organization");
        if ($res->status !== 200) {
            echo "Something went wrong:\n\n";
            print_r($res->body);
            exit;
        }
        dd($organizationId = $res->body->organization->defaultInvoiceBankAccountId);

//        $date = Carbon::now()->format('Y-m-d');
//        defaultInvoiceBankAccount
//        $request = $billy->makeBillyRequest('POST', '/invoices', [
//            'invoice' => [
//                'organizationId' => env('BILLY_ORGANIZATION'),
//                'contactId' => $contactId,
//                'entryDate' => $date,
//                'paymentTermsDays' => 5,
//                'state' => 'draft',
//                'sentState' => 'unsent',
//                'invoiceNo' => 1115,
//                'currencyId' => 'DKK',
//                'lines' => [
//                    [
//                        'productId' => '7hTuJ92QS3OagqmM9piJ3Q',
//                        'unitPrice' => 500
//                    ]
//                ],
//            ]
//        ]);
//
//        if ($request->status !== 200) {
//            return response()->json(['message' => $request->body]);
//        }
//
//        $invoiceId = $request->body->invoices[0]->id;
//
//        $bankPayment = $billy->makeBillyRequest('POST', '/bankPayments', [
//            'bankPayment' => [
//                'organizationId' => env('BILLY_ORGANIZATION'),
//                'contactId' => $contactId,
//                'entryDate' => $date,
//                'cashAmount' => 500,
//                'cashSide' => 'debit',
//                'cashAccountId' => 1,
//                'associations' => [
//                    [
//                        'subjectReference' => 'invoice:' . $invoiceId,
//                    ]
//                ],
//            ]
//        ]);
//
//        if ($bankPayment->status !== 200) {
//            return response()->json(['message' => $bankPayment->body]);
//        }

    }
}
