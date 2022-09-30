<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Billable;
use App\Mail\RegistrationFeeMail;
use Illuminate\Support\Facades\Mail;



class RegistrationFeeController extends Controller
{
    /**
     * payment view
     */
    public function handleGet()
    {
        return view('stripe');
    }
  
    /**
     * handling payment with POST
     */
    public function purchaseRegistrationFee(Request $request)
    {

        // Stripe Payment Code
        $user= $request->user();
        $user->createOrGetStripeCustomer();

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


          $stripe->paymentMethods->attach(
            $paymentMethod->id,
            ['customer' => auth()->user()->stripe_id]
          );

          
            //Send mail

            $contact = [
                'name' => "test",
                'email' => "test@gmail.com",
            ];
            Mail::to($user->email)->send(new RegistrationFeeMail($contact));
            
            

            // Set user to business member
            $user->allowed_to_bid = 1;

            // Set user stripe details


            $payment_method_details = $user->charge(1500,$paymentMethod)->charges->data[0]->payment_method_details;
            
            $user->pm_last_four = $payment_method_details->card->last4;
            $user->pm_type = $payment_method_details->type;


            $user->save();
            return response()->json(['message' => 'Success', 'data' => $user->pm_type], 201);



            //$user->charge(1500,$paymentMethod);
            // Set up permenent subscription

            // 
            

        
          

    }
    public function sendRegistrationFeeEmail(Request $request)
    {


    }

}