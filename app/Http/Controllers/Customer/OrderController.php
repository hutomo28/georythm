<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function status(Request $request)
    {
        $status = $request->query('status', 'waiting-payment');

        $titles = [
            'waiting-payment' => __('customer.waiting_payment'),
            'processing' => __('customer.processing'),
            'shipped' => __('customer.shipped_status'),
            'arrived' => __('customer.arrived_status'),
            'completed' => __('customer.completed_status'),
            'cancelled' => __('customer.cancelled_status'),
        ];

        $title = $titles[$status] ?? 'Order Status';

        // Auto-complete orders that have been 'arrived' for more than 48 hours
        Order::where('status', 'arrived')
            ->where('user_id', Auth::id())
            ->where('arrived_at', '<=', now()->subHours(48))
            ->update(['status' => 'completed']);

        // Fetch all orders with this status for the user
        $orders = Order::where('user_id', Auth::id())
            ->where('status', $status)
            ->with(['items.product', 'payment'])
            ->latest()
            ->get();

        return view('customer.order.status', compact('title', 'status', 'orders'));
    }

    public function uploadPayment(Request $request, Order $order)
    {
        $request->validate([
            'sender_name' => 'required|string|max:255',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('payments', $filename, 'public');

            // Update or Create Payment
            $order->payment()->updateOrCreate(
                ['order_id' => $order->id],
                [
                    'sender_name' => $request->sender_name,
                    'proof_image' => $path,
                    'amount' => $order->total,
                    'status' => 'pending',
                ]
            );

            return redirect()->back()->with('success', 'Payment proof uploaded successfully! Please wait for admin confirmation.');
        }

        return redirect()->back()->with('error', 'Failed to upload payment proof.');
    }

    public function confirmReceived(Order $order)
    {
        // Security check: Order must belong to the user
        if ($order->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Logical check: Order must be in 'shipped' or 'arrived' status
        if (!in_array($order->status, ['shipped', 'arrived'])) {
            return redirect()->back()->with('error', 'Only orders that have been shipped can be confirmed.');
        }

        $order->update(['status' => 'completed']);

        // Redirect to a review page for this specific order
        return redirect()->route('order.review', $order->id)->with('success', 'Thank you! Your order has been completed. Please share your feedback.');
    }

    /**
     * Cancel an order and restore stock.
     */
    public function cancelOrder(Request $request, Order $order)
    {
        // Security check: Order must belong to the user
        if ($order->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Only allow cancellation for waiting-payment or processing
        if (!in_array($order->status, ['waiting-payment', 'processing'])) {
            return redirect()->back()->with('error', 'This order cannot be cancelled.');
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:1000',
        ]);

        // Restore stock for each item
        foreach ($order->items as $item) {
            if ($item->product) {
                $productSize = \App\Models\ProductSize::where('product_id', $item->product_id)
                    ->where('size', $item->size)
                    ->first();

                if ($productSize) {
                    $productSize->increment('stock', $item->quantity);
                }
            }
        }

        $order->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        return redirect()->route('order.status', ['status' => 'cancelled'])->with('success', 'Order has been cancelled successfully.');
    }

    /**
     * Show the review form for an order.
     */
    public function review(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'completed') {
            return redirect()->route('order.status', ['status' => $order->status]);
        }

        $order->load('items.product');

        return view('customer.order.review', compact('order'));
    }

    /**
     * Store reviews for an order.
     */
    public function storeReview(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'ratings' => 'required|array',
            'ratings.*' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|array',
            'comments.*' => 'nullable|string',
        ]);

        foreach ($order->items as $item) {
            if (isset($request->ratings[$item->product_id])) {
                Review::updateOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'product_id' => $item->product_id,
                    ],
                    [
                        'rating' => $request->ratings[$item->product_id],
                        'comment' => $request->comments[$item->product_id] ?? null,
                    ]
                );
            }
        }

        return redirect()->route('order.status', ['status' => 'completed'])->with('success', 'Thank you for your review!');
    }
}
