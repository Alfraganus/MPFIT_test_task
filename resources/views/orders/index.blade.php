@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Orders</h2>
        <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">Create Order</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>User</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_fullname }}</td>
                    <td>{{ $order->product->product_name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ \App\Http\Service\ProductService::getPrice($order->product->id,true) }} ₽</td>  <!-- Normalizing price -->
                    <td>{{ $order->user->name }}</td>
                    <td>
                        @if($order->order_status_id == 0)
                            <span class="badge bg-warning">New</span>
                        @elseif($order->order_status_id == 1)
                            <span class="badge bg-success">Done</span>
                        @else
                            <span class="badge bg-secondary">Unknown</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure that you delete this order?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
