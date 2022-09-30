<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->business_member)
        {        return User::all();


        }
        return User::find(auth()->user()->id);

  
        // currently only fetching auth user, but eventually will need to fetch all users
        // needs to be changed permissions to only admin roles can fetch all users
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
        $user = User::find($request);

        //User exists
        if(User::where("email", $request->email)->first() != null){
            return response()->json(['message' => 'Failed', 'data' => 'user exists'], 201);

        }

        // Insert request to database
        User::create([
            'email' => $request->email,
            'email_verified' => Carbon::now(),
            'password' => Hash::make($request->password),
        ]);

 

        return response()->json(['message' => 'Successful', 'data' => 'test'], 201);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'Not found'], 404);
        } else if (auth()->user()->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        } else {
            return response()->json(['message' => 'Success', 'data' => $user], 201);
        }
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
        $user = User::find($id);


    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }




        $user->update($request->all());
        $user->save();      
    
        return response()->json(['data' => 'Uploaded Successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
                
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'User not found'], 404);

        }
        else{
            User::find($id)->delete();
            return response()->json(['message' => 'Deleted'], 202);
        }
    }



    public function getUserDetails(Request $request){


        $user = auth()->user();
        return $user;

    }

    public function updateUserDetails(Request $request){
        $user = auth()->user();
        $request->validate([
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'contact_number' => 'nullable',
            'mobile_number' => 'nullable',
            'address_1' => 'nullable',
            'address_2' => 'nullable',
            'city' => 'nullable',
            'country' => 'nullable',
            'billing_address_1' => 'nullable',
            'billing_address_2' => 'nullable',
            'billing_postcode' => 'nullable',
            'billing_country' => 'nullable',

            'shipping_address_1' => 'nullable',
            'shipping_address_2' => 'nullable',
            'shipping_postcode' => 'nullable',
            'shipping_country' => 'nullable',



        ]);
        
        


        $user->update($request->all());
        $user->save();      
    
        return response()->json(['data' => $user], 201);





    }  
    public function updateBuyerCard(Request $request){

        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET'));
            $user = auth()->user();
            
            $user->createOrGetStripeCustomer();
            $stripe_customer = $stripe->customers->retrieve(
            auth()->user()->stripe_id,
            []
          );
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
          return $stripe->paymentMethods->all([
            'customer' => auth()->user()->stripe_id,
            'type' => 'card',
          ]);

    } 
    public function updateSeller(Request $request){
        //Create Seller Account
        $user = auth()->user();


        /* SELLER STRIPE ACCOUNT
        $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET'));
        $user = auth()->user();
        $user_to = $stripe->accounts->create([
            'type' => 'custom',
            'country' => 'GB',
            'business_type'=>'company',
            'capabilities' => [
                'card_payments' => ['requested' => true],
                'transfers' => ['requested' => true],
                ],
        ]);

 // Add user account sort code and account number
 $card = $stripe->tokens->create([
    'bank_account' => [
      'country' => 'GB',
      'currency' => 'gbp',
      'account_holder_name' => 'Jenny Rosen',
      'account_holder_type' => 'individual',
      'routing_number' => '108800',
      'account_number' => 'GB82WEST12345698765432',
    ],
  ]);

// Post onboarding info
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/accounts/'.$user_to->id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "

business_profile[mcc]=5734&company[address][city]=Schenectady
&business_profile[url]=https://jjamestaylor.com&company[address][line1]=\"123
&company[address][postal_code]=B49 6AG
&representative[address][postal_code]=B496AG

&company[address][state]=Warwickshire
&company[tax_id]=000000000
&company[name]=\"The
&company[phone]=8888675309&company[owners_provided]=true&company[directors_provided]=true&company[executives_provided]=true&external_account=".$card->id."&tos_acceptance[date]=1609798905&tos_acceptance[ip]=8.8.8.8"

);

//&representative[address][postal_code]=B496AG
//&representative[address][city]=Alcester
//&representative[address][line1]=Road
//&representative[dob][day]=12
//&representative[dob][month]=12
//&representative[dob][year]=2000
//&representative[email]=johndoe1@gmail.com
//&representative[first_name]=John
//&representative[last_name]=Doe
//&representative[phone]=8888675309
//&representative[relationship][executive]=
//&representative[relationship][title]=Dr


curl_setopt($ch, CURLOPT_USERPWD, 'sk_test_51JmcZvIIkH0SB479edi7hQjjhnWNYG3cV1ZOtRapkKQB5AeZzOIuBVvzOVjdTrj67LaOpeM0sXTqMLBH2vBnxs0v00ojjmldY9' . ':' . '');

$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
return $result;
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
  
        
        
        $user->bank_account = $user_to->id  ;
        $user->save();  
        return $user_to;
        */

    }

}
