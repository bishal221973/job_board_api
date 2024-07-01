<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        $employer_role = Role::firstOrCreate(['name' => 'employer']);
        $seeker_role = Role::firstOrCreate(['name' => 'seeker']);

        $employer=User::create([
            'name'=> 'Employer',
            'email'=>'employer@gmail.com',
            'password'=>Hash::make('password'),
            'email_verified_at'=>now(),
        ]);
        $employer->assignRole($employer_role);
        Company::create([
            'municipality_id'=>'1',
            'user_id'=>$employer->id,
            'company_name'=>'The Firefly Tech',
            'tole'=>'Pokhara'
        ]);
        $seeker=User::create([
            'name'=> 'Seeker',
            'email'=>'seeker@gmail.com',
            'password'=>Hash::make('password'),
            'email_verified_at'=>now(),
        ]);
        $employer->assignRole($seeker_role);
    }
}
