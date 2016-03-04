@extends('frontend.shopLayout')

@section('shoppingCart')
    <a href="/">Continue shopping?</a>
    @foreach($cartContent as $content)
        <div>
            <p>{{ $content->name }}</p>
            <p>Quantity: {{ $content->qty }}</p>
            <p>Price: {{ getRoundedValue($content->price) }}</p>
            <img src="{{ $content->options->imagePath }}">

            <form action="/cart/remove" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $content->rowid }}">
                <input type="submit" value="Remove product">
            </form>
            <form action="/cart/updateitem" method="post" data-remote>
                {{ csrf_field() }}
                <label for="updateQty">Update quantity</label>
                <input type="number" id="updateQty" name="qty" placeholder="" value="{{ $content->qty }}">
                <input type="hidden" name="id" value="{{ $content->rowid }}">
                <input type="submit">
            </form>

        </div>
        <hr>

    @endforeach

    <hr>

    <p>Subtotal: {{ getRoundedValue($cartTotal) }} DKK</p>
    <p>Total: ({{ $taxRate }}%): {{ getRoundedValue($withVat) }} DKK</p>

    <form action="/cart/removeall" method="post" data-remote>
        {{ csrf_field() }}
        <input type="submit">
    </form>

    <a href="/cart/checkout">Gå til kassen</a>
@endsection