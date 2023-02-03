<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\LoginResource;
use App\Http\Resources\UserDetailResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    public function login(LoginRequest $request)
    {
        $credentials = [
            'username' => $request['username'],
            'password' => $request['password'],
        ];

        if (!Auth::attempt($credentials)) {
            return $this->errorResponse('Credential failed', null, Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('username', 'like', $request->username)->first();

        $token = $user->createToken('auth_token')->plainTextToken;
        $data = [
            'user' => new LoginResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];

        return $this->successResponse('Logged in successfully', $data);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        return $this->successResponse('Created user successfully', new UserDetailResource($user));
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return $this->successResponse('Successfully logged out');
    }
}
