<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('slider.index' , compact('sliders'));
    }

    public function create()
    {
        return view('slider.create');
    }

    public function edit(Slider $slider)
    {

        return view('slider.edit', compact('slider'));
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('slider.index')->with(['warning' => 'اسلایدر با موفقیت حذف شد']);
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'link_title' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $slider->update([
            'title' => $request['title'],
            'content' => $request['body'],
            'link_title' => $request['link_title'],
            'link' => $request['link'],
        ]);

        return redirect()->route('slider.index')->with('success', 'اسلایدر با موفقیت ویرایش شد');

    }

    public function store(Request $request)
    {
        $request->validate([
           'title' => 'required|string',
           'link' => 'required|string',
           'link_title' => 'required|string',
           'body' => 'required|string',
        ]);

        Slider::create([
            'title' => $request['title'],
            'link' => $request['link'],
            'link_title' => $request['link_title'],
            'content' => $request['body'],
        ]);

        return redirect()->route('slider.index')->with('success', 'اسلایدر با موفقیت ایجاد شد');
    }

}
