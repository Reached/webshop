<?php

namespace App\Http\Controllers;

use App\Events\OrderWasApproved;
use App\Order;
use Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;
use Twilio;

class AdminController extends Controller
{
    public function showDashboard() {
        return view('backend.dashboard');
    }
}
