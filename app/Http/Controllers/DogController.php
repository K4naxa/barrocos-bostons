<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use Illuminate\Http\Request;

class DogController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'nickname' => 'nullable|string|max:255',
                'birthday' => 'required|date',
                'gender' => 'required|in:male,female',
                'pedigree_url' => 'nullable|url'
            ]);

            $dog = Dog::create($validated);

            return response()->json($dog, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
