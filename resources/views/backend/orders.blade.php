@extends('backend.backend')

@section('content')
    <h1>Orders</h1>

    @foreach($orders as $order)
    <div>{{$order->id}}
        @if ( $order->confirmed == 0 )
            <form action="orders/approve" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" name="order_id" value="{{$order->id}}">
                <input type="submit" value="Godkend ordren">
            </form>
            <div class="">The order is not confirmed yet</div>
        @endif
        @if ( $order->confirmed == 1 )
            <div class="">The order was confirmed</div>
        @endif
    </div>
    @endforeach
@endsection