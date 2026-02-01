<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = Order::with('user', 'orderItems.meal')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $meals = Meal::where('is_available', true)->orderBy('category')->orderBy('name_ar')->get();
        return view('orders.create', compact('meals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.meal_id' => 'required|exists:meals,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.is_taxable' => 'boolean',
            'payment_method' => 'required|in:cash,card',
            'has_delivery' => 'boolean',
            'delivery_amount' => 'nullable|numeric|min:0',
        ]);

        $order = $this->orderService->createOrder($validated, auth()->id());

        return redirect()->route('orders.show', $order->id)->with('success', 'تم إنشاء الطلب بنجاح');
    }

    public function show(Order $order)
    {
        $order->load('orderItems.meal', 'user', 'payments');
        return view('orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        if ($order->status === 'completed') {
            return redirect()->back()->with('error', 'لا يمكن حذف طلب مكتمل');
        }

        $order->delete();
        return redirect()->route('orders.index')->with('success', 'تم حذف الطلب بنجاح');
    }

    public function getMeals()
    {
        $meals = Meal::where('is_available', true)
            ->orderBy('category')
            ->orderBy('name_ar')
            ->get();

        return response()->json($meals);
    }
}
