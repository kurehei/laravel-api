<?php

namespace App\Http\Controllers\Api\V1_0;

use App\Http\Controllers\Controller;
use App\Services\ApiTokenCreateService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use App\Http\Requests\Api\LoginRequest;


class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        // emailとpasswordだけの情報を取得
        $credentials = request()->only(['email', 'pasword']);
        $token = null;
        if (!$token = JWTAuth::attempt($credentials)) {
            // $tokenがもしなければ、
            return response()->json(
                [
                    'success' => 'false',
                    'errors' => 'Invalid Email or Password',
                ],
                401
            );
            $user = User::where('email', $request->input('email')->first());
            $ApiTokenCreateService = new ApiTokenCreateService($user);
            return $ApiTokenCreateService->respondWithToken();
        }
    }
}
