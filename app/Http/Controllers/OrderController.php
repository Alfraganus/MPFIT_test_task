<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderComment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['product', 'user'])->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get();
        $users = User::all();
        return view('orders.create', compact('products', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_fullname' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'comment_text' => 'string|nullable',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->quantity < $validated['quantity']) {
            return redirect()->back()->withErrors(['quantity' => 'Not enough stock available'])->withInput();
        }

        $pricePerUnit = $product->price * 100;
        $subtotal = $pricePerUnit * $validated['quantity'];
        $tax = $subtotal * 0.12;
        $totalPrice = $subtotal + $tax;

        $validated['price'] = $totalPrice;

        $order = Order::create($validated);
        $product->decrement('quantity', $validated['quantity']);

        if (!empty($validated['comment_text'])) {
            OrderComment::create([
                'order_id' => $order['id'],
                'user_id' => $validated['user_id'],
                'comment_text' => $validated['comment_text'],
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    public function markAsFinished($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['order_status_id' => 1]);

        return redirect()->route('orders.show', $order->id)->with('success', 'Order marked as finished!');
    }


    public function show(Order $order)
    {
        $order->load(['product', 'comments.user']);

        return view('orders.show', compact('order'));
    }


    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $products = Product::all();
        $users = User::all();
        return view('orders.edit', compact('order', 'products', 'users'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $validated = $request->validate([
            'customer_fullname' => 'required|string|max:255',
            'order_status_id' => 'required|integer',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $product = Product::find($order->product_id);

        $product->increment('quantity', $order->quantity);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }
}
