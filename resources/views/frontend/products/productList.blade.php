@extends('frontend.shopLayout')

@section('products')
    <section class="product-grid" id="products">
        <div class="container">
            @include('frontend.products.product')
        </div>
    </section>
@endsection
