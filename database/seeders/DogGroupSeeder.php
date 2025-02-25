<?php

namespace Database\Seeders;

use App\Models\DogGroupType;
use App\Models\ExaminationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DogGroupSeeder extends Seeder
{
    public function run()
    {
        $groups = [
            ['name' => 'males'],
            ['name' => 'females'],
            ['name' => 'memoriam'],
            ['name' => 'not_own'],
        ];

        foreach ($groups as $type) {
            DogGroupType::create($type);
        }
    }
}
