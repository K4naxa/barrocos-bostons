<?php

namespace Database\Seeders;

use App\Models\Title;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TitleSeeder extends Seeder
{
    public function run()
    {
        $titles = [
            ['name' => 'Champion', 'description' => 'National Champion Title'],
            ['name' => 'Grand Champion', 'description' => 'Grand Champion Title'],
            ['name' => 'Working Certificate', 'description' => 'Working Dog Certificate'],
        ];

        foreach ($titles as $title) {
            Title::create($title);
        }
    }
}
