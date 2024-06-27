<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registration(RegistrationRequest $request){
        $data=$request->validated();
        $data['email_verified_at']=now();
        $data['password']=Hash::make($request->password);

        $user=User::create($data);

        $user->assignRole($request->role);

        return response()->json([
            'success'=>true,
            'message'=>'Your registration is completed'
        ]);
    }
}
