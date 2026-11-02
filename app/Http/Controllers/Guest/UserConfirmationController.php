<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserConfirmationController extends Controller
{
    public function show(string $token): View
    {
        abort(404);
    }

    public function update(Request $request, string $token): RedirectResponse
    {
        abort(404);
    }
}
