<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\User;
use auth;
use Carbon\Carbon;
use Response;
use Datatables;
use Hash;
use Redirect;
use Validator;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('home');
        if(Auth::user()->role =="admin"){
            // dd(auth()->check());

            $Dashboard_name = DB::table('agency')
            ->leftjoin('recurring_type','recurring_type.id','=','agency.recurring_type_id')
            ->where('agency.useflag','Y')
            ->select('agency.id','agency.agency_code','agency.agency_name','recurring_type.name_type')
            ->get();

            $powers = DB::table('recurring_transaction')
            ->leftjoin('agency','agency.id','=','recurring_transaction.agency_id')
            ->select('agency.id','agency.agency_name','recurring_transaction.customer_id','recurring_transaction.status_register')
            ->where('agency.agency_code','METROPOLITAN ELECTRICITY')
            ->where('agency.recurring_type_id','1')
            ->where('recurring_transaction.useflag','Y')
            ->get();

            // ประกาศตัวแปรการนับจำนวนลูกค้าของแต่ละสถานะ
            $power_num_pending = 0;
            $power_num_check = 0;
            $power_num_waitingforcorrect = 0;
            $power_num_waitingforreply = 0;
            $power_num_approved = 0;
            $power_num_rejected = 0;


            foreach($powers as $power){
                $agency_name = $power->agency_name; // ชื่อหน่วยงาน Agency
                $agency_id  = $power->id;
                if($power->status_register =='Pending'){ // นับจำนวนลูกค้าสถานะ Pending
                    $power_num_pending = $power_num_pending + 1;
                }elseif($power->status_register =='Check'){ // นับจำนวนลูกค้าสถานะ Check
                    $power_num_check = $power_num_check + 1;
                }elseif($power->status_register =='Waiting for correct'){ // นับจำนวนลูกค้าสถานะ Waiting for correct
                    $power_num_waitingforcorrect = $power_num_waitingforcorrect + 1;
                }elseif($power->status_register =='Waiting for reply'){ // นับจำนวนลูกค้าสถานะ Waiting for reply
                    $power_num_waitingforreply = $power_num_waitingforreply + 1;
                }elseif($power->status_register =='Approved'){ // นับจำนวนลูกค้าสถานะ Approved
                    $power_num_approved = $power_num_approved + 1;
                }elseif($power->status_register =='Rejected'){ // นับจำนวนลูกค้าสถานะ Rejected
                    $power_num_rejected = $power_num_rejected + 1;
                }else{
                    dd('ข้อมูลผิดพลาด');
                }
            }

            return view('adminhome',compact('Dashboard_name'),[
                'agency_id' =>  $agency_id,
                'agency_name'   =>  $agency_name,
                'power_num_pending' =>  $power_num_pending,
                'power_num_check'   =>  $power_num_check,
                'power_num_waitingforcorrect'   =>  $power_num_waitingforcorrect,
                'power_num_waitingforreply'     =>  $power_num_waitingforreply,
                'power_num_approved'    =>  $power_num_approved,
                'power_num_rejected'    =>  $power_num_rejected
            ]);
        }else{
            // $users['users']= \App\User::all();
            $users = User::all();
            return view('userhome', $users);
        }
    }
}
