<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Auth;
use Validator;

class UpdateNumberTypeRequest extends FormRequest
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
            'card_name' => 'required',
            'card_type_number' => 'required|digits:8|unique:card,card_type_number,' . $this->check_unique['id'],
            'card_type' => 'required|not_in:null',
            'addImage' => 'image|mimes:jpeg,png,jpg|max:2048',
            'card_detail' => 'required',
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
            'card_name.required' => 'กรุณาระบุชื่อบัตรเครดิต',
            'card_type_number.required' => 'กรุณาระบุหมายเลขบัตรเครดิต 8 หลัก (BIN 6 หลัก + Type)',
            'card_type_number.digits' => 'หมายเลขบัตรเครดิตไม่ครบ 8 หลัก',
            'card_type_number.unique' => 'หมายเลขบัตรเครดิตซ้ำ',
            'card_type.required' => 'กรุณาเลือกประเภทบัตรเครดิต',
            'card_type.not_in' => 'กรุณาเลือกประเภทบัตรเครดิต',
            // 'addImage.required' => 'กรุณาอัพโหลดรูปภาพ โดยชื่อ File ต้องเป็นภาษาอังกฤษเท่านั้น',
            'addImage.image' => 'อัพโหลดได้เฉพาะไฟล์รูปภาพเท่านั้น',
            'addImage.mimes' => 'ระบบรองรับไฟล์รูปภาพ JPG, JPEG, PNG',
            'addImage.max' => 'ระบบรองรับไฟล์รูปภาพขนาดไม่เกิน 2 MB หรือ 2048 KB',
            'card_detail.required' => 'กรุณาระบุรายละเอียดของบัตรเครดิต',
        ];
    }
}
