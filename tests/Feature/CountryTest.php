<?php

namespace Tests\Feature;

use App\Models\Country;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountryTest extends TestCase
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
        $this->role = Role::firstOrCreate(['name' => 'super-admin']);

        $this->user->assignRole($this->role);

    }
    public function test_country_list(): void
    {
        $response = $this->actingAs($this->user)->get('/api/country');

        $response->assertStatus(200);
    }
    public function test_country_store(): void
    {
        $response = $this->actingAs($this->user)->post('/api/country/store',[
            'country_code'=>'+977',
            'name'=>'Nepal'
        ]);

        $response->assertStatus(200);
    }
    public function test_country_edit(): void
    {
        $country=Country::factory()->create();
        $response = $this->actingAs($this->user)->get("/api/country/{$country->id}/edit");

        $response->assertStatus(200);
    }

    public function test_country_update(): void
    {

        $country=Country::factory()->create();
        $response = $this->actingAs($this->user)->put("/api/country/{$country->id}/update",[
            'country_code'=>'+977',
            'name'=>'Nepal'
        ]);

        $response->assertStatus(200);
    }
    public function test_country_delete(): void
    {
        $counry=Country::factory()->create();
        $response = $this->actingAs($this->user)->delete("/api/country/{$counry->id}/delete");

        $response->assertStatus(200);
    }
}
