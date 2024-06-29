<?php

namespace Tests\Feature;

use App\Models\District;
use App\Models\Province;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DistrictTest extends TestCase
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

    public function test_district_list(): void
    {
        $response = $this->actingAs($this->user)->get('/api/district');

        $response->assertStatus(200);
    }

    public function test_district_store(): void
    {
        $province=Province::factory()->create();
        $response = $this->actingAs($this->user)->post('/api/district/store',[
            'province_id'=>$province->id,
            'name'=>'Kailali'
        ]);

        $response->assertStatus(200);
    }

    public function test_district_edit(): void
    {
        $district=District::factory()->create();
        $response = $this->actingAs($this->user)->get("/api/district/{$district->id}/edit");

        $response->assertStatus(200);
    }
    public function test_district_update(): void
    {
        $district=District::factory()->create();
        $province=Province::factory()->create();
        $response = $this->actingAs($this->user)->put("/api/district/{$district->id}/update",[
            'province_id'=>$province->id,
            'name'=>'Kaski'
        ]);

        $response->assertStatus(200);
    }

    public function test_district_delete(): void
    {
        $district=District::factory()->create();
        $response = $this->actingAs($this->user)->delete("/api/district/{$district->id}/delete");

        $response->assertStatus(200);
    }
}
