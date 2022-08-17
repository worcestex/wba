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
        // currently only fetching auth user, but eventually will need to fetch all users
        // needs to be changed permissions to only admin roles can fetch all users
        return User::find(auth()->user()->id);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'contact_number' => 'nullable',
            'mobile_number' => 'nullable',
            'address_1' => 'nullable',
            'address_2' => 'nullable',
            'city' => 'nullable',
            'country' => 'nullable',
            'postcode' => 'nullable',


        ]);
        



        $user->update($request->all());
        $user->save();      
    
        return response()->json(['data' => $user], 201);





    }   
}
