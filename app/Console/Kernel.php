<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Bgreminder::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('backup:run')->dailyAt('01:40')->appendOutputTo(storage_path().'/logs/'.php_sapi_name().'scheduler.log');

          $schedule->command('bg:reminder')->dailyAt('11:00')->appendOutputTo(storage_path().'/logs/'.php_sapi_name().'scheduler.log');
	$schedule->command('claim:variable')->cron('00 11 * * 1,2,3,4,5,6,7')->appendOutputTo(storage_path().'/logs/'.php_sapi_name().'claim_variable.log');

$schedule->command('invoice:mail')->cron('00 11 * * 1,2,3,4,5,6,7')->appendOutputTo(storage_path().'/logs/'.php_sapi_name().'invoice_mail.log');

$schedule->command('parkclaim:variable')->cron('00 11 * * 1,2,3,4,5,6,7')->appendOutputTo(storage_path().'/logs/'.php_sapi_name().'parkclaim_variable.log');	 
		  

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
