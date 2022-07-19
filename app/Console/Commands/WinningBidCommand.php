<?php

namespace App\Console\Commands;

use App\Models\Auction;
use App\Models\Lot;
use App\Models\Bid;
use App\Models\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\WinningBidMail;


use Carbon\Carbon;


use Illuminate\Console\Command;

class WinningBidCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'WinningBidCommand';

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
        $contact = [
            'name' => 'john',
            'email' => 'john@gmail.com',

        ];


        $auctions = Auction::select('id')->whereDate('end_date_time', '<=', Carbon::now())->get();

        foreach($auctions as $auction){
            $lots = Lot::select('id')->where('auction_id', '=', $auction->id)->get();
            foreach($lots as $lot){
                $users = Bid::select('user_id')->where('lot_id','=',$lot->id)->where('winning_bid','=',1)->get();
                
                foreach($users as $user){
                    $emails = User::select('email')->where('id','=',$user->user_id)->get();


                    Mail::to($emails)->send(new WinningBidMail($contact));

                    

                }
            }

        }
    }
}
