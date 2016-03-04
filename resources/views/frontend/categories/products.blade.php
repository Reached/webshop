@extends('frontend.shopLayout')

@section('content')
    <nav>
    <a href="/categories" class="active"></a>
    @foreach($categories as $category)
        <a href="/categories/{{ $category->slug }}">{{ $category->category_name }}</a>
    @endforeach
    </nav>
    <section class="product-grid" id="products">
        <div class="container">
            @include('frontend.products.product')
        </div>
    </section>
@endsection