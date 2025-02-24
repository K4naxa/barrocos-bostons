<?php

namespace Database\Seeders;

use App\Models\Dog;
use App\Models\ExaminationType;
use App\Models\MedicalExamination;
use App\Models\Title;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DogSeeder extends Seeder
{
    public function run()
    {
        // Create 20 dogs with random relationships
        Dog::factory(20)->create()->each(function ($dog) {
            // Assign random owners
            $dog->owners()->attach(
                User::inRandomOrder()->take(rand(1, 3))->pluck('id'),
                ['ownership_date' => now()]
            );

            // Add random titles
            $dog->titles()->attach(
                Title::inRandomOrder()->take(rand(1, 2))->pluck('id'),
                ['date_achieved' => now()]
            );

            // Add random medical examinations
            MedicalExamination::factory(rand(1, 3))->create([
                'dog_id' => $dog->id,
                'examination_type_id' => ExaminationType::inRandomOrder()->first()->id,
            ]);
        });
    }
}
