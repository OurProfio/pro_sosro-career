<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Job;

class GuestController extends Controller
{
    public function index() {
        Job::where('status', 'aktif')
            ->whereDate('closing_date', '<', today())
            ->update(['status' => 'nonaktif']);

        $jobs = Job::all();

        return view('guest.index', compact('jobs'));
    }
}
