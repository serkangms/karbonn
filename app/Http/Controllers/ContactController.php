<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {

        return view('theme.page.contact');

    }

    public function send(Request $request)
    {
        $contact = new Contact();
        $contact->name = $request->input('name');
        $contact->title = $request->input('title');
        $contact->description = $request->input('description');
        $contact->email = $request->input('email');
        $contact->created_at = date('Y-m-d H:i:s');
        $contact->timestamps = false;

        $contact->save();
        return redirect('/iletisim')->with(['success' => true, 'swal' => true]);


        //    Mail::send('theme.page.iletisim', $data, function ($message) use ($data) {
        //      $message->from('    ', '    ');
        //     $message->to($data['email']);
        //      $message->subject('Mesajınız İletildi');
        //  });
    }

}
