<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        $user = User::where('email' , $request['email'])->first();

        if(!$user)
        {
            return back()->withErrors(['email' => 'ایمیل وارد شده اشتباه است']);
        }

        if(!Hash::check($request['password'], $user->password))
        {
            return back()->withErrors(['password' => 'رمز عبور وارد شده اشتباه است']);
        }

        auth()->login($user , true);

        return redirect()->route('panel.home');

    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('auth.index');
    }

}
