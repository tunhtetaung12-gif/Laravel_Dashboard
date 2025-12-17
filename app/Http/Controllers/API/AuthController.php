<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        // dd($credentials);

        if (!JWTAuth::attempt($credentials)) {
            return $this->error("Your email and Password wrong", null, 401);
        }

        $user = User::where('email', $credentials['email'])->first();
        // dd($user);

        $payload = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'address' => $user->address,
            'status' => $user->status,
            'gender' => $user->gender,
        ];

        $token = JWTAuth::customClaims($payload)->attempt(['email' => $user['email'], 'password' => $credentials['password']]);

        return $this->success($token, "User Login Successfully", 200);
    }
}
