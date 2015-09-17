@extends('frontend.shop')

@section('shoppingCart')
    <a href="/">Continue shopping?</a>
    @foreach($cartContent as $content)
        <li>{{ $content->name }} {{ $content->qty }} {{ $content->price }}</li>
        {!! Form::open(['url' => 'cart/remove']) !!}
        {!! Form::hidden('id', $content->rowid) !!}
        {!! Form::submit('Remove item', ['class' => 'button']) !!}
        {!! Form::close() !!}

        {!! Form::open(['url' => 'cart/updateitem']) !!}
        {!! Form::hidden('id', $content->rowid) !!}
        {!! Form::number('qty', $content->qty) !!}
        {!! Form::submit('Update item', ['class' => 'button']) !!}
        {!! Form::close() !!}
    @endforeach

    <p>Subtotal: {{ $cartTotal }} DKK</p>
    <p>Total: ({{ $taxRate }}% ): {{ $withVat }} DKK</p>
    {!! Form::open(['url' => '/cart/removeall']) !!}
    {!! Form::submit('Remove all items', ['class' => 'button']) !!}
    {!! Form::close() !!}

    <a href="/cart/checkout">Gå til kassen</a>
@endsection