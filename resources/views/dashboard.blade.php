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
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#openShiftModal">فتح نقطة البيع</button>
        </div>
    </div>
</div>
@endif

<!-- Open Shift Modal -->
<div class="modal fade" id="openShiftModal" tabindex="-1" aria-labelledby="openShiftModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="openShiftModalLabel">فتح وردية جديدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pos-sessions.open') }}" method="POST" id="shiftForm">
                <div class="modal-body">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="shift_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="shift_name" name="name" value="{{ auth()->user()->name }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="serial_number" name="serial_number" readonly>
                                <button type="button" class="btn btn-outline-secondary" id="generate_shift_serial">
                                    <i class="fas fa-sync-alt"></i> Generate
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="starts_at" class="form-label">Starts At</label>
                            <input type="datetime-local" class="form-control" id="starts_at" name="starts_at" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ends_at" class="form-label">Ends At (Expected)</label>
                            <input type="datetime-local" class="form-control" id="ends_at" name="ends_at" required>
                        </div>
                        <div class="col-md-6">
                            <label for="opening_balance" class="form-label">Opening Balance</label>
                            <input type="number" step="0.01" class="form-control" id="opening_balance" name="opening_balance" value="0" required>
                        </div>
                        <div class="col-md-6">
                            <label for="auto_close" class="form-label">Auto Close</label>
                            <select class="form-select" id="auto_close" name="auto_close">
                                <option value="manual">No (Manual close flexible)</option>
                                <option value="auto">Yes (Auto close at expected time)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="opening_notes" class="form-label">Opening Notes</label>
                            <textarea class="form-control" id="opening_notes" name="opening_notes" rows="3">Everything is ok.</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-success">فتح وردية</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="card">
    <div class="card-header">
        اجهزة الكاشير
    </div>
    <div class="card-body">
        <div class="row">

            <a href="{{ route('cashiers.index') }}" class="setting-link col-12 col-sm-6 col-md-4 col-lg-3">
                <i class="fa fa-print fa-2x"></i>
                <span class="link-title fs-6" style="">اجهزة الكاشير</span>
            </a>
            <a href="{{ route('cashiers.index') }}" class="setting-link col-12 col-sm-6 col-md-4 col-lg-3">
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

<script>
    // Shift form functionality
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard script loaded');

        // Serial number generator function for shift
        function generateShiftSerialNumber() {
            const today = new Date();
            const day = String(today.getDate()).padStart(2, '0');
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const year = today.getFullYear();

            // Format: ddmmyyyy-01
            const serialNumber = `${day}${month}${year}-01`;
            const serialInput = document.getElementById('serial_number');
            if (serialInput) {
                serialInput.value = serialNumber;
            }
        }

        // Set default time values for shift
        function setShiftDefaultTimes() {
            const today = new Date();

            // Set opening time to today at 8:00 AM
            const openingTime = new Date(today);
            openingTime.setHours(8, 0, 0, 0);

            // Set closing time to today at 4:00 PM
            const closingTime = new Date(today);
            closingTime.setHours(16, 0, 0, 0);

            // Format for datetime-local input (YYYY-MM-DDTHH:MM)
            const startsAtInput = document.getElementById('starts_at');
            const endsAtInput = document.getElementById('ends_at');

            if (startsAtInput) {
                startsAtInput.value = openingTime.toISOString().slice(0, 16);
            }
            if (endsAtInput) {
                endsAtInput.value = closingTime.toISOString().slice(0, 16);
            }
        }

        // Attach event listener to generate button
        const generateShiftBtn = document.getElementById('generate_shift_serial');
        if (generateShiftBtn) {
            console.log('Shift generate button found');
            generateShiftBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Shift generate button clicked');
                generateShiftSerialNumber();
            });
        } else {
            console.log('Shift generate button not found');
        }

        // Auto-generate serial number and set default times when modal opens
        const shiftModal = document.getElementById('openShiftModal');
        if (shiftModal) {
            console.log('Shift modal found');
            shiftModal.addEventListener('show.bs.modal', function() {
                console.log('Shift modal opening');
                setTimeout(function() {
                    generateShiftSerialNumber();
                    setShiftDefaultTimes();
                }, 100);
            });
        } else {
            console.log('Shift modal not found');
        }

        // Test function for debugging
        window.testShiftGenerate = function() {
            console.log('Test shift generate called');
            generateShiftSerialNumber();
            setShiftDefaultTimes();
        };
    });
</script>