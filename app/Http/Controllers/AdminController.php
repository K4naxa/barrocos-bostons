<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;
use App\Models\DogGroupType;
use Inertia\Inertia;

class AdminController extends Controller
{

    public function dashboard(Request $request)
    {
        return Inertia::render('Management/Dashboard', []);
    }



    public function dogs(Request $request)
    {

        $dogs = Dog::select(
            'id',
            'name',
            'nickname',
            'birthday',
            'gender',
            'group_id'
        )->with(['owners', 'group:id,name'])->get();
        return Inertia::render('Management/DogTable', [
            'dogs' => $dogs
        ]);
    }
}
