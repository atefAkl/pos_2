<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Meal;
use App\Models\PosSession;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $todayOrders = Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->count();

        $todaySales = Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->sum('total_amount');

        $availableMeals = Meal::where('is_available', true)->count();
        $totalMeals = Meal::count();

        $openSession = PosSession::where('status', 'open')
            ->where('user_id', auth()->id())
            ->first();

        $recentOrders = Order::with('user', 'orderItems.meal')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'todayOrders',
            'todaySales',
            'availableMeals',
            'totalMeals',
            'openSession',
            'recentOrders'
        ));
    }
}
