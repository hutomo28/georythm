<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cartItems = Auth::user()->carts()->with('product')->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $totalFormatted = 'Rp '.number_format($subtotal, 0, ',', '.');

        return view('customer.cart.index', compact('cartItems', 'subtotal', 'totalFormatted'));
    }

    /**
     * Store a new item in the cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string',
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);

        $sizeRecord = $product->sizes()->where('size', $request->size)->first();
        $availableStock = $sizeRecord ? $sizeRecord->stock : $product->stock;

        // Block if product is out of stock
        if ($availableStock <= 0) {
            return redirect()->back()->with('error', "Sorry, size {$request->size} is currently out of stock.");
        }

        // Check if item already exists in cart with same size
        $existingCart = Cart::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->where('size', $request->size)
            ->first();

        if ($existingCart) {
            $newQty = $existingCart->quantity + $request->quantity;
            // Cap quantity to available stock
            if ($newQty > $availableStock) {
                $newQty = $availableStock;
            }
            $existingCart->update(['quantity' => $newQty]);
        } else {
            $qty = min($request->quantity, $availableStock);
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'quantity' => $qty,
                'size' => $request->size,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, Cart $cart)
    {
        // Ensure the cart item belongs to the user
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Cap quantity to available stock
        $maxStock = 0;
        if ($cart->product) {
            $sizeRecord = $cart->product->sizes()->where('size', $cart->size)->first();
            $maxStock = $sizeRecord ? $sizeRecord->stock : $cart->product->stock;
        }

        $qty = min($request->quantity, $maxStock);
        if ($qty < 1) $qty = 1;

        $cart->update(['quantity' => $qty]);

        return redirect()->back()->with('success', 'Cart updated!');
    }

    /**
     * Remove an item from the cart.
     */
    public function destroy(Cart $cart)
    {
        // Ensure the cart item belongs to the user
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->back()->with('success', 'Item removed from cart!');
    }
}
