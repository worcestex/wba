<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Models\Auction;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected function schedule(Schedule $schedule)
    {
        // Clear expired tokens from password_resets table
        $schedule->command('auth:clear-resets')->everyFifteenMinutes();
        $schedule->command('WinningBidCommand')->dailyAt('13:00');

        //Send Auction Finish email
        $auctions = Auction::all();


        foreach ($auctions as $auction) {

            $start_time = Carbon::parse($auction->start_date_time);
            $end_time = Carbon::parse($auction->end_date_time);
            

            $schedule->command('command:auction-start')->when($start_time->isCurrentMinute());
            $schedule->command('command:auction-end', [$auction->id])->when($end_time->isCurrentMinute());

        }
       

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
