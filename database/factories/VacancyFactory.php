<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacancy>
 */
class VacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id'=>Company::factory()->create()->id,
            'user_id'=>User::factory()->create()->id,
            'job_title'=>$this->faker->jobTitle,
            'description'=>$this->faker->name,
            'application_instructions'=>$this->faker->name
        ];
    }
}
