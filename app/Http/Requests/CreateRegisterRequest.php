<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Response;
use Datatables;
use Auth;
use Hash;
use Redirect;
use Validator;
use App\User;

class CreateRegisterRequest extends FormRequest
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
        if($this->checkbox01 == 'save_01' && $this->checkbox02 == null && $this->checkbox03 == null && $this->checkbox04 == null){
            return [
                'name_title_id' => 'required',
                'name' => 'required|regex:/^.*(?=.*[ก-๙]).*$/',
                'lastname' => 'required',
                'id_card' => 'required|digits:13|unique:customer,id_card,NULL,id,useflag,Y' . $this->check_unique['id'],

                // ตรวจสอบรายการชำระค่าสาธารณูปโภค ลำดับที่ 1
                'card_number1_01' => 'required|digits:4',
                'card_number2_01' => 'required|digits:4',
                'card_number3_01' => 'required|digits:4',
                'card_number4_01' => 'required|digits:4',
                'agency_id_01' => 'required',
                'contact_account01' => 'required|digits:9',
                'meter_number01' => 'required|digits:8',
                'applydate_01' => 'required|date|date_format:Y-m-d|before:tomorrow',
            ];
        }elseif($this->checkbox01 == 'save_01' && $this->checkbox02 == 'save_02' && $this->checkbox03 == null && $this->checkbox04 == null){
            return [
                'name_title_id' => 'required',
                'name' => 'required|regex:/^.*(?=.*[ก-๙]).*$/',
                'lastname' => 'required',
                'id_card' => 'required|digits:13|unique:customer,id_card,NULL,id,useflag,Y' . $this->check_unique['id'],

                // ตรวจสอบรายการชำระค่าสาธารณูปโภค ลำดับที่ 1
                'card_number1_01' => 'required|digits:4',
                'card_number2_01' => 'required|digits:4',
                'card_number3_01' => 'required|digits:4',
                'card_number4_01' => 'required|digits:4',
                'agency_id_01' => 'required',
                'contact_account01' => 'required|digits:9',
                'meter_number01' => 'required|digits:8',
                'applydate_01' => 'required|date|date_format:Y-m-d|before:tomorrow',

                // ตรวจสอบรายการชำระค่าสาธารณูปโภค ลำดับที่ 2
                'card_number1_02' => 'required|digits:4',
                'card_number2_02' => 'required|digits:4',
                'card_number3_02' => 'required|digits:4',
                'card_number4_02' => 'required|digits:4',
                'agency_id_02' => 'required',
                'contact_account02' => 'required|digits:9',
                'meter_number02' => 'required|digits:8',
                'applydate_02' => 'required|date|date_format:Y-m-d|before:tomorrow',
            ];
        }elseif($this->checkbox01 == 'save_01' && $this->checkbox02 == 'save_02' && $this->checkbox03 == 'save_03' && $this->checkbox04 == null){
            return [
                'name_title_id' => 'required',
                'name' => 'required|regex:/^.*(?=.*[ก-๙]).*$/',
                'lastname' => 'required',
                'id_card' => 'required|digits:13|unique:customer,id_card,NULL,id,useflag,Y' . $this->check_unique['id'],

                // ตรวจสอบรายการชำระค่าสาธารณูปโภค ลำดับที่ 1
                'card_number1_01' => 'required|digits:4',
                'card_number2_01' => 'required|digits:4',
                'card_number3_01' => 'required|digits:4',
                'card_number4_01' => 'required|digits:4',
                'agency_id_01' => 'required',
                'contact_account01' => 'required|digits:9',
                'meter_number01' => 'required|digits:8',
                'applydate_01' => 'required|date|date_format:Y-m-d|before:tomorrow',

                // ตรวจสอบรายการชำระค่าสาธารณูปโภค ลำดับที่ 2
                'card_number1_02' => 'required|digits:4',
                'card_number2_02' => 'required|digits:4',
                'card_number3_02' => 'required|digits:4',
                'card_number4_02' => 'required|digits:4',
                'agency_id_02' => 'required',
                'contact_account02' => 'required|digits:10',
                'meter_number02' => 'required|digits:8',
                'applydate_02' => 'required|date|date_format:Y-m-d|before:tomorrow',

                // ตรวจสอบรายการชำระค่าสาธารณูปโภค ลำดับที่ 3
                'card_number1_03' => 'required|digits:4',
                'card_number2_03' => 'required|digits:4',
                'card_number3_03' => 'required|digits:4',
                'card_number4_03' => 'required|digits:4',
                'agency_id_03' => 'required',
                'contact_account03' => 'required|digits:9',
                'meter_number03' => 'required|digits:8',
                'applydate_03' => 'required|date|date_format:Y-m-d|before:tomorrow',
            ];
        }elseif($this->checkbox01 == 'save_01' && $this->checkbox02 == 'save_02' && $this->checkbox03 == 'save_03' && $this->checkbox04 == 'save_04'){
            return [
                'name_title_id' => 'required',
                'name' => 'required|regex:/^.*(?=.*[ก-๙]).*$/',
                'lastname' => 'required',
                'id_card' => 'required|digits:13|unique:customer,id_card,NULL,id,useflag,Y' . $this->check_unique['id'],

                // ตรวจสอบรายการชำระค่าสาธารณูปโภค ลำดับที่ 1
                'card_number1_01' => 'required|digits:4',
                'card_number2_01' => 'required|digits:4',
                'card_number3_01' => 'required|digits:4',
                'card_number4_01' => 'required|digits:4',
                'agency_id_01' => 'required',
                'contact_account01' => 'required|digits:9',
                'meter_number01' => 'required|digits:8',
                'applydate_01' => 'required|date|date_format:Y-m-d|before:tomorrow',

                // ตรวจสอบรายการชำระค่าสาธารณูปโภค ลำดับที่ 2
                'card_number1_02' => 'required|digits:4',
                'card_number2_02' => 'required|digits:4',
                'card_number3_02' => 'required|digits:4',
                'card_number4_02' => 'required|digits:4',
                'agency_id_02' => 'required',
                'contact_account02' => 'required|digits:9',
                'meter_number02' => 'required|digits:8',
                'applydate_02' => 'required|date|date_format:Y-m-d|before:tomorrow',

                // ตรวจสอบรายการชำระค่าสาธารณูปโภค ลำดับที่ 3
                'card_number1_03' => 'required|digits:4',
                'card_number2_03' => 'required|digits:4',
                'card_number3_03' => 'required|digits:4',
                'card_number4_03' => 'required|digits:4',
                'agency_id_03' => 'required',
                'contact_account03' => 'required|digits:9',
                'meter_number03' => 'required|digits:8',
                'applydate_03' => 'required|date|date_format:Y-m-d|before:tomorrow',

                // ตรวจสอบรายการชำระค่าสาธารณูปโภค ลำดับที่ 4
                'card_number1_04' => 'required|digits:4',
                'card_number2_04' => 'required|digits:4',
                'card_number3_04' => 'required|digits:4',
                'card_number4_04' => 'required|digits:4',
                'agency_id_04' => 'required',
                'contact_account04' => 'required|digits:9',
                'meter_number04' => 'required|digits:8',
                'applydate_04' => 'required|date|date_format:Y-m-d|before:tomorrow',
            ];
        }else{
            return [
                'checkbox01' => 'required',
                'checkbox02' => 'required',
                'checkbox03' => 'required',
                'checkbox04' => 'required',
            ];
        }
    }
     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name_title_id.required' => 'กรุณาเลือกคำนำหน้าชื่อ',
            'name.required' => 'กรุณาระบุชื่อด้วยภาษาไทย',
            'lastname.required' => 'กรุณาระบุนามสกุลด้วยภาษาไทย',
            'id_card.required' => 'กรุณาระบุหมายเลขบัตรประชาชน 13 หลัก',
            'id_card.digits' => 'หมายเลขบัตรประชาชนไม่ครบ 13 หลัก',
            'id_card.unique' => 'หมายเลขบัตรประชาชนซ้ำ',

            // เงื่อนไขตรวจสอบการ Check โดยต้องทำการเรียงลำดับ
            'checkbox01.required' => 'กรุณาเลือกบันทึกรายการเรียงตามลำดับที่ 1 - 4',
            'checkbox02.required' => 'กรุณาเลือกบันทึกรายการเรียงตามลำดับที่ 1 - 4',
            'checkbox03.required' => 'กรุณาเลือกบันทึกรายการเรียงตามลำดับที่ 1 - 4',
            'checkbox04.required' => 'กรุณาเลือกบันทึกรายการเรียงตามลำดับที่ 1 - 4',

            // ตรวจสอบรายการชำระค่าสาธารณูปโภค ลำดับที่ 1
            'card_number1_01.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 1)',
            'card_number1_01.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 1)',
            'card_number2_01.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 1)',
            'card_number2_01.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 1)',
            'card_number3_01.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 1)',
            'card_number3_01.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 1)',
            'card_number4_01.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 1)',
            'card_number4_01.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 1)',
            'agency_id_01.required' => 'กรุณาเลือกหน่วยงาน (รายการชำระค่าสาธารณูปโภค ลำดับที่ 1)',
            'contact_account01.required' => 'กรุณาระบุเลขที่สัญญา (รายการชำระค่าสาธารณูปโภค ลำดับที่ 1)',
            'contact_account01.digits' => 'เลขที่สัญญาไม่ครบ 9 หลัก (รายการชำระค่าสาธารณูปโภค ลำดับที่ 1)',
            'meter_number01.required' => 'กรุณาระบุหมายเลขเครื่องวัด (รายการชำระค่าสาธารณูปโภค ลำดับที่ 1)',
            'meter_number01.digits' => 'หมายเลขเครื่องวัดไม่ครบ 8 หลัก (รายการชำระค่าสาธารณูปโภค ลำดับที่ 1)',
            'applydate_01.required' => 'กรุณาระบุวันที่สมัคร (รายการชำระค่าสาธารณูปโภค ลำดับที่ 1)',
            'applydate_01.before' => 'ไม่สามารถบันทึกวันที่สมัครล่วงหน้าได้ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 1)',

            // ตรวจสอบรายการชำระค่าสาธารณูปโภค ลำดับที่ 2
            'card_number1_02.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 2)',
            'card_number1_02.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 2)',
            'card_number2_02.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 2)',
            'card_number2_02.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 2)',
            'card_number3_02.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 2)',
            'card_number3_02.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 2)',
            'card_number4_02.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 2)',
            'card_number4_02.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 2)',
            'agency_id_02.required' => 'กรุณาเลือกหน่วยงาน (รายการชำระค่าสาธารณูปโภค ลำดับที่ 2)',
            'contact_account02.required' => 'กรุณาระบุเลขที่สัญญา (รายการชำระค่าสาธารณูปโภค ลำดับที่ 2)',
            'contact_account02.digits' => 'เลขที่สัญญาไม่ครบ 9 หลัก (รายการชำระค่าสาธารณูปโภค ลำดับที่ 2)',
            'meter_number02.required' => 'กรุณาระบุหมายเลขเครื่องวัด (รายการชำระค่าสาธารณูปโภค ลำดับที่ 2)',
            'meter_number02.digits' => 'หมายเลขเครื่องวัดไม่ครบ 8 หลัก (รายการชำระค่าสาธารณูปโภค ลำดับที่ 2)',
            'applydate_02.required' => 'กรุณาระบุวันที่สมัคร (รายการชำระค่าสาธารณูปโภค ลำดับที่ 2)',
            'applydate_02.before' => 'ไม่สามารถบันทึกวันที่สมัครล่วงหน้าได้ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 2)',

            // ตรวจสอบรายการชำระค่าสาธารณูปโภค ลำดับที่ 3
            'card_number1_03.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 3)',
            'card_number1_03.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 3)',
            'card_number2_03.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 3)',
            'card_number2_03.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 3)',
            'card_number3_03.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 3)',
            'card_number3_03.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 3)',
            'card_number4_03.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 3)',
            'card_number4_03.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 3)',
            'agency_id_03.required' => 'กรุณาเลือกหน่วยงาน (รายการชำระค่าสาธารณูปโภค ลำดับที่ 3)',
            'contact_account03.required' => 'กรุณาระบุเลขที่สัญญา (รายการชำระค่าสาธารณูปโภค ลำดับที่ 3)',
            'contact_account03.digits' => 'เลขที่สัญญาไม่ครบ 9 หลัก (รายการชำระค่าสาธารณูปโภค ลำดับที่ 3)',
            'meter_number03.required' => 'กรุณาระบุหมายเลขเครื่องวัด (รายการชำระค่าสาธารณูปโภค ลำดับที่ 3)',
            'meter_number03.digits' => 'หมายเลขเครื่องวัดไม่ครบ 8 หลัก (รายการชำระค่าสาธารณูปโภค ลำดับที่ 3)',
            'applydate_03.required' => 'กรุณาระบุวันที่สมัคร (รายการชำระค่าสาธารณูปโภค ลำดับที่ 3)',
            'applydate_03.before' => 'ไม่สามารถบันทึกวันที่สมัครล่วงหน้าได้ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 3)',

            // ตรวจสอบรายการชำระค่าสาธารณูปโภค ลำดับที่ 4
            'card_number1_04.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 4)',
            'card_number1_04.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 4)',
            'card_number2_04.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 4)',
            'card_number2_04.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 4)',
            'card_number3_04.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 4)',
            'card_number3_04.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 4)',
            'card_number4_04.required' => 'กรุณาระบุหมายเลขบัตรเครดิต (รายการชำระค่าสาธารณูปโภค ลำดับที่ 4)',
            'card_number4_04.digits' => 'หมายเลขบัตรเครดิตไม่ครบ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 4)',
            'agency_id_04.required' => 'กรุณาเลือกหน่วยงาน (รายการชำระค่าสาธารณูปโภค ลำดับที่ 4)',
            'contact_account04.required' => 'กรุณาระบุเลขที่สัญญา (รายการชำระค่าสาธารณูปโภค ลำดับที่ 4)',
            'contact_account04.digits' => 'เลขที่สัญญาไม่ครบ 9 หลัก (รายการชำระค่าสาธารณูปโภค ลำดับที่ 4)',
            'meter_number04.required' => 'กรุณาระบุหมายเลขเครื่องวัด (รายการชำระค่าสาธารณูปโภค ลำดับที่ 4)',
            'meter_number04.digits' => 'หมายเลขเครื่องวัดไม่ครบ 8 หลัก (รายการชำระค่าสาธารณูปโภค ลำดับที่ 4)',
            'applydate_04.required' => 'กรุณาระบุวันที่สมัคร (รายการชำระค่าสาธารณูปโภค ลำดับที่ 4)',
            'applydate_04.before' => 'ไม่สามารถบันทึกวันที่สมัครล่วงหน้าได้ (รายการชำระค่าสาธารณูปโภค ลำดับที่ 4)',
        ];
    }
}
