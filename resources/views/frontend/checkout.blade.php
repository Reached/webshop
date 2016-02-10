@extends('frontend.shop')

@section('content')
    <h1>Checkout</h1>
    <a href="/">Continue shopping?</a>

    <h2>Shopping cart summary:</h2>

    <ul>
    @foreach($cartContent as $content)
        <li>{{ $content->name }} - {{ $content->price }} DKK</li>
    @endforeach
    </ul>

    <p>Subtotal: {{ $cartTotal }} DKK</p>
    <p>Total: ({{ $taxRate }}% ): {{ $withVat }} DKK</p>

        <h3>Address information: </h3>
        {!! Form::open(['url' => '/cart/checkout', 'id' => 'payment-form', 'data-amount' => $cartTotal * 100]) !!}
        {!! Form::text('first_name', Auth::user()->first_name, ['placeholder' => 'Your first name', 'data-stripe' => 'first_name']) !!}
        {!! Form::text('last_name', Auth::user()->last_name, ['placeholder' => 'Your last name', 'data-stripe' => 'last_name']) !!}
        {!! Form::email('email', Auth::user()->email, ['placeholder' => 'Your Email', 'data-stripe' => 'email', 'id' => 'email']) !!}
        {!! Form::text('street', Auth::user()->address, ['placeholder' => 'Street name and house number', 'data-stripe' => 'address_line1']) !!}
        {!! Form::number('zip', Auth::user()->zip, ['placeholder' => 'Zip code', 'data-stripe' => 'address_zip']) !!}
        {!! Form::text('city', Auth::user()->city, ['placeholder' => 'City name', 'data-stripe' => 'city']) !!}

        <select data-vat="country">
            <option value="DK" selected>Denmark</option>
            <option value="US">United States</option>
            <option value="GB">United Kingdom</option>
            <option value="DE">Germany</option>
            <option value="FR">France</option>
            <option value="IT">Italy</option>
            <option value="ES">Spain</option>
            <option value="CA">Canada</option>
            <option value="AU">Australia</option>
        </select>

        <input data-vat="vat-number"/>

        <strong>Subtotal</strong>: <span class="vat-subtotal"></span>
        <strong>Tax rate</strong>: <span class="vat-taxrate"></span>%
        <strong>Taxes</strong>: <span class="vat-taxes"></span>
        <strong>Total</strong>: <span class="vat-total"></span>

        <p>Your credit card information will never touch our servers.</p>
        {!! Form::text(null, null, ['placeholder' => 'Card number', 'data-stripe' => 'number']) !!}
        {!! Form::selectMonth(null, null, ['data-stripe' => 'exp-month']) !!}
        {!! Form::selectYear(null, date('Y'), date('Y') + 10, null, ['data-stripe' => 'exp-year']) !!}
        {!! Form::text(null, null, ['placeholder' => 'Cvc', 'data-stripe' => 'cvc']) !!}

        {!! Form::submit('Bekræft køb') !!}

        <div class="payment-errors"></div>

        {!! Form::close() !!}

@endsection