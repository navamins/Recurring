<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateGsbRequest;
use App\Http\Requests\UpdateGsbRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Datatables;
use Auth;
use Redirect;

class ManageGsbController extends Controller
{
    // function ตารางข้อมูลธนาคารออมสิน
    public function index()
    {
        $banks = DB::table('bank')
            ->leftjoin('users as create','create.id','=','bank.create_user')
            ->leftjoin('users as update','update.id','=','bank.update_user')
            ->select('bank.id','bank.bank_code',
                'bank.bank_name',
                'bank.branch_code',
                'bank.branch_name',
                'bank.useflag',
                'update.name as update_name',
                'update.lastname as update_lastname')
            ->get();
        return view('admin.management.bank.index',compact('banks'));
    }
    // function ฟอร์มสร้างข้อมูลธนาคารออมสิน
    public function create()
    {
        return view('admin.management.bank.create');
    }
    // function บันทึกข้อมูลธนาคารออมสิน
    public function store(CreateGsbRequest $request)
    {
        if(Auth::check() != true){
            return view('welcome');
        }else{
            switch (Auth::user()->role) {
                case 'admin':
                    $insert_gsb = DB::table('bank')
                        ->insert([
                            'bank_code'		    =>	$request->bank_code,
                            'bank_name'	        =>	$request->bank_name,
                            'branch_code'       =>	$request->branch_code,
                            'branch_name'       =>	$request->branch_name,
                            'useflag'			=>	'Y',
                            'create_user'		=>	Auth::user()->id,
                            'create_date'		=>	Carbon::now(),
                            'update_user'		=>	Auth::user()->id,
                            'update_date'		=>	Carbon::now(),
                            'log'		        =>	'insert by admin',
                        ]);
                    if(!$insert_gsb){
                        return Redirect::back()->withInput($request->all());
                    }
                        return redirect()->route('bank.index')->with('success', 'บันทึกข้อมูลสำเร็จ');
                    break;
                
                default:
                        return Redirect::back()->withInput($request->all())->withErrors(array('errors' => 'ไม่สามารถบันข้อมูลธนาคารออมสินได้ กรุณาติดต่อ Administrator'));
                    break;
            }
        }
    }
    // function ดูรายละเอียดข้อมูลธนาคารออมสิน
    public function show($id)
    {
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของข้อมูลธนาคารออมสิน ที่ encryptString
        $banks = DB::table('bank')
            ->leftjoin('users as create','create.id','=','bank.create_user')
            ->leftjoin('users as update','update.id','=','bank.update_user')
            ->select('bank.id','bank.bank_code','bank.bank_name',
                'bank.branch_code',
                'bank.branch_name',
                'bank.useflag',
                'bank.create_date',
                'bank.create_user',
                'create.name as create_name',
                'create.lastname as create_lastname',
                'bank.update_date',
                'bank.update_user',
                'update.name as update_name',
                'update.lastname as update_lastname')
            ->where('bank.id',$decrypted_id)
            ->get();

        foreach($banks as $bank){
            $create_date = $bank->create_date; // Ex. "2018-03-23 11:36:32"
            $update_date = $bank->update_date; // Ex. "2018-03-23 11:36:32"
        }
        // แปลงค่าวันที่ Create ข้อมูลธนาคารออมสิน
        switch(substr($create_date, 5, 2)){
            case '01': $create_date_th = substr($create_date, 8, 2)." มกราคม ".(substr($create_date, 0, 4) + 543)." เวลา ".substr($create_date, 11); break;
            case '02': $create_date_th = substr($create_date, 8, 2)." กุมภาพันธ์ ".(substr($create_date, 0, 4) + 543)." เวลา ".substr($create_date, 11); break;
            case '03': $create_date_th = substr($create_date, 8, 2)." มีนาคม ".(substr($create_date, 0, 4) + 543)." เวลา ".substr($create_date, 11); break;
            case '04': $create_date_th = substr($create_date, 8, 2)." เมษายน ".(substr($create_date, 0, 4) + 543)." เวลา ".substr($create_date, 11); break;
            case '05': $create_date_th = substr($create_date, 8, 2)." พฤษภาคม ".(substr($create_date, 0, 4) + 543)." เวลา ".substr($create_date, 11); break;
            case '06': $create_date_th = substr($create_date, 8, 2)." มิถุนายน ".(substr($create_date, 0, 4) + 543)." เวลา ".substr($create_date, 11); break;
            case '07': $create_date_th = substr($create_date, 8, 2)." กรกฎาคม ".(substr($create_date, 0, 4) + 543)." เวลา ".substr($create_date, 11); break;
            case '08': $create_date_th = substr($create_date, 8, 2)." สิงหาคม ".(substr($create_date, 0, 4) + 543)." เวลา ".substr($create_date, 11); break;
            case '09': $create_date_th = substr($create_date, 8, 2)." กันยายน ".(substr($create_date, 0, 4) + 543)." เวลา ".substr($create_date, 11); break;
            case '10': $create_date_th = substr($create_date, 8, 2)." ตุลาคม ".(substr($create_date, 0, 4) + 543)." เวลา ".substr($create_date, 11); break;
            case '11': $create_date_th = substr($create_date, 8, 2)." พฤศจิกายน ".(substr($create_date, 0, 4) + 543)." เวลา ".substr($create_date, 11); break;
            case '12': $create_date_th = substr($create_date, 8, 2)." ธันวาคม ".(substr($create_date, 0, 4) + 543)." เวลา ".substr($create_date, 11); break;
            default: $create_date_th = 'Unknown';
        }
        // แปลงค่าวันที่ Update ข้อมูลธนาคารออมสิน
        switch(substr($update_date, 5, 2)){
            case '01': $update_date_th = substr($update_date, 8, 2)." มกราคม ".(substr($update_date, 0, 4) + 543)." เวลา ".substr($update_date, 11); break;
            case '02': $update_date_th = substr($update_date, 8, 2)." กุมภาพันธ์ ".(substr($update_date, 0, 4) + 543)." เวลา ".substr($update_date, 11); break;
            case '03': $update_date_th = substr($update_date, 8, 2)." มีนาคม ".(substr($update_date, 0, 4) + 543)." เวลา ".substr($update_date, 11); break;
            case '04': $update_date_th = substr($update_date, 8, 2)." เมษายน ".(substr($update_date, 0, 4) + 543)." เวลา ".substr($update_date, 11); break;
            case '05': $update_date_th = substr($update_date, 8, 2)." พฤษภาคม ".(substr($update_date, 0, 4) + 543)." เวลา ".substr($update_date, 11); break;
            case '06': $update_date_th = substr($update_date, 8, 2)." มิถุนายน ".(substr($update_date, 0, 4) + 543)." เวลา ".substr($update_date, 11); break;
            case '07': $update_date_th = substr($update_date, 8, 2)." กรกฎาคม ".(substr($update_date, 0, 4) + 543)." เวลา ".substr($update_date, 11); break;
            case '08': $update_date_th = substr($update_date, 8, 2)." สิงหาคม ".(substr($update_date, 0, 4) + 543)." เวลา ".substr($update_date, 11); break;
            case '09': $update_date_th = substr($update_date, 8, 2)." กันยายน ".(substr($update_date, 0, 4) + 543)." เวลา ".substr($update_date, 11); break;
            case '10': $update_date_th = substr($update_date, 8, 2)." ตุลาคม ".(substr($update_date, 0, 4) + 543)." เวลา ".substr($update_date, 11); break;
            case '11': $update_date_th = substr($update_date, 8, 2)." พฤศจิกายน ".(substr($update_date, 0, 4) + 543)." เวลา ".substr($update_date, 11); break;
            case '12': $update_date_th = substr($update_date, 8, 2)." ธันวาคม ".(substr($update_date, 0, 4) + 543)." เวลา ".substr($update_date, 11); break;
            default: $update_date_th = 'Unknown';
        }

        return view('admin.management.bank.show',compact('banks'),['create_date' => $create_date_th, 'update_date' => $update_date_th]);
    }
    // function เรียกฟอร์มแก้ไขข้อมูลธนาคารออมสิน
    public function edit($id)
    {
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของข้อมูลธนาคารออมสิน ที่ encryptString
        $bank = DB::table('bank')->find($decrypted_id);
        return view('admin.management.bank.edit',compact('bank'));
    }
    // function อัพเดทข้อมูลธนาคารออมสิน
    public function update(UpdateGsbRequest $request,$id)
    {
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของข้อมูลธนาคารออมสิน ที่ encryptString
        if(Auth::check() != true){
            return view('welcome');
        }else{
            switch (Auth::user()->role) {
                case 'admin':
                    $check_status_edc = DB::table('edc')->where('bank_id',$decrypted_id)->where('useflag','Y')->count(); // check useflag ของ table edc
                    
                    if($check_status_edc == 0 || $request->useflag =='Y'){ 
                        // นับสถานะของเครื่อง edc ไม่พบ useflag ที่เป็น Y จะมีค่าเท่ากับ 0 
                        // หรือส่งสถานะ useflag ของธนาคารออมสินเป็น Y ให้ทำการ Update ข้อมูลได้
                        $update_edc = DB::table('bank')
                            ->where('id',$decrypted_id)
                            ->update([
                                'bank_code'	        =>	$request->bank_code,
                                'bank_name'	        =>	$request->bank_name,
                                'branch_code'       =>	$request->branch_code,
                                'branch_name'       =>	$request->branch_name,
                                'useflag'			=>	$request->useflag,
                                'update_user'		=>	Auth::user()->id,
                                'update_date'		=>	Carbon::now(),
                                'log'		        =>	'update by admin',
                            ]);

                        if(!$update_edc){
                            return Redirect::back()->withInput($request->all());
                        }
                        return redirect()->route('bank.show',$id)->with('success', 'บันทึกข้อมูลสำเร็จ');
                    }else{
                        // นับสถานะของเครื่อง edc พบ useflag ที่เป็น Y มีค่ามากกว่าขึ้นไป 0 ไม่ให้ทำการ Update ข้อมูลได้
                        $status_edc_Y = DB::table('edc')->where('bank_id',$decrypted_id)->where('useflag','Y')->get();
                        foreach($status_edc_Y as $edc_y){
                            $array_edc[] = "หมายเลขเครื่อง : ".$edc_y->edc_no." --> ".$edc_y->edc_name; 
                        }
                        return Redirect::back()->withInput($request->all())->withErrors(array('errors' => 'ไม่สามารถบันข้อมูลธนาคารออมสินได้ เนื่องจาก "พบข้อมูลหมายเลขเครื่อง EDC ต่อไปนี้ อยู่ในสถานะ Activated" ','list_edc' => $array_edc));
                    }
                    break;
                
                default:
                        return Redirect::back()->withInput()->withErrors(array('errors' => 'ไม่สามารถบันข้อมูลธนาคารออมสินได้ กรุณาติดต่อ Administrator'));
                    break;
            }
        }
    }
}
