<?php

namespace App\Http\Controllers\Api\V1_0;

use App\Http\Controllers\Controller;
use App\Services\ApiTokenCreateService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;
use App\Http\Requests\Api\LoginRequest;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->guard = "api"; // 追加
    }
    public function login(LoginRequest $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }
        $user = User::where('email', $request->email)->first();
        $ApiTokenCreateService = new ApiTokenCreateService($user);
        $ApiTokenCreateService->respondWithToken();

        return $user;
    }
}
