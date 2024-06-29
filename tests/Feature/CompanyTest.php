<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Municipality;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
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
    public function test_get_company(): void
    {
        $response = $this->actingAs($this->user)->get('/api/company');

        $response->assertStatus(200);
    }

    public function test_store_company(): void
    {
        $response = $this->actingAs($this->user)->post('/api/company/store', [
            'municipality_id' => Municipality::factory()->create()->id,
            'company_name' => "Test Info web",
            'tole' => "Dhangadhi",
        ]);

        $response->assertStatus(200);
    }

    public function test_update_company(): void
    {
        $company = Company::factory()->create();
        $response = $this->actingAs($this->user)->put("/api/company/{$company->id}/update", [
            'municipality_id' => Municipality::factory()->create()->id,
            'company_name' => "Test web",
            'tole' => "Pokhara",
        ]);

        $response->assertStatus(200);
    }
}
