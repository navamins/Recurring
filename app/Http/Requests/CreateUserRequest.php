<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Auth;
use Validator;

class CreateUserRequest extends FormRequest
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
            'emp_code' => 'required|min:7|unique:users',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|not_in:null',
            'password' => 'required|string|min:6|regex:/^.*(?=.{6,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[a-z]).*$/|confirmed',
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
            'emp_code.required' => 'กรุณาระบุรหัสพนักงาน',
            'emp_code.min' => 'ระบุรหัสพนักงานต้องไม่ต่ำกว่า 7 หลัก',
            'emp_code.unique' => 'รหัสพนักงานซ้ำ',
            'email.unique' => 'อีเมล์ซ้ำ',
            'role.not_in' => 'กรุณาเลือกระดับสิทธิ์การเข้าใช้งานระบบ',
            'password.min' => 'รหัสผ่านต้องประกอบไปด้วยตัวเลขและตัวอักษร ตั้งแต่ 6 ตัวอักษรขึ้นไป เช่น "Credit2561"',
            'password.regex' => 'รหัสผ่านต้องประกอบไปด้วยตัวเลขและตัวอักษร ตั้งแต่ 6 ตัวอักษรขึ้นไป เช่น "Credit2561"',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
        ];
    }
}
