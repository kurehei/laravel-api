<?php
// 新規登録用のリクエストクラス
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegistUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // rulesメソッドでバリデーションを定義する
    public function rules()
    {
        return [
            //
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'pasword' => 'required|string|min:6|max:10'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $res = response()->json([
            'status' => 400,
            'error' => validator()->errors()
        ], 400);
        throw new HttpResponseException($res);
    }
}
