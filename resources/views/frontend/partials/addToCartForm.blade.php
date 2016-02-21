<form method="POST" action="/cart" data-remote>
    {!! csrf_field() !!}
    <input type="hidden" name="product_price" value="{{ $product->product_price }}">
    <input type="hidden" name="id" value="{{ $product->id }}">
    <input type="submit">
</form>