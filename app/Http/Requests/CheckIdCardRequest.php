<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Auth;
use Validator;

class CheckIdCardRequest extends FormRequest
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
            'id_card' => 'required|min:13',
            'recurring_type' => 'required|not_in:null',
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
            'id_card.required' => 'กรุณาระบุหมายเลขบัตรประชาชน 13 หลัก',
            'id_card.min' => 'หมายเลขบัตรประชาชนต้องไม่ต่ำกว่า 13 หลัก',
            'recurring_type.required' => 'กรุณาเลือกประเภทรายการชำระ'
        ];
    }
}
