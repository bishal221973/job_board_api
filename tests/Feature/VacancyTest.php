<?php

namespace Tests\Feature;

use App\Models\Municipality;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Vacancy;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VacancyTest extends TestCase
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
    public function test_list_of_own_vacancy_only(): void
    {
        $response = $this->actingAs($this->user)->get('/api/vacancy');

        $response->assertStatus(200);
    }

    public function test_create_vacancy(): void
    {
        Company::create([
            'municipality_id'=>Municipality::factory()->create()->id,
            'user_id'=> $this->user->id,
            'company_name'=>'Infotech',
            'tole'=>'Pokhara'
        ]);
        $response = $this->actingAs($this->user)->post('/api/vacancy/store',[
            'job_title'=>'Laravel Developer',
            'description'=>'Bachelor completed can apply',
            'application_instructions'=>'Must have atleast 2 years of experiance',
        ]);

        $response->assertStatus(200);
    }

    public function test_edit_vacancy_only_who_create_vacancy(): void
    {
        $vacancy=Vacancy::create([
            'company_id'=>Company::factory()->create()->id,
            'user_id'=>$this->user->id,
            'job_title'=>"Laravel Developer",
            'description'=>"Must complete Bachelor",
            'application_instructions'=>"Should have atleast 2 years of eexperiance"
        ]);
        $response = $this->actingAs($this->user)->get("/api/vacancy/{$vacancy->id}/edit");

        $response->assertStatus(200);
    }

    public function test_update_vacancy_only_who_create_vacancy(): void
    {
        $company_id=Company::factory()->create()->id;
        $vacancy=Vacancy::create([
            'company_id'=>$company_id,
            'user_id'=>$this->user->id,
            'job_title'=>"Laravel Developer",
            'description'=>"Must complete Bachelor",
            'application_instructions'=>"Should have atleast 2 years of eexperiance"
        ]);
        $response = $this->actingAs($this->user)->put("/api/vacancy/{$vacancy->id}/update",[
            'company_id'=>$company_id,
            'user_id'=>$this->user->id,
            'job_title'=>"Node js developer",
            'description'=>"Must complete Bachelor",
            'application_instructions'=>"Should have atleast 2 years of eexperiance"
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_vacancy_only_who_create_vacancy(): void
    {
        $vacancy=Vacancy::create([
            'company_id'=>Company::factory()->create()->id,
            'user_id'=>$this->user->id,
            'job_title'=>"Laravel Developer",
            'description'=>"Must complete Bachelor",
            'application_instructions'=>"Should have atleast 2 years of eexperiance"
        ]);
        $response = $this->actingAs($this->user)->delete("/api/vacancy/{$vacancy->id}/delete");

        $response->assertStatus(200);
    }
}
