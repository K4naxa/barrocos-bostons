<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dog>
 */
class DogFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'nickname' => $this->faker->word,
            'birthday' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'pedigree_url' => $this->faker->url,
        ];
    }
}

// Add other factories as needed...
