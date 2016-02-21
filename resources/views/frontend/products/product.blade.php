@foreach($products as $product)
<div class="col col3">
    <article class="product">
        <a href="/product/{{ $product->slug }}">
        <div class="img-container">
            <img src="{{ $product->getFirstMediaUrl('images', 'large') }}">
          <!-- <button class="put-to-basket">Add to cart</button> -->
        </div>
          <div class="meta">
            <h2>{{ $product->product_name }}</h2>
            <em class="price">${{ $product->product_price / 100 }}</em>
          </div>
        </a>
        @include('frontend.partials.addToCartForm')
    </article>
</div>
@endforeach