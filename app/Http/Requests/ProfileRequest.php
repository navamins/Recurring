<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Auth;

class ProfileRequest extends FormRequest
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
            'emp_code' => 'required|min:7|unique:users,emp_code,' . \Auth::user()->id,
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . \Auth::user()->id,
            // 'password_raw' => 'required|string|min:6|regex:/^.*(?=.{6,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[a-z]).*$/',
            // 'password' => 'required|string|min:6|regex:/^.*(?=.{6,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[a-z]).*$/|confirmed',
            
            // The password contains characters from at least three of the following five categories: 
            // (?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z])
            //     English uppercase characters (A – Z)
            //     English lowercase characters (a – z)
            //     Base 10 digits (0 – 9)
            //     Non-alphanumeric (For example: !, $, #, or %)
            //     Unicode characters
            //     First, we need to create a regular expression and validate it.

            // 'password' => 'required|
            //    min:6|
            //    regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|
            //    confirmed',
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
            'email.unique' => 'อีเมล์ซ้ำ',
            // 'password_raw.regex' => 'รหัสผ่านต้องประกอบไปด้วยตัวเลขและตัวอักษร ตั้งแต่ 6 ตัวอักษรขึ้นไป เช่น "Credit2561"',
            // 'password.regex' => 'รหัสผ่านต้องประกอบไปด้วยตัวเลขและตัวอักษร ตั้งแต่ 6 ตัวอักษรขึ้นไป เช่น "Credit2561"',
            // 'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
        ];
    }
}
