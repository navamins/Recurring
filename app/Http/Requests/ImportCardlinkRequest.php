<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Auth;
use Validator;

class ImportCardlinkRequest extends FormRequest
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
            'import_file' => 'required|mimetypes:text/plain',
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
            'import_file.required' => 'กรุณาเลือกไฟล์ เพื่ออัพโหลดข้อมูล',
            'import_file.mimetypes' => 'File Extension ไม่ถูกต้อง อัพโหลดได้เฉพาะ .txt เท่านั้น'
        ];
    }
}
