<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use Response;
use Auth;
use Hash;
use Redirect;

class UserController extends Controller
{
    // function เรียกดูข้อมูลส่วนตัว
    public function owner_profile()
    {
        if(Auth::check() != true){
            return view('welcome');
        }else{
            $users = User::where('id', Auth::user()->id)->get();
            foreach($users as $user){
                $Myaccount = $user->id;
                $create_date = $user->create_date; // Ex. "2018-03-23 11:36:32"
                $update_date = $user->update_date; // Ex. "2018-03-23 11:36:32"
            }
            if(Auth::user()->id == $Myaccount){
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
                return view('profile.profile_detail',compact('users'),['create_date' => $create_date_th, 'update_date' => $update_date_th]);
            }else{
                dd('my account not found ');
            }
        } 
    }
    // function เรียกฟอร์มแก้ไขข้อมูลส่วนตัว
    public function profile_edit(Request $request)
    {
        $users = User::where('id',Auth::user()->id)->get();
        return view('profile.form_edit',compact('users'));
    }
    // function อัพเดทข้อมูลส่วนตัว
    public function profile_update(ProfileRequest $request)
    {
        $users = User::where('id',Auth::user()->id)
            ->update([
                'emp_code'  =>  $request->emp_code,
                'name'      =>  $request->name,
                'lastname'  =>  $request->lastname,
                'email'     =>  $request->email,
                'update_user'   =>  Auth::user()->id,
                'update_date'   =>  Carbon::now(),
                'log'       =>  'update'
            ]);
        return redirect()->route('owner.profile')->with('success', 'บันทึกข้อมูลสำเร็จ');
    }
    // function เรียกฟอร์มแก้ไขข้อมูลรหัสผ่านส่วนตัว
    public function profile_edit_pw()
    {
        return view('profile.form_edit_password');
    }
    // function อัพเดทรหัสผ่านส่วนตัว
    public function profile_update_pw(PasswordRequest $request)
    {
        if(Hash::check($request->password_raw, Auth::user()->password)){
            $user = User::find(Auth::user()->id); 
            $user->password = Hash::make($request->password);
            $user->update_user = Auth::user()->id;
            $user->update_date = Carbon::now();
            $user->log  = 'update password';
            $user->save();

            return redirect()->route('owner.profile')->with('success', 'บันทึกข้อมูลสำเร็จ');
        }else{
            // return back()->withInput();
            return Redirect::back()->withInput()->withErrors(array('errors' => 'รหัสผ่านปัจจุบันผิด'));
        }
    }
}