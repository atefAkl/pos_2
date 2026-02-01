<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(array $data, $userId)
    {
        return DB::transaction(function () use ($data, $userId) {
            $order = Order::create([
                'user_id' => $userId,
                'status' => 'pending',
                'payment_method' => $data['payment_method'] ?? 'cash',
                'has_delivery' => $data['has_delivery'] ?? false,
                'delivery_amount' => $data['delivery_amount'] ?? 0,
            ]);

            $taxableTotal = 0;
            $nonTaxableTotal = 0;

            foreach ($data['items'] as $item) {
                $meal = \App\Models\Meal::findOrFail($item['meal_id']);
                $subtotal = $meal->price * $item['quantity'];
                $isTaxable = $item['is_taxable'] ?? true;

                OrderItem::create([
                    'order_id' => $order->id,
                    'meal_id' => $item['meal_id'],
                    'quantity' => $item['quantity'],
                    'price' => $meal->price,
                    'subtotal' => $subtotal,
                    'is_taxable' => $isTaxable,
                ]);

                if ($isTaxable) {
                    $taxableTotal += $subtotal;
                } else {
                    $nonTaxableTotal += $subtotal;
                }
            }

            // Calculate tax (assuming 14% VAT)
            $taxRate = 0.14;
            $taxAmount = $taxableTotal * $taxRate;
            $totalAmount = $taxableTotal + $nonTaxableTotal + $taxAmount + ($order->delivery_amount ?? 0);

            $order->update([
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'non_taxable_amount' => $nonTaxableTotal,
                'status' => 'completed',
            ]);

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'payment_method' => $order->payment_method,
            ]);

            return $order->load('orderItems.meal', 'user');
        });
    }

    public function generateOrderNumber()
    {
        return 'ORD-' . strtoupper(uniqid());
    }
}
