<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function print(Order $order)
    {
        $order->load('orderItems.meal', 'user');
        return view('invoices.print', compact('order'));
    }

    public function printKitchenOrder(Order $order)
    {
        $order->load('orderItems.meal');
        return view('invoices.kitchen-order', compact('order'));
    }

    public function printDelivery(Order $order)
    {
        if (!$order->has_delivery) {
            return redirect()->back()->with('error', 'هذا الطلب لا يحتوي على توصيل');
        }

        $order->load('orderItems.meal', 'user');
        return view('invoices.delivery', compact('order'));
    }
}
