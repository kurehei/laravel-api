<?php

namespace App\Http\Controllers\Api\V1_0;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegistUserRequest;
use App\Models\User;
use App\Services\ApiTokenCreateService;

class RegisterController extends Controller
{
  public function register(RegistUserRequest $request)
  {
    $user = new User();
    $user->user_name = $request->user_name;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->save();

    $userId = $user->user_id;
    $user = User::find($userId);
    $ApiTokenCreateService = new ApiTokenCreateService($user);

    return $ApiTokenCreateService->respondWithToken();
  }
}
