<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\CqsscByApiplus;
use App\Jobs\CqsscByShowApi;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->call(function () {
//            DB::table('timer')->insert([
//                'date' => date('Y-m-d H:i:s')
//            ]);
//        })->everyMinute();

        $schedule->job(new CqsscByApiplus)->everyMinute();
        $schedule->job(new CqsscByShowApi)->everyMinute();
        $schedule->command('queue:listen')->everyMinute();
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
