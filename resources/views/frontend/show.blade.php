@extends('frontend.shop')

@section('product')
    <img src="{{ $product->product_image }}">
    <h1>{{ $product->product_name }}</h1>

    {!! Form::open(['url' => '/cart']) !!}
    {!! Form::hidden('id', $product->id) !!}
    {!! Form::submit('Add to basket', ['class' => 'button']) !!}
    {!! Form::close() !!}
@endsection