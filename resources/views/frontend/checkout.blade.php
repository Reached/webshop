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

    {{-- Check if the user has an existing billing id --}}
    @if(Auth::user()->billing_id !== null )
        <p>You are authorized.</p>
        {!!  Auth::user()->card_brand !!}
        {!!  Auth::user()->card_last_four !!}
    @else

        <h3>Address information: </h3>
        {!! Form::open(['url' => '/cart/checkout', 'id' => 'billing-form']) !!}
        {!! Form::text('name', Auth::user()->name, ['placeholder' => 'Your name', 'data-stripe' => 'name']) !!}
        {!! Form::email('email', Auth::user()->email, ['placeholder' => 'Your Email', 'data-stripe' => 'email', 'id' => 'email']) !!}
        {!! Form::text('street', Auth::user()->address, ['placeholder' => 'Street name and house number', 'data-stripe' => 'address_line1']) !!}
        {!! Form::number('zip', Auth::user()->zip, ['placeholder' => 'Zip code', 'data-stripe' => 'address_zip']) !!}
        {!! Form::text('city', Auth::user()->city, ['placeholder' => 'City name', 'data-stripe' => 'city']) !!}
        {!! Form::textarea('comments', null, ['placeholder' => 'Comments']) !!}

        <p>Your credit card information will never touch our servers.</p>
        {!! Form::text(null, null, ['placeholder' => 'Card number', 'data-stripe' => 'number']) !!}
        {!! Form::selectMonth(null, null, ['data-stripe' => 'exp-month']) !!}
        {!! Form::selectYear(null, date('Y'), date('Y') + 10, null, ['data-stripe' => 'exp-year']) !!}
        {!! Form::text(null, null, ['placeholder' => 'Cvc', 'data-stripe' => 'cvc']) !!}

        {!! Form::submit('Bekræft køb') !!}

        <div class="payment-errors"></div>

        {!! Form::close() !!}
    @endif



@endsection