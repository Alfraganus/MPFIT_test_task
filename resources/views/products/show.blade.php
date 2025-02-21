@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Product Details</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>Product Name</th>
                        <td>{{ $product->product_name }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $product->description }}</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>${{ number_format($product->price / 100, 2) }}</td> {{-- Normalizing price --}}
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $product->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($product->status == 1)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>

                <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Back to Products</a>
            </div>
        </div>
    </div>
@endsection
