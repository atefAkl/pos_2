<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة - {{ $order->order_number }}</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
        }
        body {
            font-family: Arial, sans-serif;
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .info {
            margin: 10px 0;
        }
        .items {
            margin: 15px 0;
        }
        .item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px dotted #ccc;
        }
        .total {
            border-top: 2px solid #000;
            padding-top: 10px;
            margin-top: 10px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>فاتورة</h2>
        <p>رقم الفاتورة: {{ $order->order_number }}</p>
    </div>

    <div class="info">
        <p><strong>التاريخ:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
        <p><strong>الكاشير:</strong> {{ $order->user->name }}</p>
    </div>

    <div class="items">
        @foreach($order->orderItems as $item)
        <div class="item">
            <div>
                <strong>{{ $item->meal->name_ar }}</strong>
                <br>
                <small>{{ $item->quantity }} × {{ number_format($item->price, 2) }}</small>
                @if(!$item->is_taxable)
                <br><small style="color: red;">(غير خاضع للضريبة)</small>
                @endif
            </div>
            <div>{{ number_format($item->subtotal, 2) }} جنيه</div>
        </div>
        @endforeach
    </div>

    <div class="total">
        <div class="total-row">
            <span>المجموع الفرعي:</span>
            <span>{{ number_format($order->total_amount - $order->tax_amount - ($order->delivery_amount ?? 0), 2) }} جنيه</span>
        </div>
        @if($order->non_taxable_amount > 0)
        <div class="total-row">
            <span>غير خاضع للضريبة:</span>
            <span>{{ number_format($order->non_taxable_amount, 2) }} جنيه</span>
        </div>
        @endif
        <div class="total-row">
            <span>الضريبة (14%):</span>
            <span>{{ number_format($order->tax_amount, 2) }} جنيه</span>
        </div>
        @if($order->has_delivery && $order->delivery_amount)
        <div class="total-row">
            <span>التوصيل:</span>
            <span>{{ number_format($order->delivery_amount, 2) }} جنيه</span>
        </div>
        @endif
        <div class="total-row" style="font-size: 18px; font-weight: bold;">
            <span>الإجمالي:</span>
            <span>{{ number_format($order->total_amount, 2) }} جنيه</span>
        </div>
        <div class="total-row">
            <span>طريقة الدفع:</span>
            <span>{{ $order->payment_method === 'cash' ? 'نقدي' : 'بطاقة' }}</span>
        </div>
    </div>

    <div class="footer">
        <p>شكراً لزيارتكم</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" class="btn btn-primary">طباعة</button>
        <button onclick="window.close()" class="btn btn-secondary">إغلاق</button>
    </div>

    <script>
        window.onload = function() {
            // Auto print if needed (can be disabled)
            // window.print();
        }
    </script>
</body>
</html>
