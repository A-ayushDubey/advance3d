<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class HomeController extends Controller
{
    // 🏠 CUSTOMER HOME PAGE
    public function index()
    {
        // Show latest products on homepage
        $products = Product::latest()->take(8)->get();

        return view('home', compact('products'));
    }


    // 📊 ADMIN DASHBOARD
    public function adminDashboard()
{
    $totalProducts = \App\Models\Product::count();
    $totalOrders = \App\Models\Order::count();
    $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
    $revenue = \App\Models\Order::where('payment_status', 'paid')->sum('total');

    // Monthly revenue (last 6 months)
    $monthlyRevenue = \App\Models\Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')
        ->where('payment_status', 'paid')
        ->groupBy('month')
        ->pluck('total','month');

    // Recent orders
    $recentOrders = \App\Models\Order::latest()->take(5)->get();

    // Top products
    $topProducts = \App\Models\OrderItem::selectRaw('product_id, SUM(quantity) as total_qty')
        ->groupBy('product_id')
        ->orderByDesc('total_qty')
        ->take(5)
        ->with('product')
        ->get();

    return view('admin.dashboard', compact(
        'totalProducts',
        'totalOrders',
        'pendingOrders',
        'revenue',
        'monthlyRevenue',
        'recentOrders',
        'topProducts'
    ));
}
}