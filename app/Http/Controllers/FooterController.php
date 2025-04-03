<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        $footer = Footer::first();
        return view('footer.index' , compact('footer'));
    }

    public function edit(Footer $footer)
    {
        return view('footer.edit' , compact('footer'));
    }

    public function update(Request $request, Footer $footer)
    {
        $request->validate([
            'contact_address' => 'required|string',
            'contact_phone' => 'required|string',
            'contact_email' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
            'work_days' => 'required|string',
            'work_start_time' => 'required|string',
            'work_end_time' => 'required|string',
            'telegram_link' => 'string|nullable',
            'whatsapp_link' => 'string|nullable',
            'instagram_link' => 'string|nullable',
            'youtube_link' => 'string|nullable',
            'copyright' => 'required|string',
        ]);

        $footer->update([
            'contact_address' =>  $request['contact_address'],
            'contact_phone' =>  $request['contact_phone'],
            'contact_email' =>  $request['contact_email'],
            'title' =>  $request['title'],
            'body' =>  $request['body'],
            'work_days' =>  $request['work_days'],
            'work_start_time' =>  $request['work_start_time'],
            'work_end_time' =>  $request['work_end_time'],
            'telegram_link' =>  $request['telegram_link'],
            'whatsapp_link' =>  $request['whatsapp_link'],
            'instagram_link' =>  $request['instagram_link'],
            'youtube_link' =>  $request['youtube_link'],
            'copyright' =>  $request['copyright'],
        ]);

        return redirect()->route('footer.index')->with('success', 'تنظیمات بخش فوتر با موفقیت ویرایش شد');
    }

}
