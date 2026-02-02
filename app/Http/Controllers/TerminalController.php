<?php

namespace App\Http\Controllers;

use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TerminalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $terminals = Terminal::all();
        return view('settings.terminals.index', compact('terminals'));
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            's_number'  => 'required|string|max:255',
            'printer'   => 'required|string|max:255',
            'pos_device' => 'required|string|max:255'
        ]);

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        try {
            Terminal::create($validated);
            return redirect()->back()->with('success', 'Terminal created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create terminal: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Terminal $terminal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Terminal $terminal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Terminal $terminal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Terminal $terminal)
    {
        //
    }
}
