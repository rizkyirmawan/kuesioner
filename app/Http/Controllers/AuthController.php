<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Index
    public function index()
    {
    	return view('auth.auth');
    }

    // Login Handler
    public function login() 
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
    	$credentials = request()->only('email', 'password');

    	if(Auth::attempt($credentials)) {
    		return redirect()->route('dasbor');
    	} else {
    		return redirect('/')->with('error', 'Email atau password tidak cocok!');
    	}
    }

    // Logout Handler
    public function logout()
    {
    	Auth::logout();

    	return redirect('/');
    }
}
