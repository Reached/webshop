@extends('frontend.shop')

@section('products')
    <section class="product-grid" id="products">
        <div class="container">
            @include('frontend.products.product')
        </div>
    </section>
@endsection
