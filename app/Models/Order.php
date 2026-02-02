<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory, HasUserTracking;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'tax_amount',
        'non_taxable_amount',
        'status',
        'payment_method',
        'has_delivery',
        'delivery_amount',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'non_taxable_amount' => 'decimal:2',
        'delivery_amount' => 'decimal:2',
        'has_delivery' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
