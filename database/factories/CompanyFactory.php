<?php

namespace Database\Factories;

use App\Models\Municipality;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'municipality_id'=>Municipality::factory()->create()->id,
            'user_id'=>User::factory()->create()->id,
            'company_name'=>$this->faker->name,
            'tole'=> $this->faker->name,
        ];
    }
}
