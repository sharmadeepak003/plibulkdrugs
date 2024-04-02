<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
use Mail;
use App\ParkClaimVariableList;
use App\Helpers\getProduct;

class ParkClaimVariable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parkclaim:variable';

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
        $dateMailfire = [1, 5, 10];
        $quarterArray = ['April', 'October'];
        $todayDate = Carbon::now()->format('Y-m-d');
        //$todayDate = '2023-11-15';
        $currentMonth = date('F', strtotime($todayDate));
        //$currentMonth = 'April';
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $eachMonthCompareDate1 = $year . '-' . $month . '-1';
        $eachMonthCompareDate2 = $year . '-' . $month . '-15';
        if (date('m') <= 6) {
            $currentFinancialYear = (date('Y') - 1) . '-' . date('Y');
        } else {
            $currentFinancialYear = date('Y') . '-' . (date('Y') + 1);
        }
        //currentQuarter 
        $curMonth = date("m", time());
        $currentQuarter = getCurrentQuarterValue($curMonth);

        $getDataParkClaimVariable = DB::table('park_claimvariable_list')->get();
        $checkEntryInTable = $getDataParkClaimVariable->where('financial_year', $currentFinancialYear)->where('qtr_id', $currentQuarter)->first();

        foreach ($quarterArray as $qa) {
            if ($qa == $currentMonth) {
                foreach ($dateMailfire as $dmf) {
                    if ($dmf == date('d')) {
                        
                        if ($checkEntryInTable === null) {
                            $parkClaimVariable = new ParkClaimVariableList();
                            $parkClaimVariable->financial_year = $currentFinancialYear;
                            $parkClaimVariable->qtr_id = $currentQuarter;
                            $parkClaimVariable->save();


                            $data = ["email"=>'bdpli@ifciltd.com',"name"=>"User", "month" => $currentMonth];
                            Mail::send('emails.parkclaimvariable', $data, function ($message) use ($data) {
                                $message->to($data['email'], $data['name'])->subject
                                ('Invoice Mail | Scheme of Promotion of Medical Devices Parks | Reminder!');
                                
                            });
                        } elseif ($checkEntryInTable != null && $checkEntryInTable->status != 'S' && $checkEntryInTable->status != 'D') {

                            $data = ["email"=>'bdpli@ifciltd.com',"name"=>"User", "month" => $currentMonth];
                            Mail::send('emails.parkclaimvariable', $data, function ($message) use ($data) {
                                $message->to($data['email'], $data['name'])->subject
                                ('Invoice Mail | Scheme of Promotion of Medical Devices Parks | Reminder!');
                                
                            });
                        }
                    }
                }
                
            }
        }
        //dd(todayDate, $curMonth, $currentQuarter, $getDataParkClaimVariable, $checkEntryInTable, ($todayDate == '2023-11-14') || ($todayDate == $eachMonthCompareDate2));
        

    }
}
