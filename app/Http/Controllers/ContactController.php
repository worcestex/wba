<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|digits:10|numeric',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $input = $request->all();

        $contact = [
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'subject' => $input['subject'],
            'message' => $input['message']
        ];

        $contact = new Contact($request->all());
        $contact->save();

        return response()->json(['message'=> 'Saved', 'data' => $contact], 201);

    }



    public function sendMail(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|digits:10|numeric',
            'subject' => 'required',
            'message' => 'required',
        ]);

        
        $input = $request->all();

        $contact = [
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'subject' => $input['subject'],
            'message' => $input['message']
        ];

        Mail::to(env('MAIL_USERNAME').'@mailtrap.io')->send(new ContactFormMail($contact));



        return response()->json(['message'=> 'Email sent successfully', 'data' => $input], 200);
    }


}