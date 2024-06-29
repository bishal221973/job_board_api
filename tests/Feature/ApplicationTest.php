<?php

namespace Tests\Feature;

use App\Models\Application;
use Tests\TestCase;
use App\Models\User;
use App\Models\Vacancy;
use App\Models\Company;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApplicationTest extends TestCase
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
    public function test_submit_application(): void
    {
        $vacancy=Vacancy::create([
            'company_id'=>Company::factory()->create()->id,
            'user_id'=>$this->user->id,
            'job_title'=>"Laravel Developer",
            'description'=>"Must complete Bachelor",
            'application_instructions'=>"Should have atleast 2 years of eexperiance"
        ]);
        $user = User::factory()->create();
        $role = Role::firstOrCreate(['name' => 'seeker']);
        $user->assignRole($role);
        $response = $this->actingAs($user)->post("/api/application/{$vacancy->id}/submit",[
            'resume'=>'resume.pdf',
            'cover_letter'=>'hello'
        ]);

        $response->assertStatus(200);
    }

    public function test_submited_application(): void
    {
        $vacancy=Vacancy::create([
            'company_id'=>Company::factory()->create()->id,
            'user_id'=>$this->user->id,
            'job_title'=>"Laravel Developer",
            'description'=>"Must complete Bachelor",
            'application_instructions'=>"Should have atleast 2 years of eexperiance"
        ]);

        $response = $this->actingAs($this->user)->get("/api/application/list");

        $response->assertStatus(200);
    }

    public function test_approval_application(): void
    {
        $vacancy=Vacancy::create([
            'company_id'=>Company::factory()->create()->id,
            'user_id'=>$this->user->id,
            'job_title'=>"Laravel Developer",
            'description'=>"Must complete Bachelor",
            'application_instructions'=>"Should have atleast 2 years of eexperiance"
        ]);
        $user = User::factory()->create();
        $role = Role::firstOrCreate(['name' => 'seeker']);
        $user->assignRole($role);

        $application=Application::create([
            'user_id'=>$user->id,
            'vacancy_id'=>$vacancy->id,
            'resume'=>'resume.pdf',
            'cover_letter'=>'cover_letter'
        ]);

        $response = $this->actingAs($this->user)->put("/api/application/{$application->id}/approval",[
            'isApproved'=>false,
        ]);

        $response->assertStatus(200);
    }
}
