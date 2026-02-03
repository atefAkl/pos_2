<?php

namespace App\Http\Controllers;

use App\Http\Requests\Shifts\StartRequest;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shifts = Shift::all();
        return view('settings.shifts.index', compact('shifts'));
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
        //return $request->validated();
        if (Shift::currentShift()) {
            return redirect()->back()->with('error', 'Shift is already active');
        }

        if (!Auth::user()->role == 'start shift') {
            return redirect()->back()->with('error', 'You do not have permission to start a shift');
        }

        try {
            $validated = $request->validated();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        //
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
    }
}
