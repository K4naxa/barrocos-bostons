<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DogController extends Controller
{
    public function create()
    {
        error_log('trying to open create dog');
        return Inertia::render('Management/DogCreate');
    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'nickname' => 'nullable|string|max:255',
                'birthday' => 'required|date',
                'gender' => 'required|in:male,female',
                'pedigree_url' => 'nullable|url',
                'group' => 'exists:dog_group_types,id',
            ]);


            $dog = Dog::create(array_merge($validated));

            return response()->json($dog, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
