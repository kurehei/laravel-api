<?php

namespace App\Http\Controllers\Api\V1_0;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegistUserRequest;
use App\User;
use App\Services\ApiTokenCreateService;

class RegisterController extends Controller
{
  public function register(RegistUserRequest $request)
  {
    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->save();

    $userId = $user->id;
    $user = User::find($userId);
    $ApiTokenCreateService = new ApiTokenCreateService($user);

    return $ApiTokenCreateService->respondWithToken();
  }
}
