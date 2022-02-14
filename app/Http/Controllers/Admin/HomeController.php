<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendWelcomeEmail;

class HomeController extends Controller
{
    //admin homepage
    public function index() {
        // invio email
        Mail::to(Auth::user()->email)->send(new SendWelcomeEmail(Auth::user()->name));






        return view('admin.home');


    }
}
