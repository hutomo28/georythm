<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the welcome page with new arrivals.
     */
    public function welcome()
    {
        $newArrivals = Product::latest()->limit(4)->get();
        return view('customer.welcome', compact('newArrivals'));
    }

    /**
     * Display the lookbook page.
     */
    public function lookbook()
    {
        return view('customer.lookbook');
    }

    /**
     * Display the brand story page.
     */
    public function story()
    {
        return view('customer.story');
    }

    /**
     * Display a listing of products, optionally filtered by category.
     */
    public function index(Request $request, ?string $categorySlug = null)
    {
        $mapping = [
            'natgeo' => 'National Geographic',
            'tnf' => 'The North Face',
            'arcteryx' => 'Arc\'teryx',
            'columbia' => 'Columbia',
        ];

        $query = Product::query();
        $title = 'All Products';

        if ($categorySlug && isset($mapping[$categorySlug])) {
            $brandName = $mapping[$categorySlug];
            $query->where('category', $brandName);
            $title = $brandName;
        }

        // Handle Search Query
        if ($request->has('q') && !empty($request->q)) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('category', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
            $title = "Search Results for '{$search}'";
        }

        $products = $query->latest()->get()->map(function ($product) {
            return [
            'id' => $product->id,
            'name' => $product->name,
            'brand' => $product->category,
            'image' => $product->image,
            'image2' => $product->image2,
            'price' => $product->formatted_price,
            ];
        });

        return view('customer.products.index', compact('title', 'products'));
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Add some dummy data for the detail page if needed, or just pass the model
        $product->formatted_price = 'Rp ' . number_format($product->price, 0, ',', '.');

        return view('customer.products.show', compact('product'));
    }
}
