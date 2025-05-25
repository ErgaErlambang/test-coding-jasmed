<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use Exception, Validator, DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function signin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "username" => "required",
                "password" => "required"
            ]);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $remember = isset($request->remember) ? true : false;
            $validated = $validator->validated();

            if(Auth::attempt($validated, $remember)) {
                return redirect()->route('dashboard');
            }

            return redirect()->back()->with("error", "Username or password is incorrect")->withInput();
            
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();

        return redirect()->route('login');
    }
}