<?php

namespace App\Http\Controllers\Api\V1_0;

use App\Http\Controllers\Controller;
use App\Services\ApiTokenCreateService;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RefreshTokenController extends Controller
{
  private $user;
  private $id;
  private $access_token;

  public function __construct()
  {
    $this->middleware('auth:api', ['except' => ['login']]);
  }

  /**
   * アクセストークンのリフレッシュ
   *
   * @Header - Authorization: Bearer <リフレッシュトークン>
   * @Header - Content-Type: application/json
   * @return \Illuminate\Http\JsonResponse
   */
  public function refreshToken(): JsonResponse
  {
    $this->access_token = Auth::gurad('api')->refresh();
    $this->id = (auth()->user()->id);
    $this->user = User::where('id', $this->id)->first();
    return $this->respondWithToken();
  }

  /**
   * トークンとユーザ情報のJSONデータを返却
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function respondWithToken(): JsonResponse
  {
    return response()->json([
      'token' => [
        'access_token' => $this->access_token,
      ],
      'profile' => [
        'id' => $this->user->id,
        'name' => $this->user->name,
        'email' => $this->user->email
      ]
    ]);
  }
}
