<?php

namespace App\Http\Controllers;

use App\Http\Service\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getAllOrders();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $data = $this->orderService->getCreateFormData();
        return view('orders.create', $data);
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

        $result = $this->orderService->createOrder($validated);
        if (isset($result['error'])) {
            return redirect()->back()->withErrors(['quantity' => $result['error']])->withInput();
        }

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    public function show($id)
    {
        $order = $this->orderService->getOrderDetails($id);
        return view('orders.show', compact('order'));
    }

    public function edit($id)
    {
        $data = $this->orderService->getEditFormData($id);
        return view('orders.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_fullname' => 'required|string|max:255',
            'order_status_id' => 'required|integer',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $this->orderService->updateOrder($id, $validated);
        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }

    public function markAsFinished($id)
    {
        $this->orderService->markOrderAsFinished($id);
        return redirect()->route('orders.show', $id)->with('success', 'Order marked as finished!');
    }

    public function destroy($id)
    {
        $this->orderService->deleteOrder($id);
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }
}
