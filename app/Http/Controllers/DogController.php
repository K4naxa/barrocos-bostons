<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\DogGroupType;
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

        error_log('validating new dog');
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'nickname' => 'nullable|string|max:255',
                'birthday' => 'required|date',
                'gender' => 'required|in:male,female',
                'pedigree_url' => 'nullable|url',
                'dog_group' => 'exists:dog_group_types,name',
                'owners' => 'array',
                'medical_examinations' => 'array'
            ]);

            error_log('validation success, creating new dog');

            if (isset($validated['dog_group'])) {
                $groupID = DogGroupType::where('name', '=', $validated['dog_group'])->firstOrFail();
                $validated['dog_group'] = $groupID->id;
            }

            $dog = Dog::create([
                'name' => $validated['name'],
                'nickname' => $validated['nickname'],
                'birthday' => $validated['birthday'],
                'gender' => $validated['gender'],
                'pedigree_url' => $validated['pedigree_url'],
                'group_id' => $validated['dog_group'],

            ]);
            error_log('created new dog successfully');


            return response()->json($dog, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
