<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::all();
        return view('feature.index' , compact('features'));
    }

    public function create()
    {
        return view('feature.create');
    }

    public function edit(Feature $feature)
    {

        return view('feature.edit', compact('feature'));
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        return redirect()->route('feature.index')->with(['warning' => 'ویژگی با موفقیت حذف شد']);
    }

    public function update(Request $request, Feature $feature)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $feature->update([
            'title' => $request['title'],
            'icon' => $request['icon'],
            'body' => $request['body'],
        ]);

        return redirect()->route('feature.index')->with('success', 'ویژگی با موفقیت ویرایش شد');

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'icon' => 'required|string',
            'body' => 'required|string',
        ]);

        Feature::create([
            'title' => $request['title'],
            'icon' => $request['icon'],
            'body' => $request['body'],
        ]);

        return redirect()->route('feature.index')->with('success', 'ویژگی با موفقیت ایجاد شد');
    }

}
