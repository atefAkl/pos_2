<?php

namespace App\Http\Controllers;

use App\Models\PosSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosSessionController extends Controller
{
    public function open(Request $request)
    {
        $validated = $request->validate([
            'opening_balance' => 'required|numeric|min:0',
        ], [
            'opening_balance.required' => 'Opening Balance is required',
            'opening_balance.numeric' => 'Opening Balance must be numeric',
        ]);

        // Check if there's an open session
        $openedSession = PosSession::where('status', 'open')->where('user_id', $request->user_id)->first();
        if ($openedSession) {
            return redirect()->back()->with('error', 'An active session is already open for this user.');
        }

        PosSession::create([
            'user_id' => $request->input('user_id'),
            'terminal_id' => $request->input('terminal_id'),
            'shift_id' => $request->input('shift_id'),
            'opening_balance' => $validated['opening_balance'],
            'opened_at' => now(),
            'status' => 'open',
        ]);

        return redirect()->back()->with('success', 'A new session has been opened.');
    }

    public function close(Request $request)
    {
        $validated = $request->validate([
            'closing_balance' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $session = PosSession::where('status', 'open')->where('user_id', Auth::id())->first();

        if (!$session) {
            return redirect()->back()->with('error', 'لا توجد جلسة مفتوحة');
        }

        // Calculate expected balance from today's sales
        $todaySales = \App\Models\Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->where('user_id', Auth::id())
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
        $openSession = PosSession::where('status', 'open')->where('user_id', Auth::id())->first();
        return response()->json([
            'is_open' => $openSession !== null,
            'session' => $openSession,
        ]);
    }
}
