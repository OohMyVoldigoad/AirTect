<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function showLoginPage(){
        return view('auth/login');
    }

    public function welcomePage(){
        return view("welcome");
    }

    public function dashboardAdmin(){
        return view("dashboardAdmin");
    }
}
