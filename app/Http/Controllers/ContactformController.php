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
            'email' => 'required|',
            'message' => 'required|',
            'g-recaptcha-response' => 'required|',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];


        Mail::to('ichrisinfo@gmail.com')->send(new ContactMail($data));
        return redirect()->back()->with('message', 'Votre message a bien été envoyé à l\'administrateur !');
    }
}
