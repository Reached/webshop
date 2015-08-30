@foreach($products as $product)
<div class="col col3">
    <article class="product">
        <a href="#">
        <div class="img-container">
          <img src="{{ $product->product_image }}">
          <!-- <button class="put-to-basket">Add to cart</button> -->
        </div>
          <div class="meta">
            <h2>{{ $product->product_name }}</h2>
            <em class="price">${{ $product->product_price }}</em>
          </div>
        </a>
        {!! Form::open(['url' => '/cart']) !!}
            {!! Form::hidden('id', $product->id) !!}
            {!! Form::submit('Add to basket', ['class' => 'button']) !!}
        {!! Form::close() !!}
    </article>
</div>
@endforeach