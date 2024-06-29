<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\Province;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProvinceTest extends TestCase
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
     public function test_province_list(): void
    {
        $response = $this->actingAs($this->user)->get('/api/province');
        $response->assertStatus(200);
    }

    public function test_province_store(): void
    {
        $country=Country::factory()->create();
        $response = $this->actingAs($this->user)->post('/api/province/store',[
            'country_id'=> $country->id,
            'name'=>'Sudurpaschim Province'
        ]);
        $response->assertStatus(200);
    }

    public function test_province_edit(): void
    {
        $province=Province::factory()->create();
        $response = $this->actingAs($this->user)->get("/api/province/{$province->id}/edit");
        $response->assertStatus(200);
    }
    public function test_province_update(): void
    {
        $province=Province::factory()->create();
        $country=Country::factory()->create();
        $response = $this->actingAs($this->user)->put("/api/province/{$province->id}/update",[
             'country_id'=> $country->id,
            'name'=>'Gandaki Province'
        ]);
        $response->assertStatus(200);
    }
    public function test_province_delete(): void
    {
        $province=Province::factory()->create();
        $response = $this->actingAs($this->user)->delete("/api/province/{$province->id}/delete");
        $response->assertStatus(200);
    }
}
