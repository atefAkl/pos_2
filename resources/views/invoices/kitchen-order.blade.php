<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أوردر الطبخ - {{ $order->order_number }}</title>
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
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
        }
        .item-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .item-quantity {
            font-size: 24px;
            color: #d32f2f;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>أوردر الطبخ</h2>
        <p>رقم الطلب: {{ $order->order_number }}</p>
    </div>

    <div class="info">
        <p><strong>التاريخ:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
    </div>

    <div class="items">
        @foreach($order->orderItems as $item)
        <div class="item">
            <div class="item-name">{{ $item->meal->name_ar }}</div>
            <div class="item-quantity">الكمية: {{ $item->quantity }}</div>
        </div>
        @endforeach
    </div>

    <div class="footer">
        <p>وقت الطلب: {{ $order->created_at->format('H:i') }}</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" class="btn btn-primary">طباعة</button>
        <button onclick="window.close()" class="btn btn-secondary">إغلاق</button>
    </div>

    <script>
        window.onload = function() {
            // Auto print kitchen order
            window.print();
        }
    </script>
</body>
</html>
