<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Vacancy;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearhTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    private $user;

    private $role;
    public function setUp(): void

    {

        parent::setUp();
        $this->user = User::factory()->create();
        $this->role = Role::firstOrCreate(['name' => 'employer']);

        $this->user->assignRole($this->role);
    }
    public function test_filter_jobs(): void
    {
        $response = $this->get('/api/filter-job');

        $response->assertStatus(200);
    }

    public function test_vacancy_detail(): void
    {
        $vacancy=Vacancy::create([
            'company_id'=>Company::factory()->create()->id,
            'user_id'=>$this->user->id,
            'job_title'=>"Laravel Developer",
            'description'=>"Must complete Bachelor",
            'application_instructions'=>"Should have atleast 2 years of eexperiance"
        ]);
        $response = $this->get("/api/job/{$vacancy->id}/detail");

        $response->assertStatus(200);
    }
}
