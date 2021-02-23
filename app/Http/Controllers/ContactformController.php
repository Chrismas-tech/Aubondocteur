<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactformController extends Controller
{
    public function contact_page()
    {
        return view('contact_form');
    }

    public function contact_form_send(Request $request)
    {

        $request->validate([
            'name' => 'required|',
            'email' => 'required|email',
            'message' => 'required|',
            'g-recaptcha-response' => 'required|captcha',
        ]);
 
        dd('yolo');
        $data = [
            'name' => 'required|',
            'email' => 'required|email',
            'message' => 'required|',
        ];


        Mail::to('ichrisinfo@gmail.com')->send(new ContactMail($data));
        return redirect()->back()->with('message', 'Votre message a bien été envoyé à l\'administrateur !');
    }
}
