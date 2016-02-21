@extends('backend.backend')

@section('products')
    <h1>{{$product->product_name}}</h1>
    <h2>Upload pictures of the product</h2>

    <form action="/admin/products/show/{{$product->id}}/images" class="dropzone" id="dropzone">
        {!! csrf_field() !!}
        <input type="hidden" name="productId" value="{{ $product->id }}">
    </form>

@endsection

@section('scripts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.js"></script>
    <script>
        Dropzone.options.dropzone = {
            paramName: 'photo', // The name that will be used to transfer the file
            maxFilesize: 5, // MB
            maxFiles: 10,
            acceptedFiles: '.jpg, .jpeg, .png, .svg'
        };
    </script>
@endsection