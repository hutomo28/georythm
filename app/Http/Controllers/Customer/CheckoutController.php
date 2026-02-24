<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        $user = Auth::user();
        $cartItems = $user->carts()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $address = $user->defaultAddress();

        $subtotal = $cartItems->sum(function ($item) {
            return ($item->product->price ?? 0) * $item->quantity;
        });

        // Calculate dynamic shipping (Province-based)
        $shipping = 0;
        if ($address) {
            $province = strtolower($address->province);
            $isJawaBarat = str_contains($province, 'jawa barat') || str_contains($province, 'west java');

            $otherJava = [
                'jakarta', 'dki jakarta', 'banten',
                'jawa tengah', 'central java',
                'jawa timur', 'east java',
                'yogyakarta', 'di yogyakarta'
            ];

            $isOtherJava = false;
            foreach ($otherJava as $pj) {
                if (str_contains($province, $pj)) {
                    $isOtherJava = true;
                    break;
                }
            }

            if ($isJawaBarat) {
                $shipping = 14000;
            }
            elseif ($isOtherJava) {
                $shipping = 22000; // 14k + 8k
            }
            else {
                $shipping = 39000; // 14k + 25k
            }
        }

        $total = $subtotal + $shipping;

        return view('customer.checkout.index', compact('user', 'cartItems', 'address', 'subtotal', 'shipping', 'total'));
    }

    /**
     * Process the order.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = $user->carts()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $address = $user->defaultAddress();
        if (!$address) {
            return redirect()->route('address.create')->with('error', 'Please add a shipping address first.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return ($item->product->price ?? 0) * $item->quantity;
        });

        // Calculate dynamic shipping (Province-based)
        $province = strtolower($address->province);
        $isJawaBarat = str_contains($province, 'jawa barat') || str_contains($province, 'west java');

        $otherJava = [
            'jakarta', 'dki jakarta', 'banten',
            'jawa tengah', 'central java',
            'jawa timur', 'east java',
            'yogyakarta', 'di yogyakarta'
        ];

        $isOtherJava = false;
        foreach ($otherJava as $pj) {
            if (str_contains($province, $pj)) {
                $isOtherJava = true;
                break;
            }
        }

        if ($isJawaBarat) {
            $shipping = 14000;
        }
        elseif ($isOtherJava) {
            $shipping = 22000; // 14k + 8k
        }
        else {
            $shipping = 39000; // 14k + 25k
        }

        $total = $subtotal + $shipping;

        return DB::transaction(function () use ($user, $cartItems, $address, $subtotal, $shipping, $total, $request) {
            if (!$address) {
                throw new \Exception('Shipping address not found.');
            }

            // 1. Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'shipping_name' => $address->full_name,
                'shipping_phone' => $address->phone,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'total' => $total,
                'status' => 'waiting-payment',
                'shipping_address' => $address->address . ', ' . $address->city . ', ' . $address->province . ' ' . $address->zip,
                'shipping_apartment' => $address->apartment,
                'shipping_city' => $address->city,
                'shipping_province' => $address->province,
                'shipping_zip' => $address->zip,
                'delivery_service' => $request->shipping_method ?? 'JNE',
                'shipping_cost' => $shipping,
            ]);

            // 2. Create Order Items
            foreach ($cartItems as $cartItem) {
                if (!$cartItem->product) {
                    continue;
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'price' => $cartItem->product->price,
                    'size' => $cartItem->size,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->product->price * $cartItem->quantity,
                ]);

                // 3. Subtract stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // 4. Create Payment Placeholder
            Payment::create([
                'order_id' => $order->id,
                'amount' => $total,
                'status' => 'pending',
                'payment_method' => 'bank_transfer',
            ]);

            // 5. Clear Cart
            $user->carts()->delete();

            return redirect()->route('order.status', ['status' => 'waiting-payment'])->with('success', 'Order placed successfully!');
        });
    }
}
