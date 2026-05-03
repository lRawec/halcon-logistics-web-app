<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalOrders = Order::count();
        $activeOrders = Order::where('status', '!=', 'Delivered')->count();
        $deliveredOrders = Order::where('status', 'Delivered')->count();
        $trashedOrders = Order::onlyTrashed()->count();

        $recentOrders = Order::with(['customer', 'user'])
            ->latest('created_at')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'user',
            'totalOrders',
            'activeOrders',
            'deliveredOrders',
            'trashedOrders',
            'recentOrders'
        ));
    }
}
