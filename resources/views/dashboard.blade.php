@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h2>لوحة التحكم</h2>
    </div>
</div>
<style>
    a {
        text-decoration: none;
        color: inherit;
    }

    a.setting-link {
        transition: all 0.3s ease;
    }

    a.setting-link .link-title {
        font-weight: bold;
        margin-inline-start: 10px;
        scale: 1
    }

    a.setting-link i {
        scale: 1;
    }

    .setting-link:hover * {
        color: rgb(1, 72, 148);
        scale: 1.05
    }
</style>

<!-- POS Session Status -->
@if($openSession)
<div class="row mb-4">
    <div class="col-md-12">
        <div class="alert alert-success">
            <strong>نقطة البيع مفتوحة</strong> - الرصيد الافتتاحي: {{ number_format($openSession->opening_balance, 2) }} جنيه
            <form action="{{ route('pos-sessions.close') }}" method="POST" class="d-inline float-start">
                @csrf
                <div class="row g-2">
                    <div class="col-auto">
                        <input type="number" step="0.01" class="form-control form-control-sm" name="closing_balance" placeholder="الرصيد الختامي" required>
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control form-control-sm" name="notes" placeholder="ملاحظات">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-sm btn-danger">إغلاق نقطة البيع</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@else
<div class="row mb-4">
    <div class="col-md-12">
        <div class="alert alert-warning">
            <strong>نقطة البيع مغلقة</strong>
            <form action="{{ route('pos-sessions.open') }}" method="POST" class="d-inline float-start">
                @csrf
                <div class="row g-2">
                    <div class="col-auto">
                        <input type="number" step="0.01" class="form-control form-control-sm" name="opening_balance" placeholder="الرصيد الافتتاحي" required>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-sm btn-success">فتح نقطة البيع</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Statistics Cards -->
<div class="card">
    <div class="card-header">
        POD Devices
    </div>
    <div class="card-body">
        <div class="row">

            <a href="{{ route('terminals.index') }}" class="setting-link col-12 col-sm-6 col-md-4 col-lg-3">
                <i class="fa fa-print fa-2x"></i>
                <span class="link-title fs-6" style="">اجهزة الكاشير</span>
            </a>
            <a href="{{ route('terminals.index') }}" class="setting-link col-12 col-sm-6 col-md-4 col-lg-3">
                <i class="fa fa-print fa-2x"></i>
                <span class="link-title fs-6" style="">اجهزة الكاشير</span>
            </a>
        </div>


    </div>
</div>

<div class="row mb-4">

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">طلبات اليوم</h5>
                <h2 class="text-primary">{{ $todayOrders }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">مبيعات اليوم</h5>
                <h2 class="text-success">{{ number_format($todaySales, 2) }} جنيه</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">الوجبات المتاحة</h5>
                <h2 class="text-info">{{ $availableMeals }} / {{ $totalMeals }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">إجراءات سريعة</h5>
                <a href="{{ route('pos') }}" class="btn btn-primary btn-sm">طلب جديد</a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>آخر الطلبات</h5>
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
                                <th>الحالة</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ number_format($order->total_amount, 2) }} جنيه</td>
                                <td>{{ $order->payment_method === 'cash' ? 'نقدي' : 'بطاقة' }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'warning' }}">
                                        {{ $order->status === 'completed' ? 'مكتمل' : 'قيد الانتظار' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">عرض</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">لا توجد طلبات</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection