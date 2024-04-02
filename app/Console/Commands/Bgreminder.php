<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
use Mail;

class Bgreminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bg:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send BG Expiring Reminder Mail ';

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
        $from = Carbon::now();
        $to = Carbon::now()->addDay(30);

        $exp=DB::table('bg_trackers as bg')->whereBetween('expiry_dt', [$from, $to])->where('bg.submit','Y')->whereNotIn('bg.bg_status',['IN'])->whereNotIn('bg.bg_status',['RE'])->select('bg.*')->get();
        
        foreach($exp as $data)
        {
            $user =DB::table('approved_apps_details as a')
            ->join('bg_trackers', 'bg_trackers.app_id', '=', 'a.id')
            ->where('bg_trackers.submit','Y')
            ->whereNotIn('bg_trackers.bg_status',['IN'])
            ->where('bg_trackers.id',$data->id)
            ->select('a.*', 'bg_trackers.*')
            ->first();

            $data = array('name'=>$user->name,'product'=>$user->product,'bg_no'=>$user->bg_no, 'bg_amount'=>$user->bg_amount,'bank_name'=>$user->bank_name,'issued_dt'=>$user->issued_dt,'expiry_dt'=>$user->expiry_dt,'email'=>$user->email,'');

            Mail::send('emails.bg_reminder', $data, function($message) use($data) {
            $message->to($data['email'],$data['name'])->subject
            ('BG Roll Over | PLI Scheme for Bulk Drugs | Reminder!');
            //$message->from('bdpli@ifciltd.com','PLI Bulk Drugs');
            $message->cc('bdpli@ifciltd.com','PLI Bulk Drugs');

            });
        }
    }
}
