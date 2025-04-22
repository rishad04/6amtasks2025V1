<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class FrontendLandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans_frontend = SubscriptionPlan::where('is_active', 1)->orderBy('order', 'asc')->take(3)->get();

        return view('frontend.landing_Page_index', compact('plans_frontend'));
    }

    public function loginFormShow()
    {

        return view('frontend.login_form');
    }

    public function registerFormShow()
    {
        return view('frontend.register_form');
    }

    public function productsCasched($slug = null)
    {
        // Start timing
        $startTime = microtime(true);

        // Cache key changes based on slug
        $cacheKey = $slug ? 'products_category_' . $slug : 'all_products';

        Log::info('Cache Key: ' . $cacheKey);

        // Cache product categories (shared)
        $product_categories = Cache::remember('product_categories', now()->addHours(1), function () {
            return ProductCategory::where('is_active', 1)->get();
        });

        Log::info('Cache Key for Product Categories: product_categories');
        // Cache products based on slug
        $products = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($slug) {
            $query = Product::query();

            if ($slug) {
                $query->whereHas('productCategory', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                });
            }

            return $query->paginate(20);
        });

        Log::info('Cache Key for Products: ' . $cacheKey);

        // Log execution time
        $executionTime = microtime(true) - $startTime;
        $backend_loading_time = number_format($executionTime, 4);
        Log::info('Execution Time for Non Cached products method: ' . number_format($executionTime, 4) . ' seconds');

        // Return view with products and categories
        return view('frontend.products_cached', compact('products', 'product_categories', 'backend_loading_time'));
    }

    public function products($slug = null)
    {
        // Start timing
        $startTime = microtime(true);

        // Cache key changes based on slug
        $cacheKey = $slug ? 'products_category_' . $slug : 'all_products';

        // Get product categories
        $product_categories = ProductCategory::where('is_active', 1)->get();

        // Get products based on slug
        $query = Product::query();

        if ($slug) {
            $query->whereHas('productCategory', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        // Paginate the results (no caching)
        $products = $query->paginate(20);

        // Log execution time
        $executionTime = microtime(true) - $startTime;
        $backend_loading_time = number_format($executionTime, 4);
        Log::info('Execution Time for Non Cached products method: ' . number_format($executionTime, 4) . ' seconds');

        // Return view with products and categories
        return view('frontend.products', compact('products', 'product_categories', 'backend_loading_time'));
    }

    public function productDetails(string $slug)
    {

        $startTime = microtime(true);

        $product_categories = ProductCategory::where('is_active', 1)->get();
        $latest_products    = Product::orderby('created_at', 'desc')->take(10)->get();
        $product            = Product::where('slug', $slug)->first();

        $executionTime = microtime(true) - $startTime;

        $backend_loading_time = number_format($executionTime, 4);

        Log::info('Execution Time for Non-Cached product-Details method: ' . number_format($executionTime, 4) . ' seconds');

        return view('frontend.product_details', compact('product', 'product_categories', 'latest_products', 'backend_loading_time'));
    }

    public function productDetailsCached(string $slug)
    {
        $startTime = microtime(true);

        // Cache the product categories for 1 hour
        $product_categories = cache()->remember('product_categories', 60 * 60, function () {
            return ProductCategory::where('is_active', 1)->get();
        });

        // Cache the latest products for 30 minutes
        $latest_products = cache()->remember('latest_products', 30 * 60, function () {
            return Product::orderby('created_at', 'desc')->take(10)->get();
        });

        // Cache the specific product for 15 minutes using the product slug as a unique key
        $cacheKey = "product_details_{$slug}";
        $product = cache()->remember($cacheKey, 15 * 60, function () use ($slug) {
            return Product::where('slug', $slug)->first();
        });

        $executionTime = microtime(true) - $startTime;

        $backend_loading_time = number_format($executionTime, 4);

        Log::info('Execution Time for Cached product-Details method: ' . number_format($executionTime, 4) . ' seconds');

        return view('frontend.product_details_cached', compact('product', 'product_categories', 'latest_products', 'backend_loading_time'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
