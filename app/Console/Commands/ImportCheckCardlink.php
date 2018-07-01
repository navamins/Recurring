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

class ImportCheckCardlink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:importcardlink';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command import transaction recurring after check to Cardlink system ';

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
        $detact_file = 'register_'.Carbon::now()->format('Ymd').".txt";
        $path_import = "C:/xampp/htdocs/Recurring/public/import/sftp_cardlink/";
        $path_backup = "C:/xampp/htdocs/Recurring/public/import/sftp_cardlink_backup/";
        $uploaded_log = copy($path_import.$detact_file, $path_backup.$detact_file); // ย้าย file
        $file_name = file($path_import.$detact_file);
        
        $objFopen  = fopen($path_import.$detact_file, 'rb') or die("Unable to open file!");
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
                            'recurring_transaction.update_date'		=>	Carbon::now(),
                            'recurring_transaction.log'		        =>	'update status_register by script local_import_check.bat',
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
                            'recurring_transaction.update_date'		=>	Carbon::now(),
                            'recurring_transaction.log'		        =>	'update status_register by script local_import_check.bat',
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
