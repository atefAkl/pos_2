<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::where(['status' => true])->get();
        return view('staff.members.index', compact('members'));
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
            return redirect()->back()->with('success', 'Member added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
