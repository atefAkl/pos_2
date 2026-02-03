<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function profile()
    {
        $currentShift =  Shift::currentShift() ?? null;
        $now = now();
        return view('auth.user.profile', compact('currentShift', 'now'));
    }
}
