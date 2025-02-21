@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Order</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Customer Name</label>
                <input type="text" name="customer_fullname" class="form-control" required value="{{ old('customer_fullname') }}">
            </div>

            <div class="mb-3">
                <label>Product</label>
                <select name="product_id" id="product_id" class="form-control" required>
                    <option value="" disabled selected>Select a product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ \App\Http\Service\ProductService::getPrice($product->id) }}" data-stock="{{ $product->quantity }}"
                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->product_name }} ({{ $product->quantity }} in stock)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" min="1" required value="{{ old('quantity') }}">
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Price</label>
                    <input type="text" id="price" name="price" class="form-control" disabled required>
                </div>
                <div class="col-md-4">
                    <label>Tax (12%)</label>
                    <input type="text" id="tax" class="form-control" disabled>
                </div>
                <div class="col-md-4">
                    <label>Total Price</label>
                    <input type="text" id="total_price" class="form-control" disabled>
                </div>
            </div>

            <div class="mb-3">
                <label>User</label>
                <select name="user_id" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Order Comment Field -->
            <div class="mb-3">
                <label>Customer Comment</label>
                <textarea name="comment_text" class="form-control">{{ old('comment_text') }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Create Order</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const productSelect = document.getElementById("product_id");
            const quantityInput = document.getElementById("quantity");
            const priceInput = document.getElementById("price");
            const taxInput = document.getElementById("tax");
            const totalPriceInput = document.getElementById("total_price");
            const TAX_RATE = 0.12; // 12%

            function calculatePrice() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const pricePerUnit = parseFloat(selectedOption.dataset.price || 0);
                const availableStock = parseInt(selectedOption.dataset.stock || 0);
                let quantity = parseInt(quantityInput.value) || 1;

                if (quantity > availableStock) {
                    alert(`Only ${availableStock} items are in stock.`);
                    quantityInput.value = availableStock;
                    quantity = availableStock;
                }

                const subtotal = pricePerUnit * quantity;
                const tax = subtotal * TAX_RATE;
                const total = subtotal + tax;

                priceInput.value = subtotal.toFixed(2);
                taxInput.value = tax.toFixed(2);
                totalPriceInput.value = total.toFixed(2);
            }

            function toggleQuantityInput() {
                if (productSelect.value) {
                    const selectedOption = productSelect.options[productSelect.selectedIndex];
                    const availableStock = parseInt(selectedOption.dataset.stock || 0);
                    quantityInput.disabled = false;
                    quantityInput.value = 1;
                    quantityInput.setAttribute("max", availableStock);
                    calculatePrice();
                } else {
                    quantityInput.disabled = true;
                    quantityInput.value = "";
                    priceInput.value = "";
                    taxInput.value = "";
                    totalPriceInput.value = "";
                }
            }

            productSelect.addEventListener("change", toggleQuantityInput);
            quantityInput.addEventListener("input", calculatePrice);

            // Initialize state on page load
            toggleQuantityInput();
        });
    </script>

@endsection
