<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactformController extends Controller
{
    public function contact_form_index()
    {
        return view('contact_form');
    }

    public function contact_form_send()
    {
        $data = request()->validate([
            'name' => 'required|',
            'email' => 'required|email',
            'message' => 'required|',
        ]);

        Mail::to('test@test.com')->send(new ContactMail($data));
        return redirect('/')->with('message', 'Votre message a bien été envoyé !');
 
    }


}
