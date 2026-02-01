@extends('layouts.app')

@section('title', 'تفاصيل الطلب')

@section('content')
<div class="row mb-3">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h2>تفاصيل الطلب: {{ $order->order_number }}</h2>
        <div>
            <a href="{{ route('invoices.print', $order->id) }}" class="btn btn-primary" target="_blank">طباعة الفاتورة</a>
            <a href="{{ route('invoices.kitchen-order', $order->id) }}" class="btn btn-success" target="_blank">طباعة أوردر الطبخ</a>
            @if($order->has_delivery)
            <a href="{{ route('invoices.delivery', $order->id) }}" class="btn btn-info" target="_blank">طباعة فاتورة التوصيل</a>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>عناصر الطلب</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>الوجبة</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>المجموع</th>
                            <th>خاضع للضريبة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->meal->name_ar }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 2) }} جنيه</td>
                            <td>{{ number_format($item->subtotal, 2) }} جنيه</td>
                            <td>{{ $item->is_taxable ? 'نعم' : 'لا' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>معلومات الطلب</h5>
            </div>
            <div class="card-body">
                <p><strong>رقم الطلب:</strong> {{ $order->order_number }}</p>
                <p><strong>التاريخ:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                <p><strong>المستخدم:</strong> {{ $order->user->name }}</p>
                <p><strong>الحالة:</strong> 
                    <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'warning' }}">
                        {{ $order->status === 'completed' ? 'مكتمل' : 'قيد الانتظار' }}
                    </span>
                </p>
                <hr>
                <p><strong>المجموع الفرعي:</strong> {{ number_format($order->total_amount - $order->tax_amount - ($order->delivery_amount ?? 0), 2) }} جنيه</p>
                <p><strong>الضريبة:</strong> {{ number_format($order->tax_amount, 2) }} جنيه</p>
                @if($order->non_taxable_amount > 0)
                <p><strong>غير خاضع للضريبة:</strong> {{ number_format($order->non_taxable_amount, 2) }} جنيه</p>
                @endif
                @if($order->has_delivery && $order->delivery_amount)
                <p><strong>التوصيل:</strong> {{ number_format($order->delivery_amount, 2) }} جنيه</p>
                @endif
                <hr>
                <p class="h4"><strong>الإجمالي:</strong> {{ number_format($order->total_amount, 2) }} جنيه</p>
                <p><strong>طريقة الدفع:</strong> {{ $order->payment_method === 'cash' ? 'نقدي' : 'بطاقة' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
