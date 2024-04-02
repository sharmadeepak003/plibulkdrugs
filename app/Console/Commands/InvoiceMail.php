<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
use Mail;
use App\SchedularMailFixed;
use auth;
use App\Helpers\getProduct;

class InvoiceMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command use to send an email for the invoice ';

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
     * @return int
     */
    public function handle()
    {
        
        $quarterArray = ['April','July','October','January'];
        $dateMailfire = [1,3,5,7,9];
       // $quarterArray = ['November'];
        $todayDate = Carbon::now()->format('Y-m-d');
        $currentMonth = date('F', strtotime($todayDate));
        $qtrStartDate = Carbon::now();

        // get 10th date of each quarter start month
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('y');
        $day = $year.'-'.$month.'-10';
        $qtrEndDate = Carbon::parse($day)->format('Y-m-d');
        $getDataSchedularMailFixedCount = DB::table('schedular_mail_fixed')->get();
        
        
        
        
        
        foreach($quarterArray as $aq)
        {
            if($aq == $currentMonth)
            {    
                // Below code used to get Current Financial Year
                if (date('m') <= 6) 
                {
                    $financial_year = (date('Y')-1) . '-' . date('Y');
                } 
                else
                {
                    $financial_year = date('Y') . '-' . (date('Y') + 1);
                }
                $currentFy = $financial_year;
                // End code used to get Current Financial Year
                
                // Below code used to get Current Quarter
                $curMonth = date("m", time());
                $currentFyQtr = getCurrentQuarterValue($curMonth);

                $checkEntryInTable = $getDataSchedularMailFixedCount->where('financial_year',$currentFy)->where('qtr_id',$currentFyQtr)->first();
                
               
                if($todayDate <= $qtrEndDate)
                {
                    
                    if($checkEntryInTable === null)
                    { 

                        $schedularMailFixed = new SchedularMailFixed();
                        $schedularMailFixed->financial_year = $currentFy;
                        $schedularMailFixed->qtr_id = $currentFyQtr;
                        $schedularMailFixed->save();

                        $curMonth = date("m", time());
                        $quarter = ceil($curMonth/4);
                        $quarter = intval($quarter);
                        //mail 

                        foreach($dateMailfire as $dmf)
                        {
                            if($dmf == date('d'))
                            {
                                $data = ["email"=>'bdpli@ifciltd.com',"name"=>"User", "month" => $currentMonth];
                                Mail::send('emails.fixedmail', $data, function($message) use($data) {
                                $message->to($data['email'])->subject
                                ('Invoice Mail | PLI Scheme for Medical Devices | Fixed Fee Reminder!');
                                });
                            }
                        }
                        
                    }
                    elseif($checkEntryInTable != null && $checkEntryInTable->status != 'S' && $checkEntryInTable->status != 'D')
                    {

                      
                        foreach($dateMailfire as $dmf)
                        {
                            if($dmf == date('d'))
                            {
                                $data = ["email"=>'bdpli@ifciltd.com',"name"=>"User", "month" => $currentMonth];
                                Mail::send('emails.fixedmail', $data, function($message) use($data) {
                                $message->to($data['email'])->subject
                                ('Invoice Mail | PLI Scheme for Medical Devices | Fixed Fee Reminder!');
                                });
                            }
                        }
                    }
                    
                }
                 
                
            }

            
        }

        
       
        
            
      

          
            // $user =DB::table('approved_apps as a')
            // ->join('eligible_products','eligible_products.target_id','=','a.target_segment')
            // ->join('users', 'users.id', '=', 'a.created_by')
            // ->join('bg_trackers', 'bg_trackers.app_id', '=', 'a.id')
            // ->where('bg_trackers.submit','Y')
            // ->whereNotIn('bg_trackers.bg_status',['IN'])
            // ->where('bg_trackers.id',$data->id)
            // ->select('a.*', 'bg_trackers.*','users.email','users.name','eligible_products.target_segment')
            // ->first();
            //dd($user,$data->id);
            // $data = array('name'=>$user->name,'bg_no'=>$user->bg_no,'app_no'=>$user->app_no,'expiry_dt'=>$user->expiry_dt,'email'=>$user->email,'target_segment'=>$user->target_segment,
            // 'bg_amount'=>$user->bg_amount,'issued_dt'=>$user->issued_dt,'bank_name'=>$user->bank_name);
            //dd($data);
            // Mail::send('emails.bg_reminder', $data, function($message) use($data) {
            // $message->to($data['email'],$data['name'])->subject
            // ('BG Roll Over | PLI Scheme for Medical Devices | Reminder!');
            // $message->cc('bdpli@ifciltd.com','PLI Medical Devices');
            // });
       
        // $this->info('Testing  has been send successfully');
    }
}
