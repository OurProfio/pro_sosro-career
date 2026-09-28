<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index() {
        $jobs = Job::all();

        return view('guest.index', compact('jobs'));
    }
}
