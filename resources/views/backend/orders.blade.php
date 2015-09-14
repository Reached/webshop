@extends('backend.backend')

@section('content')
    <h1>Orders</h1>

    @foreach($orders as $order)
    <li>{{$order->id}}</li>
        <form action="orders/approve" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="order_id" value="{{$order->id}}">
            <input type="submit" value="Godkend ordren">
        </form>
    @endforeach
@endsection