<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'super-admin']);

        $user=User::create([
            'name'=> 'Super Admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('password'),
            'email_verified_at'=>now(),
        ]);

        $user->assignRole('super-admin');

    }
}
