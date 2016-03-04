@extends('frontend.shopLayout')

@section('content')
    <nav>
        <a href="/categories"></a>
        @foreach($categories as $cat)
            <a href="/categories/{{ $cat->slug }}">{{ $cat->category_name }}</a>
        @endforeach
    </nav>
    <section class="product-grid" id="products">
        <div class="container">
            @include('frontend.products.product')
        </div>
    </section>
@endsection