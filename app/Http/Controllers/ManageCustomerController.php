<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImportCardlinkRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Response;
use Datatables;
use Auth;
use Redirect;
use App\User;
use View;
use File;

class ManageCustomerController extends Controller
{
    // function ตารางข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค
    public function index($sort,Request $request)
    {
        $decrypted_agency_id = Crypt::decryptString($request->agency_id); // decryptString ค่า agency_id ที่ encryptString
        $decrypted_status_register = Crypt::decryptString($request->status_register); // decryptString ค่า status_register ที่ encryptString

        $agencies = DB::table('agency')
            ->leftjoin('recurring_type','recurring_type.id','=','agency.recurring_type_id')
            ->where('agency.id',$decrypted_agency_id)
            ->where('agency.useflag','Y')
            ->select('agency.id','agency.agency_code','agency.agency_name','recurring_type.name_type')
            ->get();

        switch($sort){
            case 'all' : $customers = DB::table('recurring_transaction')        
                ->leftjoin('customer','customer.id','=','recurring_transaction.customer_id')
                ->leftjoin('agency','agency.id','=','recurring_transaction.agency_id')
                ->leftjoin('name_title','name_title.id','=','customer.name_title_id')
                // ->where('recurring_transaction.status_register',$decrypted_status_register)
                // ->where('recurring_transaction.agency_id',$decrypted_agency_id)
                ->where('recurring_transaction.useflag','Y')
                ->select('recurring_transaction.id',            // id การทำรายการของลูกค้า
                    'customer.id_card',                         // เลขบัตรประชาชนลูกค้า        
                    'name_title.name_title',                    // คำนำหน้าชื่อลูกค้า  
                    'customer.name',                            // ชื่อลูกค้า 
                    'customer.lastname',                        // นามสกุลชื่อลูกค้า 
                    'recurring_transaction.status_action',      // สถานะการทำรายการของลูกค้า 
                    'recurring_transaction.status_agency',      // สถานะผลการลงทะเบียนของลูกค้า จาก Agency 
                    'recurring_transaction.status_register'     // สถานะการติดตามทำรายการของลูกค้า จากระบบ Recurring 
                )
                ->get();
                break;
            
            default : $customers = DB::table('recurring_transaction')       
                ->leftjoin('customer','customer.id','=','recurring_transaction.customer_id')
                ->leftjoin('agency','agency.id','=','recurring_transaction.agency_id')
                ->leftjoin('name_title','name_title.id','=','customer.name_title_id')
                ->where('recurring_transaction.status_register',$decrypted_status_register)
                ->where('recurring_transaction.agency_id',$decrypted_agency_id)
                ->where('recurring_transaction.useflag','Y')
                ->select('recurring_transaction.id',            // id การทำรายการของลูกค้า
                    'customer.id_card',                         // เลขบัตรประชาชนลูกค้า        
                    'name_title.name_title',                    // คำนำหน้าชื่อลูกค้า  
                    'customer.name',                            // ชื่อลูกค้า 
                    'customer.lastname',                        // นามสกุลชื่อลูกค้า
                    'recurring_transaction.card_number',        // หมายเลขบัตรเครดิต
                    'recurring_transaction.meter_number',       // หมายเลข meter
                    'recurring_transaction.status_action',      // สถานะการทำรายการของลูกค้า 
                    'recurring_transaction.status_agency',      // สถานะผลการลงทะเบียนของลูกค้า จาก Agency 
                    'recurring_transaction.status_register'     // สถานะการติดตามทำรายการของลูกค้า จากระบบ Recurring 
                )
                ->get();
        }
        
        if($customers->isEmpty()){
            $status = $decrypted_status_register;
        }else{
            foreach($customers as $customer){
                $status = $customer->status_register;
            }
        }
        // dd(['function ตารางข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค',$request,$decrypted_agency_id,$decrypted_status_register,$customers,$status,$agencies]);
        
        return view('admin.management.customer.index',compact('customers','agencies'),['status' => $status]);
    }

    // function ปรับสถานะระบบของข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค
    public function update_status($sort,Request $request)
    {
        // dd(['ปรับสถานะระบบของข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค',$sort,$request]);

        if(Auth::check() != true){
            return view('welcome');
        }else{
            switch (Auth::user()->role) {
                case 'admin':
                        switch($request->status){
                            case 'Check':
                                
                                $query_pendings = DB::table('recurring_transaction')
                                    ->leftjoin('customer','customer.id','=','recurring_transaction.customer_id')
                                    ->where('recurring_transaction.status_register','Check')
                                    ->where('customer.useflag','Y')
                                    ->where('recurring_transaction.useflag','Y')
                                    ->select('recurring_transaction.id','customer.id_card','recurring_transaction.card_number')
                                    ->get();

                                $fileName = 'register_'.Carbon::now()->format('Ymd').'.txt'; // register_Ymd.txt 
                                $objFopen = fopen(public_path('/export/check_cardlink/'.$fileName), 'w'); // Example: register_20180621.txt
                                $objFopen_log = fopen(public_path('/export/check_cardlink_log/'.Auth::user()->emp_code.$fileName), 'w'); // Example: 6007014register_20180621.txt
                                $total = 0;
                                $total_log = 0;
                                fwrite($objFopen, 'H|'.Carbon::now()->format('Ymd')."\r\n"); // แปะ Header
                                fwrite($objFopen_log, 'H|'.Carbon::now()->format('Ymd')."\r\n"); // แปะ Header ที่  export log
                                
                                foreach($query_pendings as $key => $query_pending){
                                    fwrite($objFopen, 
                                        'D|'.str_pad($query_pending->id,6,'0',STR_PAD_LEFT)."|".$query_pending->id_card."|".str_pad(Crypt::decryptString($query_pending->card_number),19,'0',STR_PAD_LEFT)."\r\n"
                                    ); // data
                                    fwrite($objFopen_log, 
                                        'D|'.str_pad($query_pending->id,6,'0',STR_PAD_LEFT)."|".$query_pending->id_card."|".str_pad(Crypt::decryptString($query_pending->card_number),19,'0',STR_PAD_LEFT)."\r\n"
                                    ); // log
                                    $total = $key + 1;
                                    $total_log = $key + 1;
                                }
                                
                                fwrite($objFopen, 'T|'.str_pad($total,6,'0',STR_PAD_LEFT)."\r\n"); // แปะ Header
                                fwrite($objFopen_log, 'T|'.str_pad($total_log,6,'0',STR_PAD_LEFT)."\r\n"); // แปะ Header ที่  export log

                                fwrite($objFopen_log, 'โดย : '.Auth::user()->emp_code.'     '.Auth::user()->name.' '.Auth::user()->lastname."\r\n");
                                fwrite($objFopen_log, 'Email : '.Auth::user()->email."\r\n");
                                fwrite($objFopen_log, 'นำข้อมูลออกเมื่อวันที่ : '.Carbon::now()->format('d/m/y H:i'));
                                fclose($objFopen);
                                fclose($objFopen_log);
                                // return Redirect::back()->with('success', 'บันทึกข้อมูลสถานะสำเร็จ');
                                return Response::download(public_path('/export/check_cardlink/'.$fileName))->deleteFileAfterSend(true); // เปิด code บรรทัดนี้เพื่อ manual export 

                            break;

                            default :
                                return Redirect::back();
                            break;
                        }    
                break;
                
                default:
                    return Redirect::back()->withInput()->withErrors(array('errors' => 'ไม่สามารถบันข้อมูลข้อมูลสถานะของระบบได้ กรุณาติดต่อ Administrator'));
                break;
            }
        }
    }
    // function รายละเอียดข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค
    public function show($id,$agency,Request $request)
    {
        $decrypted_recurring_id = Crypt::decryptString($id); // decryptString ค่า id ข้อมูลรายการชำระค่าสาธารณูปโภคของลูกค้าที่ encryptString

        switch($id){
            case 'search': 
                dd('ฟอร์มค้นหาข้อมูลรายการชำระค่าสาธารณูปโภคของลูกค้า');
            break;

            default :
                $transactions = DB::table('recurring_transaction')
                    ->leftjoin('agency','agency.id','=','recurring_transaction.agency_id')
                    ->leftjoin('recurring_type','recurring_type.id','=','agency.recurring_type_id')
                    ->leftjoin('customer','customer.id','=','recurring_transaction.customer_id')
                    ->leftjoin('name_title','name_title.id','=','customer.name_title_id')
                    ->leftjoin('users as create','create.id','=','recurring_transaction.create_user')
                    ->leftjoin('users as update','update.id','=','recurring_transaction.update_user')
                    ->select(
                        'recurring_transaction.id as recurring_transaction_id',
                        'recurring_transaction.apply_date',
                        'recurring_transaction.card_number',
                        'recurring_transaction.contact_account',
                        'recurring_transaction.meter_number',
                        'recurring_transaction.status_action',
                        'recurring_transaction.status_agency',
                        'recurring_transaction.status_register',
                        'recurring_transaction.address1',
                        'recurring_transaction.address2',
                        'recurring_transaction.address3',
                        'recurring_transaction.provinces',
                        'recurring_transaction.zipcode',
                        'recurring_transaction.telephone',
                        'recurring_transaction.customer_id',
                        'recurring_type.name_type',
                        'agency.agency_name',
                        'name_title.name_title',
                        'customer.name',
                        'customer.lastname',
                        'customer.id_card',
                        'recurring_transaction.create_date',
                        'recurring_transaction.create_user',
                        'create.name as create_name',
                        'create.lastname as create_lastname',
                        'recurring_transaction.update_date',
                        'recurring_transaction.update_user',
                        'update.name as update_name',
                        'update.lastname as update_lastname'
                        )
                    ->where('recurring_transaction.id',$decrypted_recurring_id)
                    ->where('recurring_transaction.agency_id',$agency)
                    ->get();

                foreach($transactions as $transaction){
                    $apply_date = $transaction->apply_date;
                    $create_date = $transaction->create_date; // Ex. "2018-03-23 11:36:32"
                    $update_date = $transaction->update_date; // Ex. "2018-03-23 11:36:32"
                }
                // แปลงค่าวันที่สมัครใช้บริการทำรายการชำระค่าสาธารณูปโภค
                switch(substr($apply_date, 5, 2)){
                    case '01': $apply_date_th = substr($apply_date, 8, 2)." มกราคม ".(substr($apply_date, 0, 4) + 543); break;
                    case '02': $apply_date_th = substr($apply_date, 8, 2)." กุมภาพันธ์ ".(substr($apply_date, 0, 4) + 543); break;
                    case '03': $apply_date_th = substr($apply_date, 8, 2)." มีนาคม ".(substr($apply_date, 0, 4) + 543); break;
                    case '04': $apply_date_th = substr($apply_date, 8, 2)." เมษายน ".(substr($apply_date, 0, 4) + 543); break;
                    case '05': $apply_date_th = substr($apply_date, 8, 2)." พฤษภาคม ".(substr($apply_date, 0, 4) + 543); break;
                    case '06': $apply_date_th = substr($apply_date, 8, 2)." มิถุนายน ".(substr($apply_date, 0, 4) + 543); break;
                    case '07': $apply_date_th = substr($apply_date, 8, 2)." กรกฎาคม ".(substr($apply_date, 0, 4) + 543); break;
                    case '08': $apply_date_th = substr($apply_date, 8, 2)." สิงหาคม ".(substr($apply_date, 0, 4) + 543); break;
                    case '09': $apply_date_th = substr($apply_date, 8, 2)." กันยายน ".(substr($apply_date, 0, 4) + 543); break;
                    case '10': $apply_date_th = substr($apply_date, 8, 2)." ตุลาคม ".(substr($apply_date, 0, 4) + 543); break;
                    case '11': $apply_date_th = substr($apply_date, 8, 2)." พฤศจิกายน ".(substr($apply_date, 0, 4) + 543); break;
                    case '12': $apply_date_th = substr($apply_date, 8, 2)." ธันวาคม ".(substr($apply_date, 0, 4) + 543); break;
                    default: $apply_date_th = 'Unknown';
                }
                // แปลงค่าวันที่ Create ข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค
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
                // แปลงค่าวันที่ Update ข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค
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
                // dd([$transactions,$decrypted_recurring_id,$agency,$create_date_th,$update_date_th,$apply_date_th]);
                return view('admin.management.customer.show',compact('transactions'),['create_date' => $create_date_th, 'update_date' => $update_date_th, 'apply_date_th' => $apply_date_th]);
            break;
        }
    }

    // function ฟอร์มแก้ไขข้อมูลผู้ลงทะเบียนชำระค่าสาธารณูปโภค
    public function form_edit_customer($id)
    {
        $decrypted_customer_id = Crypt::decryptString($id); // decryptString ค่า id ข้อมูลผู้ลงทะเบียนชำระค่าสาธารณูปโภคที่ encryptString

        $customers = DB::table('customer')->find($decrypted_customer_id);
        $name_title = DB::table('name_title')->where('useflag','Y')->get();
        $get_provinces = DB::table('provinces')->get();

        // dd(['ฟอร์มแก้ไขข้อมูลผู้ลงทะเบียนชำระค่าสาธารณูปโภค',$id,$decrypted_customer_id,$customers,$name_title,$get_provinces]);
        return view('user.register.edit_customer',compact('customers','name_title','get_provinces'));
    }

    // function ฟอร์มอัพเดทข้อมูลผู้ลงทะเบียนชำระค่าสาธารณูปโภคจากระบบ Cardlink แบบ Manual
    public function form_import_cardlink(Request $request)
    {
        return view('admin.management.customer.import_cardlink');
    }

    // function อัพเดทข้อมูลผู้ลงทะเบียนชำระค่าสาธารณูปโภคจากระบบ Cardlink แบบ Manual
    public function store_import_cardlink(ImportCardlinkRequest $request)
    {   
        if($request->hasFile('import_file')) {
            $file_name = $request->file('import_file');
            $path = "C:/xampp/htdocs/Recurring/public/import/manual_import_cardlink";
            $original_file_name = $file_name->getClientOriginalName(); // filename
            $extension = $file_name->getClientOriginalExtension(); // extension file

            $fileWithoutExt  = str_replace(".","",basename($original_file_name, $extension));  
            $updated_fileName = 'register_'.Carbon::now()->format('Ymd').".".$extension; 
            $uploaded = $file_name->move($path, $updated_fileName); // ย้าย file
            $objFopen  = fopen($path.'/'.$updated_fileName, 'rb') or die("Unable to open file!");

            $lines = [];
            while(!feof($objFopen)) {
                $lines[] = explode("|",trim(fgets($objFopen)));
            }
            fclose($objFopen);

            if($lines[0][0] == 'H' && $lines[0][1] == Carbon::now()->format('Ymd') && $lines[0][1] != 'T' && intval($lines[0][1]) != 0){
                foreach($lines as $key => $value){

                    if($value[0] == 'D' && $value[4] == 'Y'){
                        $update_status = DB::table('recurring_transaction')
                            ->leftjoin('customer','customer.id','=','recurring_transaction.customer_id')
                            ->where([
                                ['recurring_transaction.id','=',intval($value[1])],
                                ['customer.id_card','=',$value[2]],
                                ['recurring_transaction.status_register','=','Check'],
                                ['recurring_transaction.useflag','=','Y'],
                            ])
                            ->update([
                                'recurring_transaction.status_register' => 'Waiting for reply',
                                'recurring_transaction.address1'         =>  iconv( 'TIS-620', 'UTF-8', $value[6]),
                                'recurring_transaction.address2'       =>  iconv( 'TIS-620', 'UTF-8', $value[7]),
                                'recurring_transaction.address3'        =>  iconv( 'TIS-620', 'UTF-8', $value[8]),
                                'recurring_transaction.provinces'       =>  iconv( 'TIS-620', 'UTF-8', $value[9]),
                                'recurring_transaction.zipcode'         =>  iconv( 'TIS-620', 'UTF-8', $value[10]),
                                'recurring_transaction.telephone'       =>  $value[11],
                                'recurring_transaction.update_user'		=>	Auth::user()->id,
                                'recurring_transaction.update_date'		=>	Carbon::now(),
                                'recurring_transaction.log'		        =>	'update with import data from cardlink by '.Auth::user()->role,
                            ]);

                    }elseif($value[0] == 'D' && $value[4] == 'N'){
                        $update_status = DB::table('recurring_transaction')
                            ->leftjoin('customer','customer.id','=','recurring_transaction.customer_id')
                            ->where([
                                ['recurring_transaction.id','=',intval($value[1])],
                                ['customer.id_card','=',$value[2]],
                                ['recurring_transaction.status_register','=','Check'],
                                ['recurring_transaction.useflag','=','Y'],
                            ])
                            ->update([
                                'recurring_transaction.status_register' => 'Waiting for correct',
                                'recurring_transaction.issue'           =>  $value[5],
                                'recurring_transaction.update_user'		=>	Auth::user()->id,
                                'recurring_transaction.update_date'		=>	Carbon::now(),
                                'recurring_transaction.log'		        =>	'update with import data from cardlink by '.Auth::user()->role,
                            ]);

                    }
                }

                return redirect()->route('customer.form_import_cardlink')->with('success', 'บันทึกข้อมูลสถานะรายการชำระค่าสาธารณูปโภคสำเร็จ');

            }elseif($lines[0][0] == 'H' && $lines[0][1] == Carbon::now()->format('Ymd') && $lines[0][1] == 'T' && intval($lines[0][1]) == 0){

                return redirect()->route('customer.form_import_cardlink')->with('success', 'บันทึกข้อมูลสถานะรายการชำระค่าสาธารณูปโภคสำเร็จ');
                
            }elseif($lines[0][0] == 'H' && $lines[0][1] != Carbon::now()->format('Ymd')){

                return Redirect::back()->withInput()->withErrors(array('errors' => 'ไม่สามารถอัพเดทข้อมูลจาก Cardlink แบบ Manual ได้ กรุณาติดต่อ Developer'));
            }
        }
    }

    // function หน้าแรกฟอร์มค้นหาข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค
    public function search(Request $request)
    {
        $customers = array();
        return view('admin.management.customer.search',compact('customers'),['input_type'=> '','input_value'=> '']);
    }

    // function แสดงผลลัพธ์การค้นหาข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค
    public function list(Request $request)
    {
        if($request->search == 'search'){
            switch($request->search_type){
                case 'name_lastname': 
                    $customers = DB::table('customer')
                        ->leftjoin('name_title','name_title.id','=','customer.name_title_id')
                        ->where([
                            ['customer.name','like','%'.$request->search_value.'%'],
                            ['customer.useflag','Y']
                        ])
                        ->orWhere([
                            ['customer.lastname','like','%'.$request->search_value.'%'],
                            ['customer.useflag','Y']
                        ])
                        ->select('customer.id','name_title.name_title','customer.name','customer.lastname','customer.id_card','customer.useflag','customer.create_date','customer.update_date')
                        ->get();
                    break;

                case 'id_card':
                    $customers = DB::table('customer')
                        ->leftjoin('name_title','name_title.id','=','customer.name_title_id')
                        ->where([
                            ['customer.id_card','like','%'.$request->search_value.'%'],
                            ['customer.useflag','Y']
                        ])
                        ->select('customer.id','name_title.name_title','customer.name','customer.lastname','customer.id_card','customer.useflag','customer.create_date','customer.update_date')
                        ->get();
                    break;

                default : return view('user.register.not_responding');
            }
        }else{
            return view('user.register.not_responding');
        }

        return view('admin.management.customer.search',compact('customers'),['input_type'=> $request->search_type,'input_value'=> $request->search_value]);
    }

    // function รายละเอียดข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภคทั้งหมด
    public function search_show($id)
    {
        $decrypted_customer_id = Crypt::decryptString($id); // decryptString ค่า id ข้อมูลผู้ลงทะเบียนชำระค่าสาธารณูปโภคที่ encryptString
        
        $customers = DB::table('customer')
            ->leftjoin('name_title','name_title.id','=','customer.name_title_id')
            ->leftjoin('users as create','create.id','=','customer.create_user')
            ->leftjoin('users as update','update.id','=','customer.update_user')
            ->where('customer.id',$decrypted_customer_id)
            ->select('name_title.name_title',
            'customer.name',
            'customer.lastname',
            'customer.id_card',
            'customer.create_date',
            'customer.create_user',
            'create.name as create_name',
            'create.lastname as create_lastname',
            'customer.update_date',
            'customer.update_user',
            'update.name as update_name',
            'update.lastname as update_lastname'
            )
            ->get();

        foreach($customers as $customer){
            $customers_create_date = $customer->create_date; // Ex. "2018-03-23 11:36:32"
            $customers_update_date = $customer->update_date; // Ex. "2018-03-23 11:36:32"
        }
        // แปลงค่าวันที่ Create ข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค
        switch(substr($customers_create_date, 5, 2)){
            case '01': $customer_create_date_th = substr($customers_create_date, 8, 2)." มกราคม ".(substr($customers_create_date, 0, 4) + 543)." เวลา ".substr($customers_create_date, 11); break;
            case '02': $customer_create_date_th = substr($customers_create_date, 8, 2)." กุมภาพันธ์ ".(substr($customers_create_date, 0, 4) + 543)." เวลา ".substr($customers_create_date, 11); break;
            case '03': $customer_create_date_th = substr($customers_create_date, 8, 2)." มีนาคม ".(substr($customers_create_date, 0, 4) + 543)." เวลา ".substr($customers_create_date, 11); break;
            case '04': $customer_create_date_th = substr($customers_create_date, 8, 2)." เมษายน ".(substr($customers_create_date, 0, 4) + 543)." เวลา ".substr($customers_create_date, 11); break;
            case '05': $customer_create_date_th = substr($customers_create_date, 8, 2)." พฤษภาคม ".(substr($customers_create_date, 0, 4) + 543)." เวลา ".substr($customers_create_date, 11); break;
            case '06': $customer_create_date_th = substr($customers_create_date, 8, 2)." มิถุนายน ".(substr($customers_create_date, 0, 4) + 543)." เวลา ".substr($customers_create_date, 11); break;
            case '07': $customer_create_date_th = substr($customers_create_date, 8, 2)." กรกฎาคม ".(substr($customers_create_date, 0, 4) + 543)." เวลา ".substr($customers_create_date, 11); break;
            case '08': $customer_create_date_th = substr($customers_create_date, 8, 2)." สิงหาคม ".(substr($customers_create_date, 0, 4) + 543)." เวลา ".substr($customers_create_date, 11); break;
            case '09': $customer_create_date_th = substr($customers_create_date, 8, 2)." กันยายน ".(substr($customers_create_date, 0, 4) + 543)." เวลา ".substr($customers_create_date, 11); break;
            case '10': $customer_create_date_th = substr($customers_create_date, 8, 2)." ตุลาคม ".(substr($customers_create_date, 0, 4) + 543)." เวลา ".substr($customers_create_date, 11); break;
            case '11': $customer_create_date_th = substr($customers_create_date, 8, 2)." พฤศจิกายน ".(substr($customers_create_date, 0, 4) + 543)." เวลา ".substr($customers_create_date, 11); break;
            case '12': $customer_create_date_th = substr($customers_create_date, 8, 2)." ธันวาคม ".(substr($customers_create_date, 0, 4) + 543)." เวลา ".substr($customers_create_date, 11); break;
            default: $customer_create_date_th = 'Unknown';
        }
        // แปลงค่าวันที่ Update ข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค
        switch(substr($customers_update_date, 5, 2)){
            case '01': $customer_update_date_th = substr($customers_update_date, 8, 2)." มกราคม ".(substr($customers_update_date, 0, 4) + 543)." เวลา ".substr($customers_update_date, 11); break;
            case '02': $customer_update_date_th = substr($customers_update_date, 8, 2)." กุมภาพันธ์ ".(substr($customers_update_date, 0, 4) + 543)." เวลา ".substr($customers_update_date, 11); break;
            case '03': $customer_update_date_th = substr($customers_update_date, 8, 2)." มีนาคม ".(substr($customers_update_date, 0, 4) + 543)." เวลา ".substr($customers_update_date, 11); break;
            case '04': $customer_update_date_th = substr($customers_update_date, 8, 2)." เมษายน ".(substr($customers_update_date, 0, 4) + 543)." เวลา ".substr($customers_update_date, 11); break;
            case '05': $customer_update_date_th = substr($customers_update_date, 8, 2)." พฤษภาคม ".(substr($customers_update_date, 0, 4) + 543)." เวลา ".substr($customers_update_date, 11); break;
            case '06': $customer_update_date_th = substr($customers_update_date, 8, 2)." มิถุนายน ".(substr($customers_update_date, 0, 4) + 543)." เวลา ".substr($customers_update_date, 11); break;
            case '07': $customer_update_date_th = substr($customers_update_date, 8, 2)." กรกฎาคม ".(substr($customers_update_date, 0, 4) + 543)." เวลา ".substr($customers_update_date, 11); break;
            case '08': $customer_update_date_th = substr($customers_update_date, 8, 2)." สิงหาคม ".(substr($customers_update_date, 0, 4) + 543)." เวลา ".substr($customers_update_date, 11); break;
            case '09': $customer_update_date_th = substr($customers_update_date, 8, 2)." กันยายน ".(substr($customers_update_date, 0, 4) + 543)." เวลา ".substr($customers_update_date, 11); break;
            case '10': $customer_update_date_th = substr($customers_update_date, 8, 2)." ตุลาคม ".(substr($customers_update_date, 0, 4) + 543)." เวลา ".substr($customers_update_date, 11); break;
            case '11': $customer_update_date_th = substr($customers_update_date, 8, 2)." พฤศจิกายน ".(substr($customers_update_date, 0, 4) + 543)." เวลา ".substr($customers_update_date, 11); break;
            case '12': $customer_update_date_th = substr($customers_update_date, 8, 2)." ธันวาคม ".(substr($customers_update_date, 0, 4) + 543)." เวลา ".substr($customers_update_date, 11); break;
            default: $customer_update_date_th = 'Unknown';
        }
            


        $recurring_transaction = DB::table('recurring_transaction')
            ->leftjoin('agency','agency.id','=','recurring_transaction.agency_id')
            ->leftjoin('recurring_type','recurring_type.id','=','agency.recurring_type_id')
            ->leftjoin('users as create','create.id','=','recurring_transaction.create_user')
            ->leftjoin('users as update','update.id','=','recurring_transaction.update_user')
            ->where('recurring_transaction.customer_id',$decrypted_customer_id)
            ->where('recurring_transaction.useflag','Y')
            ->select(
                'recurring_transaction.id as recurring_transaction_id',
                'recurring_transaction.apply_date',
                'recurring_transaction.card_number',
                'recurring_transaction.contact_account',
                'recurring_transaction.meter_number',
                'recurring_transaction.status_action',
                'recurring_transaction.status_agency',
                'recurring_transaction.status_register',
                'recurring_transaction.address1',
                'recurring_transaction.address2',
                'recurring_transaction.address3',
                'recurring_transaction.provinces',
                'recurring_transaction.zipcode',
                'recurring_transaction.telephone',
                'recurring_transaction.customer_id',
                'recurring_type.id as recurring_type_id',
                'recurring_type.name_type',
                'recurring_transaction.agency_id',
                'agency.agency_name',
                'recurring_transaction.create_date',
                'recurring_transaction.create_user',
                'create.name as create_name',
                'create.lastname as create_lastname',
                'recurring_transaction.update_date',
                'recurring_transaction.update_user',
                'update.name as update_name',
                'update.lastname as update_lastname'
                )
            ->get();

        foreach($recurring_transaction as $transaction){
            $apply_date = $transaction->apply_date;
            $create_date = $transaction->create_date; // Ex. "2018-03-23 11:36:32"
            $update_date = $transaction->update_date; // Ex. "2018-03-23 11:36:32"
            $get_agencys = DB::table('agency')->where('recurring_type_id',$transaction->recurring_type_id)->where('useflag','Y')->get();
        }
        // แปลงค่าวันที่สมัครใช้บริการทำรายการชำระค่าสาธารณูปโภค
        switch(substr($apply_date, 5, 2)){
            case '01': $apply_date_th = substr($apply_date, 8, 2)." มกราคม ".(substr($apply_date, 0, 4) + 543); break;
            case '02': $apply_date_th = substr($apply_date, 8, 2)." กุมภาพันธ์ ".(substr($apply_date, 0, 4) + 543); break;
            case '03': $apply_date_th = substr($apply_date, 8, 2)." มีนาคม ".(substr($apply_date, 0, 4) + 543); break;
            case '04': $apply_date_th = substr($apply_date, 8, 2)." เมษายน ".(substr($apply_date, 0, 4) + 543); break;
            case '05': $apply_date_th = substr($apply_date, 8, 2)." พฤษภาคม ".(substr($apply_date, 0, 4) + 543); break;
            case '06': $apply_date_th = substr($apply_date, 8, 2)." มิถุนายน ".(substr($apply_date, 0, 4) + 543); break;
            case '07': $apply_date_th = substr($apply_date, 8, 2)." กรกฎาคม ".(substr($apply_date, 0, 4) + 543); break;
            case '08': $apply_date_th = substr($apply_date, 8, 2)." สิงหาคม ".(substr($apply_date, 0, 4) + 543); break;
            case '09': $apply_date_th = substr($apply_date, 8, 2)." กันยายน ".(substr($apply_date, 0, 4) + 543); break;
            case '10': $apply_date_th = substr($apply_date, 8, 2)." ตุลาคม ".(substr($apply_date, 0, 4) + 543); break;
            case '11': $apply_date_th = substr($apply_date, 8, 2)." พฤศจิกายน ".(substr($apply_date, 0, 4) + 543); break;
            case '12': $apply_date_th = substr($apply_date, 8, 2)." ธันวาคม ".(substr($apply_date, 0, 4) + 543); break;
            default: $apply_date_th = 'Unknown';
        }
        // แปลงค่าวันที่ Create ข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค
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
        // แปลงค่าวันที่ Update ข้อมูลลูกค้าที่ทำรายการชำระค่าสาธารณูปโภค
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
        // dd(['รายละเอียดข้อมูลลูกค้า',$id,$decrypted_customer_id,$recurring_transaction,$customer]);
        return view('admin.management.customer.detail',compact('customers','recurring_transaction','get_agencys'),['customer_create_date' => $customer_create_date_th, 'customer_update_date' => $customer_update_date_th, 'create_date' => $create_date_th, 'update_date' => $update_date_th, 'apply_date_th' => $apply_date_th]);
    }
    // function อัพเดทข้อมูลรายการชำระค่าสาธารณูปโภค
    public function update_transaction($id, Request $request)
    {
        $decrypted_transaction_id = Crypt::decryptString($id); // decryptString ค่า id ข้อมูลผู้ลงทะเบียนชำระค่าสาธารณูปโภคที่ encryptString
        // dd([$decrypted_transaction_id,$request]);
        $card_number_encryptString = Crypt::encryptString($request->card_number1.$request->card_number2.$request->card_number3.$request->card_number4);
        $get_cards = DB::table('card')->select('id','card_name','card_type_number')->where('useflag','Y')->get();

        // foreach($get_cards as $get_card){
        //     if($get_card->card_type_number == $request->card_number1.$request->card_number2){ // ตรวจสอบ format ของหมายเลขบัตรเครดิต 8 หลักแรก

        //     }
        // }
        dd([$decrypted_transaction_id,$request,$card_number_encryptString,$request->card_number1.$request->card_number2,$get_cards]);
        // $update_transaction = DB::table('recurring_transaction')
        //     ->where('id',$decrypted_transaction_id)
        //     ->update([

        //     ])


        // $customers = array();
        // return view('admin.management.customer.search',compact('customers'),['input_type'=> '','input_value'=> '']);
    }
}
