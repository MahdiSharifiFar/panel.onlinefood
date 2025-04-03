<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index()
    {
        $messages = ContactUs::all()->reverse();
        return view('contact.index' , compact('messages'));
    }

    public function delete(ContactUs $contact)
    {
        $contact->delete();
        return redirect()->route('contact.index')->with(['success' => 'پیام مورد نظر با موفقیت حذف شد']);
    }
}
