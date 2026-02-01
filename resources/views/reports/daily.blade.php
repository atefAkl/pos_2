@extends('layouts.app')

@section('title', 'التقرير اليومي')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <h2>التقرير اليومي</h2>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.daily') }}" class="row g-3">
            <div class="col-md-4">
                <label for="date" class="form-label">التاريخ</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ $date }}" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">عرض التقرير</button>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">إجمالي المبيعات</h5>
                <h2 class="text-success">{{ number_format($report['total_sales'], 2) }} جنيه</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">عدد الطلبات</h5>
                <h2 class="text-primary">{{ $report['total_orders'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">الضريبة</h5>
                <h2 class="text-info">{{ number_format($report['total_tax'], 2) }} جنيه</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">غير خاضع للضريبة</h5>
                <h2 class="text-warning">{{ number_format($report['total_non_taxable'], 2) }} جنيه</h2>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>المبيعات حسب طريقة الدفع</h5>
            </div>
            <div class="card-body">
                <p><strong>نقدي:</strong> {{ number_format($report['cash_sales'], 2) }} جنيه</p>
                <p><strong>بطاقة:</strong> {{ number_format($report['card_sales'], 2) }} جنيه</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>التوصيل</h5>
            </div>
            <div class="card-body">
                <p><strong>عدد طلبات التوصيل:</strong> {{ $report['delivery_orders'] }}</p>
                <p><strong>إجمالي مبلغ التوصيل:</strong> {{ number_format($report['delivery_amount'], 2) }} جنيه</p>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5>المبيعات حسب الوجبة</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>الوجبة</th>
                        <th>الكمية المباعة</th>
                        <th>إجمالي المبلغ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($report['sales_by_meal'] as $sale)
                    <tr>
                        <td>{{ $sale->meal->name_ar }}</td>
                        <td>{{ $sale->total_quantity }}</td>
                        <td>{{ number_format($sale->total_amount, 2) }} جنيه</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">لا توجد مبيعات</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>تفاصيل الطلبات</h5>
        <button onclick="window.print()" class="btn btn-sm btn-primary no-print">طباعة التقرير</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>التاريخ</th>
                        <th>المستخدم</th>
                        <th>المبلغ</th>
                        <th>طريقة الدفع</th>
                        <th>التوصيل</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($report['orders'] as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ number_format($order->total_amount, 2) }} جنيه</td>
                        <td>{{ $order->payment_method === 'cash' ? 'نقدي' : 'بطاقة' }}</td>
                        <td>{{ $order->has_delivery ? 'نعم' : 'لا' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">لا توجد طلبات</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
