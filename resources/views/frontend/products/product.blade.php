@foreach($products as $product)
<div class="col col3">
    <article class="product">
        <a href="/product/{{ $product->slug }}">
        <div class="img-container">
          <img src="{{ $product->product_image }}">
          <!-- <button class="put-to-basket">Add to cart</button> -->
        </div>
          <div class="meta">
            <h2>{{ $product->product_name }}</h2>
            <em class="price">${{ $product->product_price / 100 }}</em>
          </div>
        </a>
        <form method="POST" action="/cart" data-remote>
            {!! csrf_field() !!}
            <input type="hidden" name="product_price" value="{{ $product->product_price }}">
            <input type="hidden" name="id" value="{{ $product->id }}">
            <input type="submit">
        </form>
    </article>
</div>
@endforeach