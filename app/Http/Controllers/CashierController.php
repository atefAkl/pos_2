<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CashierController extends Controller
{
    public function index()
    {
        $cashiers = User::where(['role' => 'cashier'])->get();
        return view('staff.cashiers.index', compact('cashiers'));
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|between:3,45',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:cashier,admin,accountant',
        ]);

        $validated['password'] = Hash::make('password');


        // return $validated;

        try {
            User::create($validated);
            return redirect()->back()->with('success', 'Cashier added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
