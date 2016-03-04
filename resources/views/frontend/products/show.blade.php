@extends('frontend.shopLayout')

@section('meta-description')
    {{ $product->meta_description }}
@endsection

@section('product')
    <h1 style="font-size: 25px;">{{ $product->product_name }}</h1>
    <p>{{ $product->long_description }}</p>
    <p>Price: {{ getRoundedValue($product->product_price) }}</p>

    @foreach($images as $image)
        <img src="{{ $image->getUrl('large') }}" alt="{{ $product->product_name }}">
    @endforeach

    @include('frontend.partials.addToCartForm')

@endsection