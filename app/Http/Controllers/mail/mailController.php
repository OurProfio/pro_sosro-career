<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MailController extends Controller
{
    public function index(): View
    {
        return view('mail.index');
    }
}
