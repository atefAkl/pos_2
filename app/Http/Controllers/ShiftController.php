<?php

namespace App\Http\Controllers;

use App\Http\Requests\Shifts\StartRequest;
use App\Models\Shift;
use App\Models\Terminal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $currentShift = Shift::currentShift();
        $query = Shift::query();
        // Filteration and search 
        if ($req->input('before') && $req->input('after')) {
            $query->whereBetween('started_at', [$req->input('after'), $req->input('before')]);
        } else {
            if ($req->input('before')) {
                $query->where('started_at', '<=', $req->input('before'));
            }
            if ($req->input('after')) {
                $query->where('started_at', '>=', $req->input('after'));
            }
        }


        $shifts = $query->with('sessions')->orderBy('created_at', 'desc')->paginate(10);
        return view('settings.shifts.index', compact('shifts', 'currentShift'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StartRequest $request)
    {
        $validated = $request->validated();
        //return $request->validated();
        $validated['is_current'] = Shift::currentShift() ? false : true;

        if (!Auth::user()->role == 'start shift') {
            return redirect()->back()->with('error', 'You do not have permission to start a shift');
        }

        try {
            $validated['accountant_id'] = Auth::id();
            //return $validated;
            Shift::create($validated);
            return redirect()->back()->with('success', 'Shift started successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to start shift: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        $cashiers = User::where(['role' => 'cashier', 'status' => true])->get();
        $terminals = Terminal::all();
        $shift->load('sessions.cashier', 'sessions.terminal');
        return view('settings.shifts.show', compact('shift', 'cashiers', 'terminals'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        return view('settings.shifts.edit', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shift $shift)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        //
        return $shift;
    }
}
