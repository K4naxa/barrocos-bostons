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
            'group_id',
            'primary_image_id'
        )->with(['owners', 'group:id,name'])->get()
            ->map(function ($dog) {
                return [
                    'id' => $dog->id,
                    'name' => $dog->name,
                    'nickname' => $dog->nickname,
                    'birthday' => $dog->birthday,
                    'gender' => $dog->gender,
                    'group' => $dog->group,
                    'url' => $dog->primaryImage ? $dog->primaryImage->getFirstMediaUrl('gallery') : '',
                    'thumbnail' => $dog->primaryImage ? $dog->primaryImage->getFirstMediaUrl('gallery', 'thumb') : '',
                    'medium' => $dog->primaryImage ? $dog->primaryImage->getFirstMediaUrl('gallery', 'medium') : '',
                ];
            });


        return Inertia::render('Management/DogTable', [
            'dogs' => $dogs
        ]);
    }
}
