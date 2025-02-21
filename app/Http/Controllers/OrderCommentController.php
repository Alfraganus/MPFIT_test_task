<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\OrderComment;

class OrderCommentController extends Controller
{
    public function store(Request $request, $orderId)
    {
        $validated = $request->validate([
            'comment_text' => 'required|string|max:1000',
        ]);

        $randomUserId = User::inRandomOrder()->first()->id;

        OrderComment::create([
            'order_id' => $orderId,
            'user_id' => $request->input('user_id') ?? $randomUserId,
            'comment_text' => $validated['comment_text'],
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
