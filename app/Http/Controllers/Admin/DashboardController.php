<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::pending()->count(),
            'paid_orders' => Order::paid()->count(),
            'total_revenue' => Order::paid()->sum('total'),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::paid()->whereDate('created_at', today())->sum('total'),
        ];

        $recentOrders = Order::with('items')
            ->latest()
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('stock', '<=', 10)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
    }
}