<?php

namespace Database\Seeders;

use App\Models\Vacancy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vacancy::create([
            'company_id'=>'1',
            'user_id'=>'2',
            'job_title'=>'Laravel Developer',
            'description'=>'Vacancy Description',
            'application_instructions'=>'Application Instruction'
        ]);
    }
}
