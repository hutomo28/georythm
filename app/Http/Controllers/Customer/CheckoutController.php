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

        // Calculate dynamic shipping
        $shipping = $this->getShippingCost($address);

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
        if (! $address) {
            return redirect()->route('address.create')->with('error', 'Please add a shipping address first.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return ($item->product->price ?? 0) * $item->quantity;
        });

        // Calculate dynamic shipping
        $shipping = $this->getShippingCost($address);

        $total = $subtotal + $shipping;

        return DB::transaction(function () use ($user, $cartItems, $address, $shipping, $total, $request) {
            if (! $address) {
                throw new \Exception('Shipping address not found.');
            }

            // Check stock before creating order
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                if (! $product) {
                    throw new \Exception("A product in your cart is unavailable.");
                }

                $sizeStock = $product->stock;
                $sizeRecord = $product->sizes()->where('size', $cartItem->size)->first();
                if ($sizeRecord) {
                    $sizeStock = $sizeRecord->stock;
                }

                if ($sizeStock < $cartItem->quantity) {
                    throw new \Exception("Product '{$product->name}' (Size: {$cartItem->size}) is out of stock or has insufficient quantity.");
                }
            }

            // 1. Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'shipping_name' => $address->full_name,
                'shipping_phone' => $address->phone,
                'order_number' => 'ORD-'.strtoupper(uniqid()),
                'total' => $total,
                'status' => 'waiting-payment',
                'shipping_address' => $address->address.', '.$address->city.', '.$address->province.' '.$address->zip,
                'shipping_apartment' => $address->apartment,
                'shipping_city' => $address->city,
                'shipping_province' => $address->province,
                'shipping_zip' => $address->zip,
                'delivery_service' => $request->shipping_method ?? 'JNE',
                'shipping_cost' => $shipping,
            ]);

            // 2. Create Order Items & Decrement Stock
            foreach ($cartItems as $cartItem) {
                if (! $cartItem->product) {
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

                // Decrement stock
                $sizeRecord = $cartItem->product->sizes()->where('size', $cartItem->size)->first();
                if ($sizeRecord) {
                    $sizeRecord->decrement('stock', $cartItem->quantity);
                } else {
                    $cartItem->product->decrement('stock', $cartItem->quantity);
                }
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

    /**
     * Helper to calculate shipping cost based on country and province.
     */
    private function getShippingCost($address)
    {
        if (! $address) {
            return 0;
        }

        $country = strtolower($address->country);
        
        // If Country is Indonesia or empty
        if ($country === 'indonesia' || empty($country)) {
            $province = strtolower($address->province);
            $isJawaBarat = str_contains($province, 'jawa barat') || str_contains($province, 'west java');

            $otherJava = [
                'jakarta', 'dki jakarta', 'banten',
                'jawa tengah', 'central java',
                'jawa timur', 'east java',
                'yogyakarta', 'di yogyakarta',
            ];

            $isOtherJava = false;
            foreach ($otherJava as $pj) {
                if (str_contains($province, $pj)) {
                    $isOtherJava = true;
                    break;
                }
            }

            if ($isJawaBarat) {
                return 14000;
            } elseif ($isOtherJava) {
                return 22000; 
            } else {
                return 39000;
            }
        }

        // ASEAN Countries (Excluding Indonesia)
        $asean = [
            'malaysia', 'singapore', 'thailand', 'philippines', 'vietnam', 
            'myanmar', 'laos', 'cambodia', 'brunei', 'timor-leste', 'timor leste'
        ];

        foreach ($asean as $c) {
            if (str_contains($country, $c)) {
                return 120000; // 120k for ASEAN
            }
        }

        // Rest of the World
        return 300000; // 300k for outside ASEAN
    }
}
