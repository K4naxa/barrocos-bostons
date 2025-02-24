<?php

namespace Database\Seeders;

use App\Models\ExaminationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExaminationTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'Hip Dysplasia', 'description' => 'Examination for hip dysplasia'],
            ['name' => 'Eye Test', 'description' => 'Regular eye examination'],
            ['name' => 'DNA Test', 'description' => 'Genetic testing'],
        ];

        foreach ($types as $type) {
            ExaminationType::create($type);
        }
    }
}
