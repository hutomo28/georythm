<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display the account page with user data, addresses, orders, and order status counts.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get the user's default address (or latest)
        $address = $user->defaultAddress();

        // Get all addresses
        $addresses = $user->addresses()->latest()->get();

        // Count orders by status for the status circles
        $statusCounts = [
            'menunggu-pembayaran' => $user->orders()->where('status', 'menunggu-pembayaran')->count(),
            'sedang-dikemas' => $user->orders()->where('status', 'sedang-dikemas')->count(),
            'sedang-dikirim' => $user->orders()->where('status', 'sedang-dikirim')->count(),
            'pesanan-tiba' => $user->orders()->where('status', 'pesanan-tiba')->count(),
        ];

        // Get completed orders (history) with their items and products
        $completedOrders = $user->orders()
            ->where('status', 'selesai')
            ->with(['items.product'])
            ->latest()
            ->get();

        return view('customer.account.index', compact(
            'user',
            'address',
            'addresses',
            'statusCounts',
            'completedOrders'
        ));
    }

    /**
     * Show the create address form.
     */
    public function createAddress()
    {
        return view('customer.account.address.create');
    }

    /**
     * Store a new address.
     */
    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'negara' => 'required|string|max:100',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'apartemen' => 'nullable|string|max:200',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'zip' => 'required|string|max:10',
        ]);

        $user = $request->user();

        // If this is the first address, make it default
        $isDefault = $user->addresses()->count() === 0;

        $user->addresses()->create([
            'country' => $validated['negara'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'address' => $validated['alamat'],
            'apartment' => $validated['apartemen'] ?? null,
            'city' => $validated['kota'],
            'province' => $validated['provinsi'],
            'zip' => $validated['zip'],
            'is_default' => $isDefault,
        ]);

        return redirect()->route('account.index')->with('success', 'Berhasil menambahkan alamat baru');
    }
}
