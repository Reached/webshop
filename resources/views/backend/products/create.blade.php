@extends('backend.backend')

@section('products')
    <h1>Create a new product</h1>

    <form action="/admin/products/store" method="POST" id="create-product-form">
        {{ csrf_field() }}
        <label for="product_name">Product name</label>
        <input type="text" name="product_name" id="product_name" placeholder="Product name">

        <label for="product_price">Product price</label>
        <input type="number" id="product_price" name="product_price" placeholder="Product price">

        <label for="long_description">Long description</label>
        <input type="text" id="long_description" name="long_description" placeholder="Long description">

        <label for="short_description">Short description</label>
        <input type="text" id="short_description" name="short_description" placeholder="Short description">

        <label for="meta_description">Meta description</label>
        <input type="text" id="meta_description" name="meta_description" placeholder="Meta description">

        <div class="select">
            <label for="category_id"></label>
            <select name="category_id" id="category_id">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="select">
            <label for="is_active">Should the product be active?</label>
            <select name="is_active" id="is_active">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <input type="submit">
    </form>
@endsection