<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run()
    {
        $sections = [
            [
                'name' => 'About Us',
                'slug' => 'about-us',
                'content' => 'About us content goes here',
                'is_active' => true,
            ],
            [
                'name' => 'Contact',
                'slug' => 'contact',
                'content' => 'Contact information goes here',
                'is_active' => true,
            ],
        ];

        foreach ($sections as $section) {
            Section::create($section);
        }
    }
}
