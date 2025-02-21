<?php

namespace App\Http\Service;

use App\Models\Order;
use App\Models\OrderComment;
use App\Models\Product;
use App\Models\User;

class OrderService
{
    const TAX = 0.12;

    public function getAllOrders()
    {
        return Order::with(['product', 'user'])->get();
    }

    public function getCreateFormData()
    {
        return [
            'products' => Product::where('quantity', '>', 0)->get(),
            'users' => User::all(),
        ];
    }

    public function createOrder(array $validated)
    {
        $product = Product::findOrFail($validated['product_id']);

        if ($product->quantity < $validated['quantity']) {
            return ['error' => 'Not enough stock available'];
        }

        $pricePerUnit = $product->price * 100;
        $subtotal = $pricePerUnit * $validated['quantity'];
        $tax = $subtotal * self::TAX;
        $totalPrice = $subtotal + $tax;

        $validated['price'] = $totalPrice;

        $order = Order::create($validated);
        $product->decrement('quantity', $validated['quantity']);

        if (!empty($validated['comment_text'])) {
            OrderComment::create([
                'order_id' => $order->id,
                'user_id' => $validated['user_id'],
                'comment_text' => $validated['comment_text'],
            ]);
        }

        return $order;
    }

    public function getOrderDetails($id)
    {
        return Order::with(['product', 'comments.user'])->findOrFail($id);
    }

    public function getEditFormData($id)
    {
        return [
            'order' => Order::findOrFail($id),
            'products' => Product::all(),
            'users' => User::all(),
        ];
    }

    public function updateOrder($id, array $validated)
    {
        $order = Order::findOrFail($id);
        $order->update($validated);
    }

    public function markOrderAsFinished($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['order_status_id' => 1]);
    }

    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $product = Product::find($order->product_id);

        if ($product) {
            $product->increment('quantity', $order->quantity);
        }

        $order->delete();
    }
}
