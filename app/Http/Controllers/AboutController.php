<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    function index()
    {
        $about = About::first();
        return view('about.index' , compact('about'));
    }

    function edit(About $about)
    {
        return view('about.edit' , compact('about'));
    }

    function update(Request $request, About $about)
    {
        $request->validate([
           'title' => 'required|string|max:255',
           'body' => 'required|string',
           'link' => 'required|string',
        ]);

        $about->update([
            'title' => $request['title'],
            'description' => $request['body'],
            'link' => $request['link'],
        ]);

        return redirect()->route('about.index')->with(['success' => 'بخش درباره ما با موفقیت ویرایش شد']);

    }

}
