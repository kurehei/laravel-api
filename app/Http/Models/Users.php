<?php

namespace App\Models;
// オートロードは、requireなしで、use演算子を定義するだけで、PHPのクラスを使えるようにする機能です。

use Carbon\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $primaryKey = 'user_id';
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // キャストを行ってくれるバリューの部分で変換したい型を指定する
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // コンストラクタ
    function __construct()
    {
        $this->carbon = $carbon ?? new Carbon();
        $this->now = $this->carbon->timestamp;
    }

     //  アクセサメソッド
     public function getUserName() {
         return $this->name();
     }

     public function getUserEmail() {
         return $this->email();
     }

    // jwtで定義しなければならないメソッド
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
