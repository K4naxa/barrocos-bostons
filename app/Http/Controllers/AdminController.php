<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;
use Inertia\Inertia;

class AdminController extends Controller
{

    public function dashboard(Request $request)
    {
        $dogs = Dog::all();
        $dogs->load(['owners']);

        return Inertia::render('Management/Dashboard', [
            'dogs' => $dogs
        ]);
    }
}
