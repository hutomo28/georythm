<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Get the route prefix based on the current user's role.
     */
    private function routePrefix(): string
    {
        return auth()->user()->isAdmin() ? 'admin' : 'officer';
    }

    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Display the product management page.
     */
    public function products()
    {
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // Validation for multiple images
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|string',
            'stock' => 'required|integer',
            'images' => 'required|array|min:1|max:3',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Simulation of file handling
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
            // In a real app: $image->store('products', 'public');
            }
        }

        return redirect()->route($this->routePrefix() . '.products')->with('success', 'Product added successfully with ' . count($request->file('images')) . ' images!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        // Simple simulation of deletion
        return redirect()->route($this->routePrefix() . '.products')->with('delete_success', 'Delete Product Success');
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation for update
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|string',
            'stock' => 'required|integer',
        ]);

        return redirect()->route($this->routePrefix() . '.products')->with('update_success', 'Update Product Success');
    }

    /**
     * Display the order management page.
     */
    public function orders()
    {
        return view('admin.orders.index');
    }

    /**
     * Display the user management page.
     */
    public function users()
    {
        return view('admin.users.index');
    }
}
