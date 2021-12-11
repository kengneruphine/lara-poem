<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function index(Request $request): Response
    {
        return \response(User::all());
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('apptoken')->plainTextToken;

        $response = ['user' => $user, 'token' => $token];
        return response($response, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

//        Check email
        $user = User::where('email', $fields['email'])->first();

//        Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return \response(['message' => 'invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('apptoken')->plainTextToken;

        $response = ['user' => $user, 'token' => $token];
        return response($response, Response::HTTP_ACCEPTED);
    }

    public function logout(Request $request): Response
    {
        auth()->user()->tokens()->delete();
        return response(['message' => 'Logged out!']);
    }
}