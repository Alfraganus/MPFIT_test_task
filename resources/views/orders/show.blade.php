@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Order Details</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>Customer</th>
                        <td>{{ $order->customer_fullname }}</td>
                    </tr>
                    <tr>
                        <th>Product</th>
                        <td>{{ $order->product->product_name }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $order->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>{{ number_format($order->price / 100, 2) }} ₽</td> {{-- Normalizing price --}}
                    </tr>
                    <tr>
                        <th>User</th>
                        <td>{{ $order->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($order->order_status_id == 0)
                                <span class="badge bg-warning">New</span>
                            @elseif($order->order_status_id == 1)
                                <span class="badge bg-success">Done</span>
                            @else
                                <span class="badge bg-secondary">Unknown</span>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>

                <a href="{{ route('orders.index') }}" class="btn btn-primary mt-3">Back to Orders</a>

                @if($order->order_status_id == 0)
                    <form action="{{ route('orders.markFinished', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success mt-3" onclick="return confirm('Are you sure you want to mark this order as finished?');">
                            Mark as Finished
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Comments Section --}}
        <div class="card mt-4">
            <div class="card-header">
                <h5>Comments</h5>
            </div>
            <div class="card-body">
                @if($order->comments->count() > 0)
                    <ul class="list-group">
                        @foreach($order->comments as $comment)
                            <li class="list-group-item">
                                <strong>{{ $comment->user->name }}</strong>
                                <span class="text-muted">({{ $comment->created_at->diffForHumans() }})</span>
                                <p class="mb-0">{{ $comment->comment_text }}</p>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No comments yet.</p>
                @endif
            </div>
        </div>

        {{-- Add Comment Form --}}
        <div class="card mt-4">
            <div class="card-header">
                <h5>Add a Comment</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('orders.comments.store', $order->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="content" class="form-label">Your Comment</label>
                        <textarea name="comment_text" id="content" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                </form>
            </div>
        </div>

    </div>
@endsection
