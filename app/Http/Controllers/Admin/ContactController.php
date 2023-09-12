<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarbonSubmit;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return view('admin.Contact.index', compact('contacts'));
    }
    public function create()
    {
        return view('admin.Contact.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);
        $contact = new Contact();
        $contact->address = $request->address;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->save();
        return redirect()->route('contact.index');
    }

    public function delete($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return redirect()->route('admin.Contact.index');
    }
    public function deleteCarbon($id)
    {
        $CarbonSubmits = CarbonSubmit::find($id);
        $CarbonSubmits->delete();
        return redirect()->route('admin.ContactCarbon');
    }
    public function ContactCarbon()
    {

        $CarbonSubmits = CarbonSubmit::all();
        return view('admin.CarbonContact.index', compact('CarbonSubmits'));

    }
}
