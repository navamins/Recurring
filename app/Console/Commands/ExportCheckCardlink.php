<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
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

class ExportCheckCardlink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:exportcardlink';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command export transaction recurring for check to Cardlink system ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $query_pendings = DB::table('recurring_transaction')
            ->leftjoin('customer','customer.id','=','recurring_transaction.customer_id')
            ->where('recurring_transaction.status_register','Pending')
            ->where('customer.useflag','Y')
            ->where('recurring_transaction.useflag','Y')
            ->select('recurring_transaction.id','customer.id_card','recurring_transaction.card_number')
            ->get();
        
        $fileName = 'register_'.Carbon::now()->format('Ymd').'.txt'; // register_Ymd.txt 
        $objFopen = fopen(public_path('/export/sftp_cardlink/'.$fileName), 'w'); // Example: register_20180621.txt
        $total = 0;
        
        fwrite($objFopen, 'H|'.Carbon::now()->format('Ymd')."\r\n"); // แปะ Header

        if($query_pendings->isEmpty()){
            $total = 0;    
        }else{
            foreach($query_pendings as $key => $query_pending){
                fwrite($objFopen, 
                    'D|'.str_pad($query_pending->id,6,'0',STR_PAD_LEFT)."|".$query_pending->id_card."|".str_pad(Crypt::decryptString($query_pending->card_number),19,'0',STR_PAD_LEFT)."\r\n"
                ); // data
                $total = $key + 1;
                $get_recurring_transaction_id[] = $query_pending->id;
            }
            // อัพเดทสถานะจาก Pending เป็น Check
            if($objFopen){
                foreach($get_recurring_transaction_id as $update_id){
                    $update_recurring_transaction = DB::table('recurring_transaction')
                        ->where('status_register','Pending')
                        ->where('id',$update_id)
                        ->update([
                            'status_register'   =>  'Check',
                            'update_date'		=>	Carbon::now(),
                            'log'		        =>	'update status_register by script local_export_pending.bat',
                    ]);
                }
            }   
        }

        fwrite($objFopen, 'T|'.str_pad($total,6,'0',STR_PAD_LEFT)."\r\n"); // แปะ Header
        fclose($objFopen);

    }
}
