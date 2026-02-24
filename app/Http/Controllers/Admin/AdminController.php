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
        // Money In: All orders not cancelled or waiting for payment
        $paidStatus = ['processing', 'shipped', 'arrived', 'completed'];
        $moneyIn = \App\Models\Order::whereIn('status', $paidStatus)->sum('total');

        // As per user request: Profit = 20% of each product
        $profit = $moneyIn * 0.20;
        $moneyOut = $moneyIn * 0.80;

        $totalOrders = \App\Models\Order::count();
        $totalUsers = \App\Models\User::count();
        $totalProducts = \App\Models\Product::count();

        // Top Selling Products (simplified logic for now)
        $topSellingItems = \App\Models\OrderItem::select('product_id', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_sales'))
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->limit(5)
            ->with('product')
            ->get();

        $routePrefix = $this->routePrefix();
        return view('admin.dashboard', compact(
            'moneyIn',
            'moneyOut',
            'profit',
            'totalOrders',
            'totalUsers',
            'totalProducts',
            'topSellingItems',
            'routePrefix'
        ));
    }

    /**
     * Display the financial report page.
     */
    public function financeReport()
    {
        $paidStatus = ['processing', 'shipped', 'arrived', 'completed'];

        $moneyIn = \App\Models\Order::whereIn('status', $paidStatus)->sum('total');
        $profit = $moneyIn * 0.20;
        $moneyOut = $moneyIn * 0.80;

        $recentPaidOrders = \App\Models\Order::whereIn('status', $paidStatus)
            ->with('user')
            ->latest()
            ->paginate(15);

        $routePrefix = $this->routePrefix();
        return view('admin.finance.index', compact(
            'moneyIn',
            'moneyOut',
            'profit',
            'recentPaidOrders',
            'routePrefix'
        ));
    }

    /**
     * Display the product management page.
     */
    public function products()
    {
        $products = \App\Models\Product::latest()->paginate(10);
        $routePrefix = $this->routePrefix();
        return view('admin.products.index', compact('products', 'routePrefix'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $routePrefix = $this->routePrefix();
        return view('admin.products.create', compact('routePrefix'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // Validation for multiple images
        // Sanitize price before validation
        $request->merge([
            'price' => str_replace(['Rp', '.', ','], '', $request->price)
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:99999999999999',
            'stock' => 'required|integer|min:0',
            'images' => 'required|array|min:1|max:3',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Create Product
        $productData = [
            'name' => $request->name,
            'brand' => $request->brand,
            'category' => $request->brand, // Map brand to category as per our convention
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ];

        // Create directory if not exists
        $uploadPath = public_path('products');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Map images
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $fields = ['image', 'image2', 'image3'];

            foreach ($images as $index => $file) {
                if ($index < 3) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move($uploadPath, $filename);
                    $productData[$fields[$index]] = $filename;
                }
            }
        }

        \App\Models\Product::create($productData);

        return redirect()->route($this->routePrefix() . '.products')->with('success', 'Product added successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return redirect()->route($this->routePrefix() . '.products')->with('delete_success', 'Product deleted successfully!');
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        // Sanitize price before validation
        $request->merge([
            'price' => str_replace(['Rp', '.', ','], '', $request->price)
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:99999999999999',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $product = \App\Models\Product::findOrFail($id);

        $productData = [
            'name' => $request->name,
            'brand' => $request->brand,
            'category' => $request->brand,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ];

        // Create directory if not exists
        $uploadPath = public_path('products');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $fields = ['image', 'image2', 'image3'];

            foreach ($images as $index => $file) {
                if ($index < 3) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move($uploadPath, $filename);
                    $productData[$fields[$index]] = $filename;
                }
            }
        }

        $product->update($productData);

        return redirect()->route($this->routePrefix() . '.products')->with('update_success', 'Product updated successfully!');
    }

    /**
     * Add stock to a product and log the history.
     */
    public function addStock(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        $product = \App\Models\Product::findOrFail($id);

        // Update product stock
        $product->increment('stock', $request->amount);

        // Log the change
        \App\Models\ProductStockLog::create([
            'product_id' => $product->id,
            'amount' => $request->amount,
            'type' => 'in',
            'description' => $request->description ?: 'Manual stock addition',
        ]);

        return redirect()->back()->with('success', 'Stock added successfully and logged!');
    }

    /**
     * Get stock history for a product (JSON for modal).
     */
    public function getStockHistory($id)
    {
        $history = \App\Models\ProductStockLog::where('product_id', $id)
            ->latest()
            ->get()
            ->map(function ($log) {
            return [
            'date' => $log->created_at->format('d M Y H:i'),
            'amount' => $log->amount,
            'type' => $log->type,
            'description' => $log->description,
            ];
        });

        return response()->json($history);
    }

    /**
     * Display the order management page.
     */
    public function orders()
    {
        $orders = \App\Models\Order::with(['user', 'items.product'])->latest()->paginate(10);
        $routePrefix = $this->routePrefix();
        return view('admin.orders.index', compact('orders', 'routePrefix'));
    }

    /**
     * Display the user management page.
     */
    public function users()
    {
        $users = \App\Models\User::latest()->paginate(10);
        $routePrefix = $this->routePrefix();
        return view('admin.users.index', compact('users', 'routePrefix'));
    }

    /**
     * Display the user management page.
     */
    /**
     * Update order status.
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $order = \App\Models\Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->route($this->routePrefix() . '.orders')->with('success', 'Order status updated successfully!');
    }

    /**
     * Update order shipment info.
     */
    public function updateOrderShipment(Request $request, $id)
    {
        $request->validate([
            'receipt_number' => 'required|string',
        ]);

        $order = \App\Models\Order::findOrFail($id);
        $order->update([
            'status' => 'shipped',
            'receipt_number' => $request->receipt_number,
            'delivery_service' => $request->delivery_service ?? 'JNE',
        ]);

        return redirect()->route($this->routePrefix() . '.orders')->with('success', 'Shipping info updated!');
    }

    /**
     * Store a new user (Admin/Officer).
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:admin,officer',
            'password' => 'required|string|min:8',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return redirect()->route($this->routePrefix() . '.users')->with('success', 'User created successfully!');
    }

    /**
     * Delete a user.
     */
    public function destroyUser($id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself!');
        }

        $user->delete();
        return redirect()->route($this->routePrefix() . '.users')->with('success', 'User deleted successfully!');
    }
}
