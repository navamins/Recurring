<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserPwRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Datatables;
use Auth;
use Hash;
use Redirect;
use App\User;

class ManageUserController extends Controller
{
    // function ตารางข้อมูลผู้ใช้งานระบบ
    public function index()
    {
        $users = User::all();
        // dd(Datatables::of(User::query())->make(true));
        
        return view('admin.management.users.index',compact('users'));
    }
    // function ฟอร์มสร้างบัญชีผู้ใช้งานระบบ
    public function create()
    {
       return view('admin.management.users.create');
    }
    // function บันทึกข้อมูลบัญชีผู้ใช้งานระบบ
    public function store(CreateUserRequest $request)
    {
        if(Auth::check() != true){
            return view('welcome');
        }else{
            switch (Auth::user()->role) {
                case 'admin':
                    $insert_user = DB::table('users')
                        ->insert([
                            'emp_code'		    =>	$request->emp_code,
                            'name'	            =>	$request->name,
                            'lastname'          =>	$request->lastname,
                            'email'             =>	$request->email,
                            'password'          =>	Hash::make($request->password),
                            'remember_token'    =>	csrf_token(),
                            'role'              =>	$request->role,
                            'useflag'			=>	'Y',
                            'create_user'		=>	Auth::user()->id,
                            'create_date'		=>	Carbon::now(),
                            'update_user'		=>	Auth::user()->id,
                            'update_date'		=>	Carbon::now(),
                            'log'		        =>	'create',
                        ]);

                        return redirect()->route('user.index')->with('success', 'บันทึกข้อมูลสำเร็จ');
                    break;
                
                default:
                        return Redirect::back()->withInput()->withErrors(array('errors' => 'ไม่สามารถบันข้อมูลผู้ใช้งานระบบได้ กรุณาติดต่อ Administrator'));
                    break;
            }
        }
    }
    // function ดูรายละเอียดข้อมูลบัญชีผู้ใช้งานระบบ
    public function show($id)
    {
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของ user ที่ encryptString
        $users = DB::table('users')
            ->leftjoin('users as create_by','create_by.id','=','users.create_user')
            ->leftjoin('users as update_by','update_by.id','=','users.update_user')
            ->select('users.id',
                    'users.emp_code',
                    'users.name',
                    'users.lastname',
                    'users.email',
                    'users.role',
                    'users.useflag',
                    'users.create_date',
                    'users.update_date',
                    'create_by.name as create_by_name',
                    'create_by.lastname as create_by_lastname',
                    'update_by.name as update_by_name',
                    'update_by.lastname as update_by_lastname'
                )
            ->where('users.id',$decrypted_id)
            ->get();
        foreach($users as $user){
            $create_date = $user->create_date; // Ex. "2018-03-23 11:36:32"
            $update_date = $user->update_date; // Ex. "2018-03-23 11:36:32"
        }
        
        // แปลงค่าวันที่ Create Account
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
        // แปลงค่าวันที่ Update Account
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
        return view('admin.management.users.show',compact('users'),['create_date' => $create_date_th, 'update_date' => $update_date_th]);
    }
    // function เรียกฟอร์มแก้ไขข้อมูลบัญชีผู้ใช้งานระบบ
    public function edit($id)
    {
        // dd($id);
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของ user ที่ encryptString
        $user = User::find($decrypted_id);
        // $user = User::find($id);
        return view('admin.management.users.edit',compact('user'));
    }
    // function อัพเดทข้อมูลบัญชีผู้ใช้งานระบบ
    public function update(UpdateUserRequest $request,$id)
    {
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของ user ที่ encryptString
        if(Auth::check() != true){
            return view('welcome');
        }else{
            switch (Auth::user()->role) {
                case 'admin':
                    $update_user = DB::table('users')
                        ->where('id',$decrypted_id)
                        ->update([
                            'emp_code'		    =>	$request->emp_code,
                            'name'	            =>	$request->name,
                            'lastname'          =>	$request->lastname,
                            'email'             =>	$request->email,
                            'role'              =>	$request->role,
                            'useflag'			=>	$request->useflag,
                            'update_user'		=>	Auth::user()->id,
                            'update_date'		=>	Carbon::now(),
                            'log'		        =>	'update user by admin',
                        ]);

                        return redirect()->route('user.show',$id)->with('success', 'บันทึกข้อมูลสำเร็จ');
                    break;
                
                default:
                        return Redirect::back()->withInput()->withErrors(array('errors' => 'ไม่สามารถบันข้อมูลผู้ใช้งานระบบได้ กรุณาติดต่อ Administrator'));
                    break;
            }
        }
    }
    // function เรียกฟอร์มแก้ไขข้อมูลรหัสผ่านบัญชีผู้ใช้งานระบบ
    public function edit_password($id)
    {
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของ user ที่ encryptString
        $user = User::find($decrypted_id);
        return view('admin.management.users.edit_password');
    }
    // function อัพเดทข้อมูลรหัสผ่านบัญชีผู้ใช้งานระบบ
    public function update_password($id,UpdateUserPwRequest $request)
    {
        // dd([$id,$request]);
        $decrypted_id = Crypt::decryptString($id); // decryptString ค่า id ของ user ที่ encryptString
        if(Auth::check() != true){
            return view('welcome');
        }else{
            switch (Auth::user()->role) {
                case 'admin':
                    $update_user = DB::table('users')
                        ->where('id',$decrypted_id)
                        ->update([
                            'password'          =>  Hash::make($request->password),
                            'update_user'		=>	Auth::user()->id,
                            'update_date'		=>	Carbon::now(),
                            'log'		        =>	'update password by admin',
                        ]);

                        return redirect()->route('user.show',$id)->with('success', 'บันทึกข้อมูลสำเร็จ');
                    break;
                
                default:
                        return Redirect::back()->withInput()->withErrors(array('errors' => 'ไม่สามารถบันข้อมูลผู้ใช้งานระบบได้ กรุณาติดต่อ Administrator'));
                    break;
            }
        }        
    }
}
