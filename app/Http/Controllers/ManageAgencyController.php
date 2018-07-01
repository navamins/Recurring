<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateAgencyRequest;
use App\Http\Requests\UpdateAgencyRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Datatables;
use Auth;
use Redirect;

class ManageAgencyController extends Controller
{
    // function ตารางข้อมูลหน่วยงานพันธมิตร
    public function index()
    {
        $agencies = DB::table('agency')
            ->leftjoin('users as create','create.id','=','agency.create_user')
            ->leftjoin('users as update','update.id','=','agency.update_user')
            ->select('agency.id','agency.agency_code',
                'agency.agency_name',
                'agency.merchant_code',
                'agency.useflag',
                'update.name as update_name',
                'update.lastname as update_lastname')
            ->get();

            return view('admin.management.agency.index',compact('agencies'));
    }

    // function ฟอร์มสร้างข้อมูลหน่วยงานพันธมิตร
    public function create()
    {
        return view('admin.management.agency.create');
    }

    // function บันทึกข้อมูลหน่วยงานพันธมิตร
    public function store(CreateAgencyRequest $request)
    {
        if(Auth::check() != true){
            return view('welcome');
        }else{
            switch (Auth::user()->role) {
                case 'admin':
                    $insert_agency = DB::table('agency')
                        ->insert([
                            'agency_code'		=>	$request->agency_code,
                            'agency_name'	    =>	$request->agency_name,
                            'agency_detail'     =>	$request->agency_detail,
                            'merchant_code'     =>	$request->merchant_code,
                            'useflag'			=>	'Y',
                            'create_user'		=>	Auth::user()->id,
                            'create_date'		=>	Carbon::now(),
                            'update_user'		=>	Auth::user()->id,
                            'update_date'		=>	Carbon::now(),
                            'log'		        =>	'insert by admin',
                        ]);
                    if(!$insert_agency){
                        return Redirect::back()->withInput($request->all());
                    }
                        return redirect()->route('agency.index')->with('success', 'บันทึกข้อมูลสำเร็จ');
                    break;
                
                default:
                        return Redirect::back()->withInput($request->all())->withErrors(array('errors' => 'ไม่สามารถบันข้อมูลหน่วยงานพันธมิตรได้ กรุณาติดต่อ Administrator'));
                    break;
            }
        }
    }

    // function ดูรายละเอียดข้อมูลหน่วยงานพันธมิตร
    public function show($id)
    {
         $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของ agency ที่ encryptString
         $agencies = DB::table('agency')
            ->leftjoin('users as create','create.id','=','agency.create_user')
            ->leftjoin('users as update','update.id','=','agency.update_user')
            ->select('agency.id','agency.agency_code',
                'agency.agency_name',
                'agency.agency_detail',
                'agency.merchant_code',
                'agency.useflag',
                'agency.create_date',
                'agency.create_user',
                'create.name as create_name',
                'create.lastname as create_lastname',
                'agency.update_date',
                'agency.update_user',
                'update.name as update_name',
                'update.lastname as update_lastname')
            ->where('agency.id',$decrypted_id)
            ->get();

         foreach($agencies as $agency){
             $create_date = $agency->create_date; // Ex. "2018-03-23 11:36:32"
             $update_date = $agency->update_date; // Ex. "2018-03-23 11:36:32"
        }
        // แปลงค่าวันที่ Create Agency
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
        // แปลงค่าวันที่ Update Agency
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

        return view('admin.management.agency.show',compact('agencies'),['create_date' => $create_date_th, 'update_date' => $update_date_th]);
    }

    // function เรียกฟอร์มแก้ไขข้อมูลหน่วยงานพันธมิตร
    public function edit($id)
    {
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของ agency ที่ encryptString
        $agency = DB::table('agency')->find($decrypted_id);
        return view('admin.management.agency.edit',compact('agency'));
    }
    // function อัพเดทข้อมูลหน่วยงานพันธมิตร
    public function update(UpdateAgencyRequest $request,$id)
    {
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของ agency ที่ encryptString
        if(Auth::check() != true){
            return view('welcome');
        }else{
            switch (Auth::user()->role) {
                case 'admin':
                    $update_agency = DB::table('agency')
                        ->where('id',$decrypted_id)
                        ->update([
                            'agency_code'	    =>	$request->agency_code,
                            'agency_name'	    =>	$request->agency_name,
                            'agency_detail'     =>	$request->agency_detail,
                            'merchant_code'		=>	$request->merchant_code,
                            'useflag'			=>	$request->useflag,
                            'update_user'		=>	Auth::user()->id,
                            'update_date'		=>	Carbon::now(),
                            'log'		        =>	'update by admin',
                        ]);
                        if(!$update_agency){
                            return Redirect::back()->withInput($request->all());
                        }

                        return redirect()->route('agency.show',$id)->with('success', 'บันทึกข้อมูลสำเร็จ');
                    break;
                
                default:
                        return Redirect::back()->withInput()->withErrors(array('errors' => 'ไม่สามารถบันข้อมูลหน่วยงานพันธมิตรได้ กรุณาติดต่อ Administrator'));
                    break;
            }
        }
    }
}
