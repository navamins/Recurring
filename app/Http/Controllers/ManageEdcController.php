<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateEdcRequest;
use App\Http\Requests\UpdateEdcRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Datatables;
use Auth;
use Redirect;

class ManageEdcController extends Controller
{
    // function ตารางข้อมูลเครื่อง EDC
    public function index()
    {
        $edc = DB::table('edc')
            ->leftjoin('users as create','create.id','=','edc.create_user')
            ->leftjoin('users as update','update.id','=','edc.update_user')
            ->select('edc.id','edc.edc_no','edc.edc_name','edc.useflag',
                'update.name as update_name',
                'update.lastname as update_lastname')
            ->get();
           
        return view('admin.management.bank.edc.index',compact('edc'));
    }
    // function ฟอร์มสร้างข้อมูลเครื่อง EDC
    public function create()
    {
        $banks = DB::table('bank')->where('useflag','Y')->get();
        return view('admin.management.bank.edc.create',compact('banks'));
    }
    // function บันทึกข้อมูลเครื่อง EDC
    public function store(CreateEdcRequest $request)
    {
        if(Auth::check() != true){
            return view('welcome');
        }else{
            switch (Auth::user()->role) {
                case 'admin':
                    $insert_edc = DB::table('edc')
                        ->insert([
                            'edc_no'		    =>	$request->edc_no,
                            'edc_name'	        =>	$request->edc_name,
                            'bank_id'           =>	$request->bank_id,
                            'useflag'			=>	'Y',
                            'create_user'		=>	Auth::user()->id,
                            'create_date'		=>	Carbon::now(),
                            'update_user'		=>	Auth::user()->id,
                            'update_date'		=>	Carbon::now(),
                            'log'		        =>	'insert by admin',
                        ]);
                    if(!$insert_edc){
                        return Redirect::back()->withInput($request->all());
                    }
                        return redirect()->route('edc.index')->with('success', 'บันทึกข้อมูลสำเร็จ');
                    break;
                
                default:
                        return Redirect::back()->withInput($request->all())->withErrors(array('errors' => 'ไม่สามารถบันข้อมูลเครื่อง EDC ได้ กรุณาติดต่อ Administrator'));
                    break;
            }
        }
    }
    // function ดูรายละเอียดข้อมูลเครื่อง EDC
    public function show($id)
    {
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของ edc ที่ encryptString
        $edc = DB::table('edc')
            ->leftjoin('bank','bank.id','=','edc.bank_id')
            ->leftjoin('users as create','create.id','=','edc.create_user')
            ->leftjoin('users as update','update.id','=','edc.update_user')
            ->select('edc.id','edc.edc_no','edc.edc_name',
                'bank.bank_code',
                'bank.bank_name',
                'edc.useflag',
                'edc.create_date',
                'edc.create_user',
                'create.name as create_name',
                'create.lastname as create_lastname',
                'edc.update_date',
                'edc.update_user',
                'update.name as update_name',
                'update.lastname as update_lastname')
            ->where('edc.id',$decrypted_id)
            ->get();

        foreach($edc as $terminal){
            $create_date = $terminal->create_date; // Ex. "2018-03-23 11:36:32"
            $update_date = $terminal->update_date; // Ex. "2018-03-23 11:36:32"
        }
        // แปลงค่าวันที่ Create EDC
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
        // แปลงค่าวันที่ Update EDC
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
        return view('admin.management.bank.edc.show',compact('edc'),['create_date' => $create_date_th, 'update_date' => $update_date_th]);
    }
    // function เรียกฟอร์มแก้ไขข้อมูลเครื่อง EDC
    public function edit($id)
    {
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของ edc ที่ encryptString
        $edc = DB::table('edc')->find($decrypted_id);
        $banks = DB::table('bank')->where('useflag','Y')->get();
        return view('admin.management.bank.edc.edit',compact('edc','banks'));
    }
    // function อัพเดทข้อมูลเครื่อง EDC
    public function update(UpdateEdcRequest $request,$id)
    {
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของ edc ที่ encryptString
        if(Auth::check() != true){
            return view('welcome');
        }else{
            switch (Auth::user()->role) {
                case 'admin':
                    $check_status_bank = DB::table('bank')->where('id',$request->bank_id)->where('useflag','Y')->count(); // check useflag ของ table bank

                    if($check_status_bank !=0 ){
                        $update_edc = DB::table('edc')
                            ->where('id',$decrypted_id)
                            ->update([
                                'edc_no'	        =>	$request->edc_no,
                                'edc_name'	        =>	$request->edc_name,
                                'bank_id'           =>	$request->bank_id,
                                'useflag'			=>	$request->useflag,
                                'update_user'		=>	Auth::user()->id,
                                'update_date'		=>	Carbon::now(),
                                'log'		        =>	'update by admin',
                            ]);

                        if(!$update_edc){
                            return Redirect::back()->withInput($request->all());
                        }
                        return redirect()->route('edc.show',$id)->with('success', 'บันทึกข้อมูลสำเร็จ');
                    }else{
                        return Redirect::back()->withInput($request->all())->withErrors(array('errors' => 'ไม่สามารถบันข้อมูลเครื่อง EDC ได้ เนื่องจาก "หมายเลขธนาคาร /ชื่อธนาคาร" อยู่ในสถานะ Not Activated'));
                    }
                    break;
                
                default:
                        return Redirect::back()->withInput()->withErrors(array('errors' => 'ไม่สามารถบันข้อมูลเครื่อง EDC ได้ กรุณาติดต่อ Administrator'));
                    break;
            }
        }
    }
}
