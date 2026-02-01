@extends('layouts.app', ['hideSidebar' => true])

@section('title', 'نقطة البيع')

@section('content')
<div class="row g-3">
    <!-- Meals Selection -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">اختر الوجبات</h4>
            </div>
            <div class="card-body">
                <!-- Category Filter -->
                <div class="mb-3">
                    <input type="text" id="searchMeal" class="form-control" placeholder="ابحث عن وجبة...">
                </div>
                <div class="row g-2" id="mealsContainer">
                    @foreach($meals as $meal)
                    <div class="col-md-3 meal-item" data-category="{{ $meal->category }}" data-name="{{ strtolower($meal->name_ar . ' ' . $meal->name) }}">
                        <div class="card h-100 meal-card" onclick="addToCart({{ $meal->id }}, '{{ $meal->name_ar }}', {{ $meal->price }})">
                            @if($meal->image)
                            <img src="{{ asset('storage/' . $meal->image) }}" class="card-img-top" style="height: 120px; object-fit: cover;">
                            @else
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 120px;">
                                <span class="text-white">لا توجد صورة</span>
                            </div>
                            @endif
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1">{{ $meal->name_ar }}</h6>
                                <p class="card-text mb-0"><small>{{ number_format($meal->price, 2) }} جنيه</small></p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Cart -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">الطلب</h4>
            </div>
            <div class="card-body">
                <form id="orderForm" action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <div id="cartItems" class="mb-3" style="max-height: 400px; overflow-y: auto;">
                        <p class="text-muted text-center">لا توجد عناصر في الطلب</p>
                    </div>
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>المجموع الفرعي:</span>
                            <span id="subtotal">0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>الضريبة (14%):</span>
                            <span id="tax">0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>التوصيل:</span>
                            <input type="number" step="0.01" id="deliveryAmount" name="delivery_amount" class="form-control form-control-sm d-inline-block" style="width: 100px;" value="0" onchange="calculateTotal()">
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="hasDelivery" name="has_delivery" value="1" onchange="toggleDelivery()">
                            <label class="form-check-label" for="hasDelivery">توصيل</label>
                        </div>
                        <div class="d-flex justify-content-between mb-3 fw-bold">
                            <span>الإجمالي:</span>
                            <span id="total">0.00</span> جنيه
                        </div>
                        <div class="mb-3">
                            <label class="form-label">طريقة الدفع:</label>
                            <select class="form-select" name="payment_method" required>
                                <option value="cash">نقدي</option>
                                <option value="card">بطاقة</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100 mb-2">إتمام الطلب</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100">العودة</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let cart = [];

function addToCart(mealId, mealName, price) {
    const existingItem = cart.find(item => item.meal_id === mealId);
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({
            meal_id: mealId,
            name: mealName,
            price: price,
            quantity: 1,
            is_taxable: true
        });
    }
    updateCartDisplay();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCartDisplay();
}

function updateQuantity(index, change) {
    cart[index].quantity += change;
    if (cart[index].quantity <= 0) {
        removeFromCart(index);
    } else {
        updateCartDisplay();
    }
}

function toggleTaxable(index) {
    cart[index].is_taxable = !cart[index].is_taxable;
    updateCartDisplay();
}

function updateCartDisplay() {
    const cartItems = document.getElementById('cartItems');
    if (cart.length === 0) {
        cartItems.innerHTML = '<p class="text-muted text-center">لا توجد عناصر في الطلب</p>';
        calculateTotal();
        return;
    }

    let html = '';
    cart.forEach((item, index) => {
        html += `
            <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                <div class="flex-grow-1">
                    <div class="fw-bold">${item.name}</div>
                    <div class="small">
                        <span>${item.price.toFixed(2)} × ${item.quantity} = ${(item.price * item.quantity).toFixed(2)}</span>
                        <label class="ms-2">
                            <input type="checkbox" ${item.is_taxable ? 'checked' : ''} onchange="toggleTaxable(${index})">
                            <small>خاضع للضريبة</small>
                        </label>
                    </div>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${index}, -1)">-</button>
                    <span class="mx-2">${item.quantity}</span>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${index}, 1)">+</button>
                    <button type="button" class="btn btn-sm btn-danger ms-1" onclick="removeFromCart(${index})">×</button>
                </div>
            </div>
        `;
    });
    cartItems.innerHTML = html;
    calculateTotal();
}

function calculateTotal() {
    let taxableTotal = 0;
    let nonTaxableTotal = 0;

    cart.forEach(item => {
        const subtotal = item.price * item.quantity;
        if (item.is_taxable) {
            taxableTotal += subtotal;
        } else {
            nonTaxableTotal += subtotal;
        }
    });

    const taxRate = 0.14;
    const tax = taxableTotal * taxRate;
    const deliveryAmount = parseFloat(document.getElementById('deliveryAmount').value) || 0;
    const total = taxableTotal + nonTaxableTotal + tax + deliveryAmount;

    document.getElementById('subtotal').textContent = (taxableTotal + nonTaxableTotal).toFixed(2);
    document.getElementById('tax').textContent = tax.toFixed(2);
    document.getElementById('total').textContent = total.toFixed(2);
}

function toggleDelivery() {
    const hasDelivery = document.getElementById('hasDelivery').checked;
    document.getElementById('deliveryAmount').disabled = !hasDelivery;
    if (!hasDelivery) {
        document.getElementById('deliveryAmount').value = 0;
    }
    calculateTotal();
}

document.getElementById('orderForm').addEventListener('submit', function(e) {
    if (cart.length === 0) {
        e.preventDefault();
        alert('الرجاء إضافة وجبات للطلب');
        return false;
    }

    // Add cart items to form
    cart.forEach((item, index) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = `items[${index}][meal_id]`;
        input.value = item.meal_id;
        this.appendChild(input);

        const qtyInput = document.createElement('input');
        qtyInput.type = 'hidden';
        qtyInput.name = `items[${index}][quantity]`;
        qtyInput.value = item.quantity;
        this.appendChild(qtyInput);

        const taxInput = document.createElement('input');
        taxInput.type = 'hidden';
        taxInput.name = `items[${index}][is_taxable]`;
        taxInput.value = item.is_taxable ? 1 : 0;
        this.appendChild(taxInput);
    });
});

// Search functionality
document.getElementById('searchMeal').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const mealItems = document.querySelectorAll('.meal-item');
    mealItems.forEach(item => {
        const name = item.getAttribute('data-name');
        if (name.includes(searchTerm)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>
@endsection
