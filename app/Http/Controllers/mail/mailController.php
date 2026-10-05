<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\psikotesMail;
use App\Mail\tesKepribadianMail;
use App\Mail\InterviewMail;
use App\Mail\Interview2Mail;
use App\Mail\MedicalCheckUpMail;
use App\Mail\OfferingLetterMail;
use App\Mail\RejectedMail;
use App\Mail\AcceptedHOMail;
use App\Mail\AcceptedKpwMail;

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
            // 'adiezraanthoni@gmail.com', 
            // 'alandriansuryatantra@gmail.com',
            'jasmine.balaw@sosro.com'
        ];

        $mailables = [
            new psikotesMail(),
            new tesKepribadianMail(),
            new InterviewMail(),
            new Interview2Mail(),
            new MedicalCheckUpMail(),
            new OfferingLetterMail(),
            new RejectedMail(),
            new AcceptedHOMail(),
            new AcceptedKpwMail()
        ];

        foreach ($mailables as $mailable) {
            Mail::to($penerima)->send($mailable);
        }

        return redirect()->route('email.index')->with('success', 'Email berhasil dikirim.');
    }
}
