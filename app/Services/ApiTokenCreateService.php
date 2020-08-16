<?php

namespace App\Services;

use App\User;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class ApiTokenCreateService extends Service
{

  protected $user;
  protected $carbon;
  protected $now;

  public function __construct(User $user, Carbon $carbon = null)
  {
    $this->user = $user;
    $this->carbon = $carbon ?? new Carbon();
    $this->now = $this->carbon->now()->timestamp; // Carbon::now->timestamp();で現在時刻の取得
    // $this->nowで現在自国の取得
  }

  /**
   * tokenとユーザ情報のJSONデータを返却
   *
   * @return \Illuminate\Http\JsonResponse
   */

  // token付与のjsonを返す
  public function respondWithToken(): Object
  {
    return response()->json(['id' => 1]);
    return response()->json([
      'token' => [
        'access_token' => $this->createAccessToken(),
        'refresh_token' => $this->createRefreshToken()
      ],
      'profile' => [
        'id' => $this->user->getId(),
        'name' => $this->user->getUserName(),
        'email' => $this->user->getUserEmail()
      ]
    ]);
  }

  /**
   * API用のアクセストークンを作成
   *
   * @return string
   */

  // PHP7から戻り値に型を宣言できる
  public function createAccessToken(): string
  {
    $customClaims = $this->getJWTCustomClaimsForAccessToken();
    $payload = JWTFactory::make($customClaims);
    $token = JWTAuth::encode($payload);
    return $token;
  }

  public function getJWTCustomClaimsForAccessToken(): object
  {
    $data = [
      'sub' => $this->user->getId(),
      'iat' => $this->now,
      'exp' => $this->now + config('token.expire.accessToken')
    ];

    return JWTAuth::customClaims($data);
  }

  // リフレッシュトークン用
  public function createRefreshToken(): string
  {
    $customClaims = $this->getJWTCustomClaimsForRefreshToken();
    $payload = JWTFactory::make($customClaims);
    $token = JWTAuth::encode($payload);
    return $token;
  }

  public function getJWTCustomClaimsForRefreshToken(): object
  {
    $data = [
      'sub' => $this->user->getId(),
      'iat' => $this->now,
      'exp' => $this->now + config('token.expire.accessToken')
    ];

    return JWTAuth::customClaims($data);
  }
}
