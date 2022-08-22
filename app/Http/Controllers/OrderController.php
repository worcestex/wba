<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;

use App\Models\User;
use App\Models\Lot;

use Illuminate\Support\Facades\Mail;
use App\Mail\CheckoutSuccessfulMail;
use App\Mail\LotPurchasedMail;
use App\Mail\OrderUpdateMail;



use Illuminate\Http\Request;

//https://www.whiskybull.com/shop/admin/orders/manage.orders.php

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // for admins
        // admin only
        if(auth()->user()->business_member){
            return Order::all();

        }
        return Order::where('buyer_id',auth()->user()->id)->get();



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //for user
        // place new order

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //for admin
        // show order where id == $id

        //for user
        // show order where id == $id if $order->user_id === auth()->user()->id
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Find order and related user
        $order = Order::find($id);
        $user = User::where('id',$order->buyer_id)->get();

        //If 
        
        if($order->order_status_id != $request->order_status_id && $request->order_status_id != null){
            $order_status = OrderStatus::find($request->order_status_id);

            $content = [
                'status' => $order_status->status,
                'email_text' => $order_status->email_text,
                'email' => $user[0]->email

            ];
    
            Mail::to($user[0]->email)->send(new OrderUpdateMail($content));
        }
    
        if (!$order) {
            return response()->json(['message' => 'Lot not Found'], 404);
        }


        // update lot
        $order->update($request->all());
        $order->save();      
    
        return response()->json(['Message' => 'Uploaded Successfully','data' => $order], 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // for admin
        // delete order->id
    }


    public function unpaidOrders(){
        
        return Order::where("is_payment_confirmed", 1)->get();
    }

    public function getUserUnpaidOrders(){
        $user = auth()->user();
        return Order::where("buyer_id", $user->id)->where("is_payment_confirmed", 0)->get();
    }
    public function getUserPaidOrders(){
        $user = auth()->user();
        return Order::where("buyer_id", $user->id)->where("is_payment_confirmed", 1)->get();
    }   

    public function checkoutOrders(Request $request){


        // Stripe Payment Code
        $user_from= $request->user();

        $user_from->createOrGetStripeCustomer();
        
        $orders =  Order::select('order_id','total_amount','order_status_id')->where("buyer_id", auth()->user()->id)->where("is_payment_confirmed", 0)->get();

        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET'));

        $paymentMethod = $stripe->paymentMethods->create([
            'type' => 'card', //this
            'card' => [
              'number' => $request->number,
              'exp_month' => $request->exp_month,
              'exp_year' => $request->exp_year,
              'cvc' => $request->cvc,
            ],
          ]);

          $payment_method_details = $user_from->charge(
            Order::where("buyer_id", $user_from->id)
            ->where("is_payment_confirmed", 0)
            ->sum('total_amount')*100,$paymentMethod)
            ->charges->data[0]->payment_method_details;


            Mail::to($user_from->email)->send(new CheckoutSuccessfulMail());


        foreach($orders as $order){
             
            $seller = Lot::select('seller_id')->where('id',$order->order_id)->get();

            $user_to = User::where('id',$seller[0]->seller_id)->get();

            $userTo = $stripe->accounts->create([
                'type' => 'custom',
                'country' => 'GB',
                'email' => $user_to[0]->email,
                'capabilities' => [
                  'card_payments' => ['requested' => true],
                  'transfers' => ['requested' => true],
                ],
              ]);
            /*
            $stripe->transfers->create([
                'amount' => $order->total_amount*100,
                'currency' => 'gbp',
                'destination' => $userTo->id,
              ]);
              */
              Mail::to($user_to[0]->email)->send(new LotPurchasedMail());

        }
        $orders = Order::
        where("buyer_id", auth()->user()
        ->id)->where("is_payment_confirmed", 0)
        ->update(['order_status_id' => 2])
        ->update(['is_payment_confirmed' => 1]);
        return response()->json(['message' => 'Successful'], 201);



    }

    public function shippedOrders(){
        return response()->json(['message' => 'Successful'], 201);
    }


}
