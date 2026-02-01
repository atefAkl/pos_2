@extends('layouts.app')

@section('title', 'إدارة الوجبات')

@section('content')
<div class="row mb-3">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h2>إدارة الوجبات</h2>
        <a href="{{ route('meals.create') }}" class="btn btn-primary">إضافة وجبة جديدة</a>
    </div>
</div>

<div class="row">
    @foreach($meals as $meal)
    <div class="col-md-3 mb-4">
        <div class="card h-100">
            @if($meal->image)
            <img src="{{ asset('storage/' . $meal->image) }}" class="card-img-top" alt="{{ $meal->name_ar }}" style="height: 200px; object-fit: cover;">
            @else
            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                <span class="text-white">لا توجد صورة</span>
            </div>
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $meal->name_ar }}</h5>
                <p class="card-text">{{ $meal->description }}</p>
                <p class="card-text"><strong>السعر:</strong> {{ number_format($meal->price, 2) }} جنيه</p>
                <p class="card-text"><strong>الفئة:</strong> {{ $meal->category ?? 'غير محدد' }}</p>
                <span class="badge bg-{{ $meal->is_available ? 'success' : 'danger' }}">
                    {{ $meal->is_available ? 'متاح' : 'غير متاح' }}
                </span>
            </div>
            <div class="card-footer">
                <div class="btn-group w-100" role="group">
                    <a href="{{ route('meals.edit', $meal->id) }}" class="btn btn-sm btn-warning">تعديل</a>
                    <button type="button" class="btn btn-sm btn-{{ $meal->is_available ? 'secondary' : 'success' }}" onclick="toggleAvailability({{ $meal->id }})">
                        {{ $meal->is_available ? 'تعطيل' : 'تفعيل' }}
                    </button>
                    <form action="{{ route('meals.destroy', $meal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($meals->isEmpty())
<div class="alert alert-info text-center">
    لا توجد وجبات. <a href="{{ route('meals.create') }}">إضافة وجبة جديدة</a>
</div>
@endif

<script>
function toggleAvailability(mealId) {
    fetch(`/meals/${mealId}/toggle-availability`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
@endsection
