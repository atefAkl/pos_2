<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index()
    {
        $meals = Meal::orderBy('category')->orderBy('name')->get();
        return view('meals.index', compact('meals'));
    }

    public function create()
    {
        return view('meals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('meals', 'public');
        }

        Meal::create($validated);

        return redirect()->route('meals.index')->with('success', 'تم إضافة الوجبة بنجاح');
    }

    public function show(Meal $meal)
    {
        return view('meals.show', compact('meal'));
    }

    public function edit(Meal $meal)
    {
        return view('meals.edit', compact('meal'));
    }

    public function update(Request $request, Meal $meal)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($meal->image) {
                \Storage::disk('public')->delete($meal->image);
            }
            $validated['image'] = $request->file('image')->store('meals', 'public');
        }

        $meal->update($validated);

        return redirect()->route('meals.index')->with('success', 'تم تحديث الوجبة بنجاح');
    }

    public function destroy(Meal $meal)
    {
        if ($meal->image) {
            \Storage::disk('public')->delete($meal->image);
        }
        $meal->delete();

        return redirect()->route('meals.index')->with('success', 'تم حذف الوجبة بنجاح');
    }

    public function toggleAvailability(Meal $meal)
    {
        $meal->update(['is_available' => !$meal->is_available]);
        return response()->json(['success' => true, 'is_available' => $meal->is_available]);
    }
}
