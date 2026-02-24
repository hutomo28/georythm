<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function status(Request $request)
    {
        $status = $request->query('status', 'waiting-payment');

        $titles = [
            'waiting-payment' => 'Waiting Payment',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'arrived' => 'Arrived',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        $title = $titles[$status] ?? 'Order Status';

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
            $filename = time() . '_' . $file->getClientOriginalName();
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

        // Logical check: Order must be in 'arrived' status
        if ($order->status !== 'arrived') {
            return redirect()->back()->with('error', 'Only orders that have arrived can be confirmed.');
        }

        $order->update(['status' => 'completed']);

        return redirect()->route('order.status', ['status' => 'completed'])->with('success', 'Thank you! Your order has been completed.');
    }
}
