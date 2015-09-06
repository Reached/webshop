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

    {{ $cartTotal }} DKK

    <h3>Address information: </h3>
    {!! Form::open(['url' => '/cart/checkout', 'id' => 'billing-form']) !!}
    {!! Form::text('name', null, ['placeholder' => 'Your name', 'data-stripe' => 'name']) !!}
    {!! Form::email('email', null, ['placeholder' => 'Your Email', 'data-stripe' => 'email', 'id' => 'email']) !!}
    {!! Form::text('street', null, ['placeholder' => 'Street name and house number', 'data-stripe' => 'address_line1']) !!}
    {!! Form::number('zip', null, ['placeholder' => 'Zip code', 'data-stripe' => 'address_zip']) !!}
    {!! Form::text('city', null, ['placeholder' => 'City name', 'data-stripe' => 'city']) !!}
    {!! Form::textarea('comments', null, ['placeholder' => 'Comments']) !!}

    <p>Your credit card information will never touch our servers.</p>
    {!! Form::text(null, null, ['placeholder' => 'Card number', 'data-stripe' => 'number']) !!}
    {!! Form::selectMonth(null, null, ['data-stripe' => 'exp-month']) !!}
    {!! Form::selectYear(null, date('Y'), date('Y') + 10, null, ['data-stripe' => 'exp-year']) !!}
    {!! Form::text(null, null, ['placeholder' => 'Cvc', 'data-stripe' => 'cvc']) !!}

    {!! Form::submit('Bekræft køb') !!}

    <div class="payment-errors"></div>

    {!! Form::close() !!}

@endsection