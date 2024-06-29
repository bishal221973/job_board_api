<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegistrationRequest;

class AuthController extends Controller
{
    public function employerRegistration(RegistrationRequest $request)
    {
        $data = $request->validated();
        $data['email_verified_at'] = now();
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

        $user->assignRole('employer');
        return response()->json([
            'success' => true,
            'message' => 'Your registration is completed'
        ]);
    }


    public function seekerRegistration(RegistrationRequest $request)
    {
        $data = $request->validated();
        $data['email_verified_at'] = now();
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

        $user->assignRole('seeker');

        return response()->json([
            'success' => true,
            'message' => 'Your registration is completed'
        ]);
    }

    public function login(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            //     $token = $user->createToken($request->email)->plainTextToken;

            $token = $user->createToken($request->email)->plainTextToken;
            return response()->json([
                'success' => true,
                'token' => $token,
                'message' => "Successfully Login",
            ], 200);
        }
        return response([
            'success' => false,
            'message' => 'Please enter valide email or password'
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens->each(function($token, $key) {
            $token->delete();
        });

        return response()->json([
            'success'=> true,
            'message'=> 'User loged out'
        ]);
    }
}
