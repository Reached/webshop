@extends('frontend.shop')

@section('meta-description')
    {{ $product->meta_description }}
@endsection

@section('product')
    <img src="{{ $product->product_image }}">
    <h1 style="font-size: 25px;">{{ $product->product_name }}</h1>
    <p>{{ $product->long_description }}</p>
    <p>{{ $product->product_price }}</p>

    @foreach($productPhotos as $photo)
        <img src="{{ $photo->path }}" alt="{{ $product->product_name }}">
    @endforeach

    <form action="/cart" method="POST">
        {{ csrf_field() }}
        <input type="hidden" value="{{ $product->id }}">
        <input type="submit">
    </form>

@endsection