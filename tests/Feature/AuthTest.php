<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class AuthTest extends TestCase
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
    use RefreshDatabase;
    public function test_user_login_with_email_and_password(): void
    {
        $user = User::factory()->create();
        $response = $this->post('/api/login',[
            'email'=> $user->email,
            'password'=> 'password',
        ]);

        $response->assertStatus(200);
    }
    public function test_employer_registration(): void
    {
        Role::firstOrCreate(['name' => 'employer']);
        $response = $this->post('/api/employer-registration',[
            'name'=>'Test Employer',
            'email'=>'testemployer@gmail.com',
            'password'=>'password',
            'password_confirmation'=>'password',
        ]);

        $response->assertStatus(200);
    }
    public function test_user_registration(): void
    {
        Role::firstOrCreate(['name' => 'seeker']);
        $response = $this->post('/api/user-registration',[
            'name'=>'Test Seeker',
            'email'=>'testseeker@gmail.com',
            'password'=>'password',
            'password_confirmation'=>'password',
        ]);

        $response->assertStatus(200);
    }

    public function test_user_logout(): void
    {
        $response = $this->actingAs($this->user)->get('/api/logout');

        $response->assertStatus(200);
    }
}
