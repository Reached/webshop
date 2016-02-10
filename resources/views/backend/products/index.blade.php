@extends('backend.backend')

@section('content')
    <a href="/admin/products/create" class="ui button">Create new product</a>
    <h1>All products</h1>

    @foreach($products as $product)
        <h2><a href="/admin/products/show/{!! $product->id !!}">{{$product->product_name}}</a></h2>
    @endforeach

@endsection