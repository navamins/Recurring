<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateNumberTypeRequest;
use App\Http\Requests\UpdateNumberTypeRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Datatables;
use Auth;
use Redirect;

class ManageNumberTypeController extends Controller
{
    // function ตารางข้อมูลบัตรเครดิต
    public function index()
    {
        $cards = DB::table('card')
            ->leftjoin('users as create','create.id','=','card.create_user')
            ->leftjoin('users as update','update.id','=','card.update_user')
            ->select('card.id','card.card_name','card.card_type_number','card.card_type','card.useflag',
                'update.name as update_name',
                'update.lastname as update_lastname')
            ->get();
        return view('admin.management.bank.number_type.index',compact('cards'));
    }
    // function ฟอร์มสร้างข้อมูลบัตรเครดิต
    public function create()
    {
        return view('admin.management.bank.number_type.create');
    }
    // function บันทึกข้อมูลบัตรเครดิต
    public function store(CreateNumberTypeRequest $request)
    {
        if(Auth::check() != true){
            return view('welcome');
        }else{
            switch (Auth::user()->role) {
                case 'admin':
                    $path = 'pic/Credit_Card';
                    $image = $request->file('addImage');
                    $pic_name = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = $path;
                    $image->move($destinationPath, $pic_name);

                    $insert_card = DB::table('card')
                        ->insert([
                            'card_name'		    =>	$request->card_name,
                            'card_detail'	    =>	$request->card_detail,
                            'card_type_number'  =>	$request->card_type_number,
                            'card_type'         =>	$request->card_type,
                            'pic_name'         =>	$pic_name,
                            'pic_link'         =>	$path,
                            'useflag'			=>	'Y',
                            'create_user'		=>	Auth::user()->id,
                            'create_date'		=>	Carbon::now(),
                            'update_user'		=>	Auth::user()->id,
                            'update_date'		=>	Carbon::now(),
                            'log'		        =>	'insert by admin',
                        ]);
                    if(!$insert_card){
                        return Redirect::back()->withInput($request->all());
                    }
                        return redirect()->route('cardtype.index')->with('success', 'บันทึกข้อมูลสำเร็จ');
                    break;
                
                default:
                        return Redirect::back()->withInput($request->all())->withErrors(array('errors' => 'ไม่สามารถบันข้อมูลบัตรเครดิตได้ กรุณาติดต่อ Administrator'));
                    break;
            }
        }
    }
    // function ดูรายละเอียดข้อมูลบัตรเครดิต
    public function show($id)
    {
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของข้อมูลบัตรเครดิต ที่ encryptString
        $card = DB::table('card')
            ->leftjoin('users as create','create.id','=','card.create_user')
            ->leftjoin('users as update','update.id','=','card.update_user')
            ->select('card.id',
                'card.card_name',
                'card.card_detail',
                'card.card_type_number',
                'card.card_type',
                'card.pic_name',
                'card.pic_link',
                'card.useflag',
                'card.create_date',
                'card.create_user',
                'create.name as create_name',
                'create.lastname as create_lastname',
                'card.update_date',
                'card.update_user',
                'update.name as update_name',
                'update.lastname as update_lastname')
            ->where('card.id',$decrypted_id)
            ->get();

        foreach($card as $get_card){
            $create_date = $get_card->create_date; // Ex. "2018-03-23 11:36:32"
            $update_date = $get_card->update_date; // Ex. "2018-03-23 11:36:32"
        }
        // แปลงค่าวันที่ Create ข้อมูลบัตรเครดิต
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
        // แปลงค่าวันที่ Update ข้อมูลบัตรเครดิต
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

        return view('admin.management.bank.number_type.show',compact('card'),['create_date' => $create_date_th, 'update_date' => $update_date_th]);
    }
    // function เรียกฟอร์มแก้ไขข้อมูลบัตรเครดิต
    public function edit($id)
    {
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของข้อมูลบัตรเครดิต ที่ encryptString
        $card = DB::table('card')->find($decrypted_id);
        return view('admin.management.bank.number_type.edit',compact('card'));
    }
    // function อัพเดทข้อมูลบัตรเครดิต
    public function update(UpdateNumberTypeRequest $request,$id)
    {
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของข้อมูลบัตรเครดิต ที่ encryptString\
        if(Auth::check() != true){
            return view('welcome');
        }else{
            switch (Auth::user()->role) {
                case 'admin':
                    if($request->file('addImage') == null){ // ไม่ได้อัพโหลดรูปภาพใหม่
                        $update_card = DB::table('card')
                            ->where('id',$decrypted_id)
                            ->update([
                                'card_name'	        =>	$request->card_name,
                                'card_detail'	    =>	$request->card_detail,
                                'card_type_number'  =>	$request->card_type_number,
                                'card_type'         =>	$request->card_type,
                                'useflag'			=>	$request->useflag,
                                'update_user'		=>	Auth::user()->id,
                                'update_date'		=>	Carbon::now(),
                                'log'		        =>	'update by admin',
                            ]);

                        if(!$update_card){
                            return Redirect::back()->withInput($request->all());
                        }
                    }else{  // อัพโหลดรูปภาพใหม่
                        $path = 'pic/Credit_Card';
                        $image = $request->file('addImage');
                        $pic_name = time().'.'.$image->getClientOriginalExtension();
                        $destinationPath = $path;
                        $image->move($destinationPath, $pic_name);

                        $update_card = DB::table('card')
                            ->where('id',$decrypted_id)
                            ->update([
                                'card_name'	        =>	$request->card_name,
                                'card_detail'	    =>	$request->card_detail,
                                'card_type_number'  =>	$request->card_type_number,
                                'card_type'         =>	$request->card_type,
                                'pic_name'         =>	$pic_name,
                                'pic_link'         =>	$path,
                                'useflag'			=>	$request->useflag,
                                'update_user'		=>	Auth::user()->id,
                                'update_date'		=>	Carbon::now(),
                                'log'		        =>	'update by admin',
                            ]);

                        if(!$update_card){
                            return Redirect::back()->withInput($request->all());
                        }
                    }
                    
                    return redirect()->route('cardtype.show',$id)->with('success', 'บันทึกข้อมูลสำเร็จ');
                    break;
                
                default:
                        return Redirect::back()->withInput()->withErrors(array('errors' => 'ไม่สามารถบันข้อมูลบัตรเครดิตได้ กรุณาติดต่อ Administrator'));
                    break;
            }
        }
    }
}
