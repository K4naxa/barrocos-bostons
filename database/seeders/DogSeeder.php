<?php

namespace Database\Seeders;

use App\Models\Dog;
use App\Models\DogGroupType;
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
        // Check for required data
        if (DogGroupType::count() === 0) {
            throw new \Exception('No dog group types found. Please run DogGroupSeeder first.');
        }
        // if (Title::count() === 0) {
        //     throw new \Exception('No titles found. Please run TitleSeeder first.');
        // }
        // if (ExaminationType::count() === 0) {
        //     throw new \Exception('No examination types found. Please run ExaminationTypeSeeder first.');
        // }

        // Create 20 dogs with random relationships
        Dog::factory(20)->create()->each(function ($dog) {
            try {

                // Add random titles
                // $dog->titles()->attach(
                //     Title::inRandomOrder()->take(rand(1, 2))->pluck('id'),
                //     ['date_achieved' => now()]
                // );

                // Add random medical examinations
                // MedicalExamination::factory(rand(1, 3))->create([
                //     'dog_id' => $dog->id,
                //     'examination_type_id' => ExaminationType::inRandomOrder()->first()->id,
                // ]);
            } catch (\Exception $e) {
                echo "Error processing dog {$dog->id}: " . $e->getMessage() . "\n";
            }
        });
    }
}
