<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGsbRequest extends FormRequest
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
            'bank_code' => 'required|min:8|unique:bank,bank_code,' . $this->check_unique['id'],
            'branch_code' => 'required|min:8|unique:bank,branch_code,' . $this->check_unique['id'],
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
            'bank_code.required' => 'กรุณาระบุหมายเลขธนาคารออมสิน',
            'bank_code.min' => 'หมายเลขธนาคารออมสิน ต้องไม่ต่ำกว่า 8 หลัก',
            'bank_code.unique' => 'หมายเลขธนาคารออมสินซ้ำ',
            'branch_code.required' => 'กรุณาระบุหมายเลขสาขา',
            'branch_code.min' => 'หมายเลขสาขา ต้องไม่ต่ำกว่า 8 หลัก',
            'branch_code.unique' => 'หมายเลขสาขาซ้ำ',
        ];
    }
}
