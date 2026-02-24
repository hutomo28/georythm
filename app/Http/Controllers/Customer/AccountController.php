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
            'waiting-payment' => $user->orders()->where('status', 'waiting-payment')->count(),
            'processing' => $user->orders()->where('status', 'processing')->count(),
            'shipped' => $user->orders()->where('status', 'shipped')->count(),
            'arrived' => $user->orders()->where('status', 'arrived')->count(),
        ];

        // Get completed orders (history) with their items and products
        $completedOrders = $user->orders()
            ->where('status', 'completed')
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
            'country' => 'required|string|max:100',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'apartment' => 'nullable|string|max:200',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'zip' => 'required|string|max:10',
        ]);

        $user = $request->user();

        // If this is the first address, make it default
        $isDefault = $user->addresses()->count() === 0;

        $user->addresses()->create([
            'country' => $validated['country'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'apartment' => $validated['apartment'] ?? null,
            'city' => $validated['city'],
            'province' => $validated['province'],
            'zip' => $validated['zip'],
            'is_default' => $isDefault,
        ]);

        return redirect()->route('account.index')->with('success', 'New address added successfully');
    }

    /**
     * Set an address as the default (main) address.
     */
    public function setMainAddress(Request $request, Address $address)
    {
        // Ensure the address belongs to the user
        if ($address->user_id !== $request->user()->id) {
            abort(403);
        }

        // Set all other addresses for this user to not default
        $request->user()->addresses()->update(['is_default' => false]);

        // Set this address as default
        $address->update(['is_default' => true]);

        return redirect()->route('account.index')->with('success', 'Main address updated successfully');
    }

    /**
     * Delete an address.
     */
    public function destroyAddress(Request $request, Address $address)
    {
        // Ensure the address belongs to the user
        if ($address->user_id !== $request->user()->id) {
            abort(403);
        }

        // If it's the default, we might want to prevent deletion or pick a new default
        $wasDefault = $address->is_default;

        $address->delete();

        // If the deleted address was default, set a new one if any exist
        if ($wasDefault) {
            $newDefault = $request->user()->addresses()->latest()->first();
            if ($newDefault) {
                $newDefault->update(['is_default' => true]);
            }
        }

        return redirect()->route('account.index')->with('success', 'Address deleted successfully');
    }
}
