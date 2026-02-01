<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getDailyReport($date = null)
    {
        $date = $date ? Carbon::parse($date) : Carbon::today();

        $orders = Order::whereDate('created_at', $date)
            ->where('status', 'completed')
            ->get();

        $totalSales = $orders->sum('total_amount');
        $totalTax = $orders->sum('tax_amount');
        $totalNonTaxable = $orders->sum('non_taxable_amount');
        $totalOrders = $orders->count();

        $cashSales = $orders->where('payment_method', 'cash')->sum('total_amount');
        $cardSales = $orders->where('payment_method', 'card')->sum('total_amount');

        $deliveryOrders = $orders->where('has_delivery', true)->count();
        $deliveryAmount = $orders->where('has_delivery', true)->sum('delivery_amount');

        // Sales by meal
        $salesByMeal = OrderItem::whereHas('order', function ($query) use ($date) {
            $query->whereDate('created_at', $date)
                ->where('status', 'completed');
        })
            ->select('meal_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(subtotal) as total_amount'))
            ->groupBy('meal_id')
            ->with('meal')
            ->get();

        return [
            'date' => $date->format('Y-m-d'),
            'total_sales' => $totalSales,
            'total_tax' => $totalTax,
            'total_non_taxable' => $totalNonTaxable,
            'total_orders' => $totalOrders,
            'cash_sales' => $cashSales,
            'card_sales' => $cardSales,
            'delivery_orders' => $deliveryOrders,
            'delivery_amount' => $deliveryAmount,
            'sales_by_meal' => $salesByMeal,
            'orders' => $orders,
        ];
    }
}
