<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\psikotesMail;
use App\Mail\tesKepribadianMail;
use App\Mail\InterviewMail;
use App\Mail\Interview2Mail;
use App\Mail\MedicalCheckUpMail;
use App\Mail\OfferingLetterMail;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


class MailController extends Controller
{
    public function index()
    {
        return view('mail.index');
    }
    public function sendEmail(Request $request)
    {

        // dd();
        // Kirim email menggunakan Mailable
        $penerima = [
            'adiezraanthoni@gmail.com', 
            'alandriansuryatantra@gmail.com'];

        $mailables = [
            new psikotesMail(),
            new tesKepribadianMail(),
            new InterviewMail(),
            new Interview2Mail(),
            new MedicalCheckUpMail(),
            new OfferingLetterMail(),
        ];

        foreach ($mailables as $mailable) {
            Mail::to($penerima)->send($mailable);
        }

        return redirect()->route('email.index')->with('success', 'Email berhasil dikirim.');
    }
}
