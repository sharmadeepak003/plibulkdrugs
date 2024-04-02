<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
use Mail;
use App\ClaimVariablemail;
use App\Helpers\getProduct;

class ClaimVariable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'claim:variable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        
        $todayDate = Carbon::now()->format('Y-m-d'); 
        $currentMonth = date('F', strtotime($todayDate));
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $eachMonthCompareDate1 = $year.'-'.$month.'-1';
        $eachMonthCompareDate2 = $year.'-'.$month.'-15';
          //currentFinancialYear
          if (date('m') <= 6)
          {
              $currentFinancialYear = (date('Y')-1) . '-' . date('Y');
          }
          else 
          {
              $currentFinancialYear = date('Y') . '-' . (date('Y') + 1);
          }

          
         //currentQuarter 
         $curMonth = date("m", time());
         $currentQuarter = getCurrentQuarterValue($curMonth);
        
        $getDataClaimVariable = DB::table('schedular_mail_claimvariable')->get();
        $checkEntryInTable = $getDataClaimVariable->where('financial_year',$currentFinancialYear)->where('month',$currentMonth)->first();
          
        if(($todayDate == $eachMonthCompareDate1) || ($todayDate == $eachMonthCompareDate2))
        {
            // mail should be fire and single entry in the database table with two fields like qtr and FY
                if($checkEntryInTable === null)
                { 
                    $schedularMailFixed = new ClaimVariablemail();
                    $schedularMailFixed->financial_year = $currentFinancialYear;
                    $schedularMailFixed->qtr_id = $currentQuarter;
                    $schedularMailFixed->month = $currentMonth;
                    $schedularMailFixed->save();

                        $data = ["email"=>'bdpli@ifciltd.com',"name"=>"User", "month" => $currentMonth];
                        Mail::send('emails.pliclaimvariable', $data, function($message) use($data) {
                            $message->to($data['email'],$data['name'])->subject
                            ('Invoice Mail | PLI Scheme for Medical Devices | Claim Verification Reminder!');
                            
                        });
                }
               
                    
                    $data = ["email"=>'bdpli@ifciltd.com',"name"=>"User", "month" => $currentMonth];
                        Mail::send('emails.pliclaimvariable', $data, function($message) use($data) {
                            $message->to($data['email'],$data['name'])->subject
                            ('Invoice Mail | PLI Scheme for Medical Devices | Claim Verification Reminder!');
                           
                        });
                
        }
    }
}
