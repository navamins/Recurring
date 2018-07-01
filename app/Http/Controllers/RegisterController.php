<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CheckIdCardRequest;
use App\Http\Requests\CreateRegisterRequest;
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

class RegisterController extends Controller
{
    // function ฟอร์มตรวจสอบหมายเลขบัตรประชาชน 13 หลัก
    public function index()
    {
        $recurring_types = DB::table('recurring_type')->where('useflag','Y')->get();
        return view('user.register.index',compact('recurring_types'));
    }

    // function ตรวจสอบหมายเลขบัตรประชาชน 13 หลัก
    public function verify_id_card(CheckIdCardRequest $request)
    {
        // Check Digit รหัสประชาชน
        $sum=0;
        $resul=0;
        for($i=2;$i <= 13;$i++){
            $sum = $sum + (($request->id_card[$i-2]) * (15-$i));
        }
        $result = 11 -($sum % 11);

        if(strlen($result) == 2){
            if(substr($result,1,1) != substr($request->id_card,12,1)){
                return Redirect::back()->withInput($request->all())->withErrors(array('id_card' => 'หมายเลขบัตรประชาชนไม่ถูกต้อง'));
            }
        }else{
            if($result != substr($request->id_card,12,1)){
                return Redirect::back()->withInput($request->all())->withErrors(array('id_card' => 'หมายเลขบัตรประชาชนไม่ถูกต้อง'));
            }
        }

        $count = DB::table('customer')->where('id_card',$request->id_card)->where('useflag','Y')->count();
        if($count !='0'){
            $customers = DB::table('customer')->where('id_card',$request->id_card)->where('useflag','Y')->get();

            foreach($customers as $customer){
                $id = $customer->id;
                $name_title_id = $customer->name_title_id;
                $name = $customer->name;
                $lastname = $customer->lastname;
                $id_card = $customer->id_card;
            }
        }else{
            $id = null;
            $name_title_id = null;
            $name = null;
            $lastname = null;
            $id_card = $request->id_card;
        }
        
        $name_title = DB::table('name_title')->where('useflag','Y')->get();
        $get_agency = DB::table('agency')->where('recurring_type_id',$request->recurring_type)->where('useflag','Y')->get();
        $recurring_type_name = DB::table('recurring_type')->find($request->recurring_type);

        switch($request->recurring_type){
            case '1' :  
                return view('user.register.create_electricity',compact('name_title','recurring_type_name','get_agency'),[
                    'id'                =>  $id,
                    'name_title_id'     =>  $name_title_id,
                    'name'              =>  $name,
                    'lastname'          =>  $lastname,
                    'id_card'           =>  $id_card
                    ]);
                break;
            default : 
                return view('user.register.not_responding');
        }
    }

    // function ajaxcall อำเภอ/เขต
    // public function ajax_amphures($id)
    // {
    //     $get_amphures = DB::table('amphures')->where('province_id', '=', $id)->get();
    //     return Response::json($get_amphures);
    // }

    // function ajaxcall ตำบล/แขวง
    // public function ajax_districts($id)
    // {
    //     $get_districts = DB::table('districts')->where('amphure_id', '=', $id)->get();
    //     return Response::json($get_districts);
    // }

    // function ajaxcall รหัสไปรษณีย์
    // public function ajax_zipcode($id)
    // {
    //     $get_zipcode = DB::table('districts')->where('id', '=', $id)->get();
    //     return Response::json($get_zipcode);
    // }

    // function ฟอร์มลงทะเบียนชำระค่าสาธารณูปโภค
    public function store(CreateRegisterRequest $request)
    {    
        // dd($request);
        if(Auth::check() != true){
            return view('welcome');
        }else{
            switch (Auth::user()->role) {
                case 'admin':
                case 'user':
                    switch($request->recurring_type_id01){
                        case '1' : // บันทึกฟอร์ม : ค่าไฟฟ้า / ค่าน้ำประปา 
                                // Check Digit รหัสประชาชน
                                $sum=0;
                                $resul=0;
                                for($i=2;$i <= 13;$i++){
                                    $sum = $sum + (($request->id_card[$i-2]) * (15-$i));
                                }
                                $result = 11 -($sum % 11);

                                if(strlen($result) == 2){
                                    if(substr($result,1,1) != substr($request->id_card,12,1)){
                                        return Redirect::back()->withInput($request->all())->withErrors(array('id_card' => 'หมายเลขบัตรประชาชนไม่ถูกต้อง'));
                                    }
                                }else{
                                    if($result != substr($request->id_card,12,1)){
                                        return Redirect::back()->withInput($request->all())->withErrors(array('id_card' => 'หมายเลขบัตรประชาชนไม่ถูกต้อง'));
                                    }
                                }

                                $check_customer = DB::table('customer')->where('id',$request->check_unique['id'])->where('useflag','Y')->count(); // check useflag ของ table customer
                                
                                if($check_customer !=0 ){
                                    $customer = DB::table('customer')
                                        ->where('id',$request->check_unique['id'])
                                        ->where('useflag','Y')
                                        ->update([
                                            'name_title_id'     =>	$request->name_title_id,
                                            'name'	            =>	$request->name,
                                            'lastname'          =>	$request->lastname,
                                            'id_card'           =>  $request->id_card,
                                            'update_user'		=>	Auth::user()->id,
                                            'update_date'		=>	Carbon::now(),
                                            'log'		        =>	'update by '.Auth::user()->role,
                                        ]);
                                    $customer = $request->check_unique['id'];
                                    $register = 'update_customer';
                                }else{
                                    $customer = DB::table('customer')
                                        ->insertGetId([
                                            'name_title_id'     =>	$request->name_title_id,
                                            'name'	            =>	$request->name,
                                            'lastname'          =>	$request->lastname,
                                            'id_card'           =>  $request->id_card,
                                            'useflag'           =>  'Y',
                                            'create_user'       =>  Auth::user()->id,
                                            'create_date'       =>  Carbon::now(),
                                            'update_user'		=>	Auth::user()->id,
                                            'update_date'		=>	Carbon::now(),
                                            'log'		        =>	'insert by '.Auth::user()->role,
                                        ]);
                                    $register = 'new_customer';
                                }
                                // Column 'status_action' 
                                // NOTE: สถานะ Action ของการสมัคร A=Add(สมัครใหม่),C=Change(เปลี่ยนแปลง),D=Delete(ยกเลิก)

                                // Column 'status_agency' 
                                // NOTR: สถานะผลลัพธ์การลงทะเบียนของ Agency โดย 0=Success(สำเร็จ),1=Reject(ไม่สำเร็จ),9=Input 

                                // Column 'status_register' 
                                // NOTE: สถานะการทำงานของ user 
                                // 1.Pending = Call Center บันทึกข้อมูลลูกค้าลงในระบบ Register
                                // 2.Checking = ตรวจสอบหมายเลขบัตรเครดิต
                                // 3.Waiting for correct = ติดต่อผู้ถือบัตร เพื่อตรวจสอบ/แก้ไขข้อมูล
                                // 4.Waiting for reply = อัพเดทสถานะและจัดส่งข้อมูลให้ Business partner
                                // 5.Approved หรือ Rejected = อัพเดทสถานะหลังการตรวจสอบกับ Business partner

                                // บันทึกรายการชำระค่าสาธารณูปโภค ลำดับที่ 1 
                                $contact_account01 = str_pad($request->contact_account01,10,'0',STR_PAD_LEFT); // กำหนดหมายเลข 0 ตัวแรกของ "เลขที่สัญญา" รายการชำระค่าสาธารณูปโภค ลำดับที่ 1

                                if($request->checkbox01 == 'save_01'){
                                    $get_recurring_transaction_01 = DB::table('recurring_transaction')
                                        ->where('customer_id',$customer)
                                        ->where('agency_id',$request->agency_id_01)
                                        ->where('contact_account',$contact_account01)
                                        ->where('meter_number',$request->meter_number01)
                                        ->where('useflag','Y')
                                        ->get();
                                        
                                    if($get_recurring_transaction_01->isEmpty()){ // ตรวจสอบรายชื่อลูกค้า, หน่วยงาน, เลขที่สัญญาและหมายเลขเครื่องวัด กรณีไม่พบ
                                        $card_number_encryptString_01 = Crypt::encryptString($request->card_number1_01.$request->card_number2_01.$request->card_number3_01.$request->card_number4_01);
                                        $get_cards_01 = DB::table('card')->where('useflag','Y')->get();

                                        foreach($get_cards_01 as $get_card_01){
                                            if($get_card_01->card_type_number == $request->card_number1_01.$request->card_number2_01){ // ตรวจสอบ format ของหมายเลขบัตรเครดิต 8 หลักแรก
                                                $insert_recurring_transaction_01 = DB::table('recurring_transaction')
                                                    ->insert([
                                                        'apply_date'        =>  $request->applydate_01,
                                                        'card_number'       =>  $card_number_encryptString_01,
                                                        'contact_account'   =>  $contact_account01,
                                                        'meter_number'      =>  $request->meter_number01,
                                                        'status_action'     =>  'A',
                                                        'status_agency'     =>  '9',     
                                                        'status_register'   =>  'Pending',
                                                        'customer_id'       =>  $customer,
                                                        'agency_id'         =>  $request->agency_id_01,
                                                        'useflag'           =>  'Y',
                                                        'create_user'       =>  Auth::user()->id,
                                                        'create_date'       =>  Carbon::now(),
                                                        'update_user'		=>	Auth::user()->id,
                                                        'update_date'		=>	Carbon::now(),
                                                        'log'		        =>	'insert by '.Auth::user()->role,
                                                    ]);
                                                if(!$insert_recurring_transaction_01){
                                                    return Redirect::back()->withInput($request->all());
                                                }
                                            }
                                        }
                                    }else{
                                        if($register == 'update_customer'){
                                            foreach($get_recurring_transaction_01 as $check_card_01){
                                                if(Crypt::decryptString($check_card_01->card_number) == $request->card_number1_01.$request->card_number2_01.$request->card_number3_01.$request->card_number4_01 && ($check_card_01->status_agency == '0' || $check_card_01->status_agency == '1')){
                                                    $update_recurring_transaction_01 = DB::table('recurring_transaction')
                                                        ->where('id',$check_card_01->id)
                                                        ->where('useflag','Y')
                                                        ->update([
                                                            'apply_date'        =>  $request->applydate_01,
                                                            'status_action'     =>  'C',
                                                            'status_agency'     =>  '9',     
                                                            'status_register'   =>  'Pending',
                                                            'update_user'		=>	Auth::user()->id,
                                                            'update_date'		=>	Carbon::now(),
                                                            'log'		        =>	'update by '.Auth::user()->role,
                                                        ]);
                                                    if(!$update_recurring_transaction_01){
                                                        return Redirect::back()->withInput($request->all());
                                                    }
                                                }elseif(Crypt::decryptString($check_card_01->card_number) == $request->card_number1_01.$request->card_number2_01.$request->card_number3_01.$request->card_number4_01 && $check_card_01->status_agency == '9'){
                                                    $update_recurring_transaction_01 = DB::table('recurring_transaction')
                                                        ->where('id',$check_card_01->id)
                                                        ->where('useflag','Y')
                                                        ->update([
                                                            'apply_date'        =>  $request->applydate_01,
                                                            'status_action'     =>  'A',
                                                            'status_agency'     =>  '9',     
                                                            'status_register'   =>  'Pending',
                                                            'update_user'		=>	Auth::user()->id,
                                                            'update_date'		=>	Carbon::now(),
                                                            'log'		        =>	'update by '.Auth::user()->role,
                                                        ]);
                                                    if(!$update_recurring_transaction_01){
                                                        return Redirect::back()->withInput($request->all());
                                                    }
                                                }  
                                            }
                                        }
                                    }
                                }

                                // บันทึกรายการชำระค่าสาธารณูปโภค ลำดับที่ 2
                                $contact_account02 = str_pad($request->contact_account02,10,'0',STR_PAD_LEFT); // กำหนดหมายเลข 0 ตัวแรกของ "เลขที่สัญญา" รายการชำระค่าสาธารณูปโภค ลำดับที่ 2
                                if($request->checkbox02 == 'save_02'){
                                    $get_recurring_transaction_02 = DB::table('recurring_transaction')
                                        ->where('customer_id',$customer)
                                        ->where('agency_id',$request->agency_id_02)
                                        ->where('contact_account',$contact_account02)
                                        ->where('meter_number',$request->meter_number02)
                                        ->where('useflag','Y')
                                        ->get();
                                        
                                    if($get_recurring_transaction_02->isEmpty()){ // ตรวจสอบรายชื่อลูกค้า, หน่วยงาน, เลขที่สัญญาและหมายเลขเครื่องวัด กรณีไม่พบ
                                        $card_number_encryptString_02 = Crypt::encryptString($request->card_number1_02.$request->card_number2_02.$request->card_number3_02.$request->card_number4_02);
                                        $get_cards_02 = DB::table('card')->where('useflag','Y')->get();

                                        foreach($get_cards_02 as $get_card_02){ 
                                            if($get_card_02->card_type_number == $request->card_number1_02.$request->card_number2_02){ // ตรวจสอบ format ของหมายเลขบัตรเครดิต 8 หลักแรก
                                                $insert_recurring_transaction_02 = DB::table('recurring_transaction')
                                                    ->insert([
                                                        'apply_date'        =>  $request->applydate_02,
                                                        'card_number'       =>  $card_number_encryptString_02,
                                                        'contact_account'   =>  $contact_account02,
                                                        'meter_number'      =>  $request->meter_number02,
                                                        'status_action'     =>  'A',
                                                        'status_agency'     =>  '9',     
                                                        'status_register'   =>  'Pending',
                                                        'customer_id'       =>  $customer,
                                                        'agency_id'         =>  $request->agency_id_02,
                                                        'useflag'           =>  'Y',
                                                        'create_user'       =>  Auth::user()->id,
                                                        'create_date'       =>  Carbon::now(),
                                                        'update_user'		=>	Auth::user()->id,
                                                        'update_date'		=>	Carbon::now(),
                                                        'log'		        =>	'insert by '.Auth::user()->role,
                                                    ]);
                                                if(!$insert_recurring_transaction_02){
                                                    return Redirect::back()->withInput($request->all());
                                                }
                                            }
                                        }
                                    }else{
                                        if($register == 'update_customer'){
                                            foreach($get_recurring_transaction_02 as $check_card_02){
                                                if(Crypt::decryptString($check_card_02->card_number) == $request->card_number1_02.$request->card_number2_02.$request->card_number3_02.$request->card_number4_02 && ($check_card_02->status_agency == '0' || $check_card_02->status_agency == '1')){
                                                    $update_recurring_transaction_02 = DB::table('recurring_transaction')
                                                        ->where('id',$check_card_02->id)
                                                        ->where('useflag','Y')
                                                        ->update([
                                                            'apply_date'        =>  $request->applydate_02,
                                                            'status_action'     =>  'C',
                                                            'status_agency'     =>  '9',     
                                                            'status_register'   =>  'Pending',
                                                            'update_user'		=>	Auth::user()->id,
                                                            'update_date'		=>	Carbon::now(),
                                                            'log'		        =>	'update by '.Auth::user()->role,
                                                        ]);
                                                    if(!$update_recurring_transaction_02){
                                                        return Redirect::back()->withInput($request->all());
                                                    }
                                                }elseif(Crypt::decryptString($check_card_02->card_number) == $request->card_number1_02.$request->card_number2_02.$request->card_number3_02.$request->card_number4_02 && $check_card_02->status_agency == '9'){
                                                    $update_recurring_transaction_02 = DB::table('recurring_transaction')
                                                        ->where('id',$check_card_02->id)
                                                        ->where('useflag','Y')
                                                        ->update([
                                                            'apply_date'        =>  $request->applydate_02,
                                                            'status_action'     =>  'A',
                                                            'status_agency'     =>  '9',     
                                                            'status_register'   =>  'Pending',
                                                            'update_user'		=>	Auth::user()->id,
                                                            'update_date'		=>	Carbon::now(),
                                                            'log'		        =>	'update by '.Auth::user()->role,
                                                        ]);
                                                    if(!$update_recurring_transaction_02){
                                                        return Redirect::back()->withInput($request->all());
                                                    }
                                                }  
                                            }
                                        }
                                    }
                                }

                                // บันทึกรายการชำระค่าสาธารณูปโภค ลำดับที่ 3
                                $contact_account03 = str_pad($request->contact_account03,10,'0',STR_PAD_LEFT); // กำหนดหมายเลข 0 ตัวแรกของ "เลขที่สัญญา" รายการชำระค่าสาธารณูปโภค ลำดับที่ 3
                                if($request->checkbox03 == 'save_03'){
                                    $get_recurring_transaction_03 = DB::table('recurring_transaction')
                                        ->where('customer_id',$customer)
                                        ->where('agency_id',$request->agency_id_03)
                                        ->where('contact_account',$contact_account03)
                                        ->where('meter_number',$request->meter_number03)
                                        ->where('useflag','Y')
                                        ->get();
                                        
                                    if($get_recurring_transaction_03->isEmpty()){ // ตรวจสอบรายชื่อลูกค้า, หน่วยงาน, เลขที่สัญญาและหมายเลขเครื่องวัด กรณีไม่พบ
                                        $card_number_encryptString_03 = Crypt::encryptString($request->card_number1_03.$request->card_number2_03.$request->card_number3_03.$request->card_number4_03);
                                        $get_cards_03 = DB::table('card')->where('useflag','Y')->get();

                                        foreach($get_cards_03 as $get_card_03){
                                            if($get_card_03->card_type_number == $request->card_number1_03.$request->card_number2_03){ // ตรวจสอบ format ของหมายเลขบัตรเครดิต 8 หลักแรก
                                                $insert_recurring_transaction_03 = DB::table('recurring_transaction')
                                                    ->insert([
                                                        'apply_date'        =>  $request->applydate_03,
                                                        'card_number'       =>  $card_number_encryptString_03,
                                                        'contact_account'   =>  $contact_account03,
                                                        'meter_number'      =>  $request->meter_number03,
                                                        'status_action'     =>  'A',
                                                        'status_agency'     =>  '9',     
                                                        'status_register'   =>  'Pending',
                                                        'customer_id'       =>  $customer,
                                                        'agency_id'         =>  $request->agency_id_03,
                                                        'useflag'           =>  'Y',
                                                        'create_user'       =>  Auth::user()->id,
                                                        'create_date'       =>  Carbon::now(),
                                                        'update_user'		=>	Auth::user()->id,
                                                        'update_date'		=>	Carbon::now(),
                                                        'log'		        =>	'insert by '.Auth::user()->role,
                                                    ]);
                                                if(!$insert_recurring_transaction_03){
                                                    return Redirect::back()->withInput($request->all());
                                                }
                                            }
                                        }
                                    }else{
                                        if($register == 'update_customer'){
                                            foreach($get_recurring_transaction_03 as $check_card_03){
                                                if(Crypt::decryptString($check_card_03->card_number) == $request->card_number1_03.$request->card_number2_03.$request->card_number3_03.$request->card_number4_03 && ($check_card_03->status_agency == '0' || $check_card_03->status_agency == '1')){
                                                    $update_recurring_transaction_03 = DB::table('recurring_transaction')
                                                        ->where('id',$check_card_03->id)
                                                        ->where('useflag','Y')
                                                        ->update([
                                                            'apply_date'        =>  $request->applydate_03,
                                                            'status_action'     =>  'C',
                                                            'status_agency'     =>  '9',     
                                                            'status_register'   =>  'Pending',
                                                            'update_user'		=>	Auth::user()->id,
                                                            'update_date'		=>	Carbon::now(),
                                                            'log'		        =>	'update by '.Auth::user()->role,
                                                        ]);
                                                    if(!$update_recurring_transaction_03){
                                                        return Redirect::back()->withInput($request->all());
                                                    }
                                                }elseif(Crypt::decryptString($check_card_03->card_number) == $request->card_number1_03.$request->card_number2_03.$request->card_number3_03.$request->card_number4_03 && $check_card_03->status_agency == '9'){
                                                    $update_recurring_transaction_03 = DB::table('recurring_transaction')
                                                        ->where('id',$check_card_03->id)
                                                        ->where('useflag','Y')
                                                        ->update([
                                                            'apply_date'        =>  $request->applydate_03,
                                                            'status_action'     =>  'A',
                                                            'status_agency'     =>  '9',     
                                                            'status_register'   =>  'Pending',
                                                            'update_user'		=>	Auth::user()->id,
                                                            'update_date'		=>	Carbon::now(),
                                                            'log'		        =>	'update by '.Auth::user()->role,
                                                        ]);
                                                    if(!$update_recurring_transaction_03){
                                                        return Redirect::back()->withInput($request->all());
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                // บันทึกรายการชำระค่าสาธารณูปโภค ลำดับที่ 4 
                                $contact_account04 = str_pad($request->contact_account04,10,'0',STR_PAD_LEFT); // กำหนดหมายเลข 0 ตัวแรกของ "เลขที่สัญญา" รายการชำระค่าสาธารณูปโภค ลำดับที่ 4
                                if($request->checkbox04 == 'save_04'){
                                    $get_recurring_transaction_04 = DB::table('recurring_transaction')
                                        ->where('customer_id',$customer)
                                        ->where('agency_id',$request->agency_id_04)
                                        ->where('contact_account',$contact_account04)
                                        ->where('meter_number',$request->meter_number04)
                                        ->where('useflag','Y')
                                        ->get();
                                        
                                    if($get_recurring_transaction_04->isEmpty()){ // ตรวจสอบรายชื่อลูกค้า, หน่วยงาน, เลขที่สัญญาและหมายเลขเครื่องวัด กรณีไม่พบ
                                        $card_number_encryptString_04 = Crypt::encryptString($request->card_number1_04.$request->card_number2_04.$request->card_number3_04.$request->card_number4_04);
                                        $get_cards_04 = DB::table('card')->where('useflag','Y')->get();

                                        foreach($get_cards_04 as $get_card_04){
                                            if($get_card_04->card_type_number == $request->card_number1_04.$request->card_number2_04){ // ตรวจสอบ format ของหมายเลขบัตรเครดิต 8 หลักแรก
                                                $insert_recurring_transaction_04 = DB::table('recurring_transaction')
                                                    ->insert([
                                                        'apply_date'        =>  $request->applydate_04,
                                                        'card_number'       =>  $card_number_encryptString_04,
                                                        'contact_account'   =>  $contact_account04,
                                                        'meter_number'      =>  $request->meter_number04,
                                                        'status_action'     =>  'A',
                                                        'status_agency'     =>  '9',     
                                                        'status_register'   =>  'Pending',
                                                        'customer_id'       =>  $customer,
                                                        'agency_id'         =>  $request->agency_id_04,
                                                        'useflag'           =>  'Y',
                                                        'create_user'       =>  Auth::user()->id,
                                                        'create_date'       =>  Carbon::now(),
                                                        'update_user'		=>	Auth::user()->id,
                                                        'update_date'		=>	Carbon::now(),
                                                        'log'		        =>	'insert by '.Auth::user()->role,
                                                    ]);
                                                if(!$insert_recurring_transaction_04){
                                                    return Redirect::back()->withInput($request->all());
                                                }
                                            }
                                        }
                                    }else{
                                        if($register == 'update_customer'){
                                            foreach($get_recurring_transaction_04 as $check_card_04){
                                                if(Crypt::decryptString($check_card_04->card_number) == $request->card_number1_04.$request->card_number2_04.$request->card_number3_04.$request->card_number4_04 && ($check_card_04->status_agency == '0' || $check_card_04->status_agency == '1')){
                                                    $update_recurring_transaction_04 = DB::table('recurring_transaction')
                                                        ->where('id',$check_card_04->id)
                                                        ->where('useflag','Y')
                                                        ->update([
                                                            'apply_date'        =>  $request->applydate_04,
                                                            'status_action'     =>  'C',
                                                            'status_agency'     =>  '9',     
                                                            'status_register'   =>  'Pending',
                                                            'update_user'		=>	Auth::user()->id,
                                                            'update_date'		=>	Carbon::now(),
                                                            'log'		        =>	'update by '.Auth::user()->role,
                                                        ]);
                                                    if(!$update_recurring_transaction_04){
                                                        return Redirect::back()->withInput($request->all());
                                                    }
                                                }elseif(Crypt::decryptString($check_card_04->card_number) == $request->card_number1_04.$request->card_number2_04.$request->card_number3_04.$request->card_number4_04 && $check_card_04->status_agency == '9'){
                                                    $update_recurring_transaction_04 = DB::table('recurring_transaction')
                                                        ->where('id',$check_card_04->id)
                                                        ->where('useflag','Y')
                                                        ->update([
                                                            'apply_date'        =>  $request->applydate_04,
                                                            'status_action'     =>  'A',
                                                            'status_agency'     =>  '9',     
                                                            'status_register'   =>  'Pending',
                                                            'update_user'		=>	Auth::user()->id,
                                                            'update_date'		=>	Carbon::now(),
                                                            'log'		        =>	'update by '.Auth::user()->role,
                                                        ]);
                                                    if(!$update_recurring_transaction_04){
                                                        return Redirect::back()->withInput($request->all());
                                                    }
                                                }  
                                            }
                                        }
                                    }
                                }
                                return redirect()->route('register.index')->with('success', 'บันทึกข้อมูลการลงทะเบียน ของรายการชำระค่าสาธารณูปโภคสำเร็จ');
                            break;

                        default :
                                return view('user.register.not_responding');
                            break;
                    }
                    break;
                
                default :
                        return Redirect::back()->withInput()->withErrors(array('errors' => 'ไม่สามารถลงทะเบียนชำระค่าสาธารณูปโภคได้ กรุณาติดต่อ Administrator'));
                    break;
            }
        }
    }
}


