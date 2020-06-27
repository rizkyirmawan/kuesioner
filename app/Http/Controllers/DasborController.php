<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DasborController extends Controller
{
    // Index
    public function index()
    {
    	$title = 'Dasbor';

    	return view('auth.dasbor', compact('title'));
    }
}
