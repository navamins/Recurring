<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Auth;
use Validator;

class UpdateUserPwRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|string|min:6|regex:/^.*(?=.{6,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[a-z]).*$/|confirmed',
        ];
    }
     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.min' => 'รหัสผ่านต้องมีตั้งแต่ 6 ตัวอักษรขึ้นไป เช่น "Credit2561"',
            'password.regex' => 'รหัสผ่านต้องประกอบไปด้วยตัวเลขและตัวอักษร ตั้งแต่ 6 ตัวอักษรขึ้นไป เช่น "Credit2561"',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
        ];
    }
}
