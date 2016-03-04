@extends('backend.backendLayout')

@section('content')



    <header class="page-header">
        <h1>Orders</h1>
    </header>

    <main class="main-content">
        <form class="search-form">
            <input type="search" class="default-input search-input" placeholder="Enter an order id or name here">
            <input type="submit" class="button button-yellow" value="Search">
        </form>
        <table class="default-table">
            <thead>
                <tr>
                    <th>Link</th>
                    <th>Order</th>
                    <th>Amount</th>
                    <th>Creation date</th>
                    <th>Customer name</th>
                    <th>Customer id</th>
                    <th>Confirm</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td><a href="/admin/orders/{{$order->id}}">Go to order</a></td>
                        <td>#{{ $order->id }}</td>
                        <td>{{ getRoundedValue($order->amount) }}</td>
                        <td>{{ $order->created_at->toFormattedDateString() }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ ($order->user_id == 1) ? 'No user' : '#' . $order->user_id }}</td>
                        <td>
                            @if ( !$order->confirmed )
                                <form action="orders/approve" method="POST">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="order_id" value="{{$order->id}}">
                                    <input type="submit" value="Confirm order" class="button confirm">
                                </form>
                            @endif
                        </td>
                        <td>
                            <form action="orders/approve" method="POST">
                                {!! csrf_field() !!}
                                <input type="hidden" name="order_id" value="{{$order->id}}">
                                <input type="submit" value="Delete">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {!! $orders->links() !!}
    </main>
@endsection