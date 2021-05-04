<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CMIController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function success() {
        return view('success');
    }

    public function failure() {
        return view('failure');
    }
}
