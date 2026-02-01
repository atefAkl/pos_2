<?php

namespace App\Http\Controllers;

use App\Models\PosSession;
use Illuminate\Http\Request;

class PosSessionController extends Controller
{
    public function open(Request $request)
    {
        $validated = $request->validate([
            'opening_balance' => 'required|numeric|min:0',
        ]);

        // Check if there's an open session
        $openSession = PosSession::where('status', 'open')->where('user_id', auth()->id())->first();
        if ($openSession) {
            return redirect()->back()->with('error', 'يوجد جلسة مفتوحة بالفعل');
        }

        PosSession::create([
            'user_id' => auth()->id(),
            'opening_balance' => $validated['opening_balance'],
            'opened_at' => now(),
            'status' => 'open',
        ]);

        return redirect()->back()->with('success', 'تم فتح نقطة البيع بنجاح');
    }

    public function close(Request $request)
    {
        $validated = $request->validate([
            'closing_balance' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $session = PosSession::where('status', 'open')->where('user_id', auth()->id())->first();

        if (!$session) {
            return redirect()->back()->with('error', 'لا توجد جلسة مفتوحة');
        }

        // Calculate expected balance from today's sales
        $todaySales = \App\Models\Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->where('user_id', auth()->id())
            ->sum('total_amount');

        $expectedBalance = $session->opening_balance + $todaySales;

        $session->update([
            'closing_balance' => $validated['closing_balance'],
            'expected_balance' => $expectedBalance,
            'closed_at' => now(),
            'status' => 'closed',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->back()->with('success', 'تم إغلاق نقطة البيع بنجاح');
    }

    public function status()
    {
        $openSession = PosSession::where('status', 'open')->where('user_id', auth()->id())->first();
        return response()->json([
            'is_open' => $openSession !== null,
            'session' => $openSession,
        ]);
    }
}
