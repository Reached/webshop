@extends('backend.backendLayout')

@section('content')
    <header class="page-header">
        <h1>Order #{{ $order->id }}</h1>
    </header>

    <main class="main-content">
        <li>{{ ($order->confirmed == true) ? 'The order is confirmed' : 'The order is not confirmed.'}}</li>
        <li>{{ getRoundedValue($order->amount) }}</li>
        <li>{{ $order->customer_name }}</li>
        <li>{{ $order->customer_address }}</li>
        <li>{{ $order->customer_zip }}</li>
        <li>{{ $order->customer_city }}</li>
        <li>{{ $order->customer_phone_number }}</li>

        <form method="post" action="/admin/orders/billy">
            {{ csrf_field() }}
            <input type="submit">
        </form>

    </main>

@endsection