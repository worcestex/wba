<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\Order;
use App\Models\Lot;
use App\Models\Bid;
use App\Models\User;
use App\Models\VatRate;

use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\AuctionEndMail;


class AuctionEndCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:auction-end {auction-id}';

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

        $auction_id = $this->argument('auction-id');




            $lots = Lot::select('*')->where('auction_id', '=', $auction_id)->get();

            foreach($lots as $lot){

                $bids = Bid::select('*')->where('lot_id','=',$lot->id)->where('winning_bid','=',1)->get();   

                foreach($bids as $bid){
                    $users = User::select('*')->where('id','=',$bid->user_id)->get(); 
                //Create Order 
                    foreach($users as $user)
                    {                        
                        $this->info($lot);


                        //$vat_percentage_id = VatRate::select('id')->where('id','=',$lot->vat_percentage_id)->get();   
                        //$vat_amount = VatRate::select('rate')->where('id','=',$lot->vat_percentage_id)->get();   


                        //$total_amount = $vat_amount + $bid->bid_amount;


                        Order::create([
                            'order_id' => $lot->id, // Start Stage 
                            'payment_method'=> 'Not Defined', //Buyer Stage
                            'shipping_service'=> 'Not Defined', // Seller Stage
                            'starting_price'=> $lot->starting_price, // Start Stage 
                            'buyer_id'=> $user->id, // Start Stage 
                            'order_status_id' => '1', // Start Stage 
                            'vat_percentage_id' => '1', // Start Stage 
                            'number_of_boxes' => '1', // Seller Stage
                            'billing_country' => 'eng', // Seller Stage
                            'cost' => $bid->bid_amount, // Start stage
                            'is_shipped' => '0', // Start Stage 
                            'shipment_details' => 'test', // 
                            'is_confirmation_sent' => '0', //
                            'delivery_cost' => '10.00', // Start stage
                            'vat_percentage_id' => '1', //$vat_percentage_id, //
                            'vat_amount' => '10.00', //$vat_amount, // Start Stage 
                            'total_amount' => '10.00', //$total_amount, // Start Stage 
                            'is_payment_confirmed' => '0', // Buyer stage
                            'client_ip' => '127.0.0.1' // Buyer stage
                        
                
                        
                        ]);
                        // Mail seller


                        // Mail Buyer
                        $contact = [
                            'name' => $user->name,
                            'email' => $user->email,
                        ];
                        Mail::to($user->email)->send(new AuctionEndMail($contact));
                    
                    }

                }

      


                
            }
            
        

    }
}
