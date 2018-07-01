<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Auth;
use Validator;

class UpdateAgencyRequest extends FormRequest
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
            'merchant_code' => 'required|min:15|unique:agency,merchant_code,' . $this->check_unique['id'],
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
            'merchant_code.required' => 'กรุณาระบุหมายเลขร้านค้า',
            'merchant_code.min' => 'หมายเลขร้านค้าต้องไม่ต่ำกว่า 15 หลัก',
            'merchant_code.unique' => 'หมายเลขร้านค้าซ้ำ',
        ];
    }
}
