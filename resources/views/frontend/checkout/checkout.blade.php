@extends('frontend.shopLayout')

@section('stripeKey')
    <meta name="publishable-key" content="{{ env('STRIPE_PUBLIC_KEY') }}">
@endsection

@section('content')
    <h1>Checkout</h1>
    <a href="/">Continue shopping?</a>

    <h2>Shopping cart summary:</h2>

        <h3>Address information: </h3>
        <form method="post" action="/cart/checkout" id="payment-form" data-amount="{{ $cartTotal }}">
            {{ csrf_field() }}

            <label for="first_name">First name</label>
            <input type="text" id="first_name" name="first_name" placeholder="First name"
                   value="@if (Auth::user()) {{ Auth::user()->first_name }}@endif" data-stripe="first_name">

            <label for="last_name">First name</label>
            <input type="text" id="last_name" name="last_name" placeholder="Last name"
                   value="@if (Auth::user()) {{ Auth::user()->last_name }}@endif" data-stripe="last_name">

            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Email"
                   value="@if (Auth::user()) {{ Auth::user()->email }}@endif" data-stripe="email">

            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" placeholder="Phone"
                   value="@if (Auth::user()) {{ Auth::user()->phone }}@endif">

            <label for="street">Street</label>
            <input type="text" id="street" name="street" placeholder="Street address"
                   value="@if (Auth::user()) {{ Auth::user()->street }}@endif" data-stripe="address_line1">

            <label for="zip">Zip</label>
            <input type="text" id="zip" name="zip" placeholder="Zip"
                   value="@if (Auth::user()) {{ Auth::user()->zip }}@endif" data-stripe="zip">

            <label for="city">City</label>
            <input type="text" id="city" name="city" placeholder="Street address"
                   value="@if (Auth::user()) {{ Auth::user()->city }}@endif" data-stripe="city">

        <select data-vat="country" name="country">
            <option value="DK" selected>Denmark</option>
            <option value="SE">Sweden</option>
            <option value="GB">United Kingdom</option>
            <option value="DE">Germany</option>
            <option value="NO">Norway</option>
            <option value="EE">Estonia</option>
            <option value="FI">Finland</option>
        </select>

        <input data-vat="vat-number"/>

        <hr>
        <ul>
            @foreach($cartContent as $content)
                <li>{{ $content->name }} - {{ getRoundedValue($content->price) }}</li>
            @endforeach
        </ul>
        <strong>Subtotal</strong>: <span class="vat-subtotal"></span>
            <br><br>
        <strong>Tax rate</strong>: <span class="vat-taxrate"></span>%
            <br><br>
        <strong>Taxes</strong>: <span class="vat-taxes"></span>
            <br><br>
        <strong>Total</strong>: <span class="vat-total"></span>
        <hr>

        <br><br>
        <label for="sms">Do you want to receive a text when your order has been sent?</label>
        <input type="radio" id="sms" name="sendSms" value="1"> Yes
        <input type="radio" id="sms1" name="sendSms" value="0" checked> No

        <hr>

        <p>Your credit card information will never touch our servers.</p>

            <label for="card_number">Card number</label>
            <input type="text" id="card_number" placeholder="Card number" data-stripe="number">

            <label for="expire_month">Expiry month</label>
            <input type="number" id="expire_month" placeholder="Expiry month" data-stripe="exp-month">

            <label for="expire_year">Expiry year</label>
            <input type="number" id="expire_year" placeholder="Expiry year" data-stripe="exp-year">

            <label for="cvc_number">Card number</label>
            <input type="text" id="cvc_number" placeholder="CVC" data-stripe="cvc">

        <div class="payment-errors"></div>

        <input type="submit" value="Pay!">

        </form>
@endsection