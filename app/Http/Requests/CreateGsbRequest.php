<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Validator;

class CreateGsbRequest extends FormRequest
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
            'bank_code' => 'required|min:8|unique:bank',
            'branch_code' => 'required|min:8|unique:bank',
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
            'bank_code.required' => 'กรุณาระบุหมายเลขธนาคาร',
            'bank_code.min' => 'หมายเลขธนาคาร ต้องไม่ต่ำกว่า 8 หลัก',
            'bank_code.unique' => 'หมายเลขธนาคารซ้ำ',
            'branch_code.required' => 'กรุณาระบุหมายเลขสาขา',
            'branch_code.min' => 'หมายเลขสาขา ต้องไม่ต่ำกว่า 8 หลัก',
            'branch_code.unique' => 'หมายเลขสาขาซ้ำ',
        ];
    }
}
