<?php

namespace Tests\Feature;

use App\Models\District;
use App\Models\Municipality;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MunicipalityTest extends TestCase
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
    public function test_municipality_list(): void
    {
        $response = $this->actingAs($this->user)->get('/api/municipality');

        $response->assertStatus(200);
    }

    public function test_municipality_store(): void
    {
        $district=District::factory()->create();
        $response = $this->actingAs($this->user)->post('/api/municipality/store',[
            'district_id'=>$district->id,
            'name'=>'Dhangadhi Municipality',
        ]);

        $response->assertStatus(200);
    }

    public function test_municipality_edit(): void
    {
        $municipality=Municipality::factory()->create();
        $response = $this->actingAs($this->user)->get("/api/municipality/{$municipality->id}/edit");

        $response->assertStatus(200);
    }

    public function test_municipality_update(): void
    {
        $municipality=Municipality::factory()->create();
        $district=District::factory()->create();
        $response = $this->actingAs($this->user)->put("/api/municipality/{$municipality->id}/update",[
            'district_id'=>$district->id,
            'name'=>'Dhangadhi Municipality',
        ]);

        $response->assertStatus(200);
    }

    public function test_municipality_delete(): void
    {
        $municipality=Municipality::factory()->create();
        $response = $this->actingAs($this->user)->delete("/api/municipality/{$municipality->id}/delete");

        $response->assertStatus(200);
    }
}
