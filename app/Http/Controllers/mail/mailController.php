<?php

namespace App\Http\Controllers\Mail;


use App\Http\Controllers\Controller;

use App\Mail\InterviewOnlineMail;
use App\Mail\InterviewOfflineMail;
use App\Mail\psikotesMail;
use App\Mail\tesKepribadianMail;
use App\Mail\MedicalCheckUpMail;
use App\Mail\OfferingLetterMail;
use App\Mail\RejectedMail;
use App\Mail\AcceptedHOMail;
use App\Mail\AcceptedKpwMail;



use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


use App\Models\User;

class MailController extends Controller
{
    public function index()
    {
        return view('mail.index');
    }

    public function sendEmail(Request $request)
    {


        $data = user::where('id', $request->user_id);
        dd($data);
        // $emailType = $data->emailType;

        // switch ($emailType) {
        //     case 'interviewOnline':
        //         return $this->interviewOnlineMail($data);
        //     case 'interviewOffline':
        //         return $this->interviewOfflineMail($data);
        //     case 'rejected':
        //         return $this->rejectedMail($data);
        //     case 'acceptedHO':
        //         return $this->acceptedHOMail($data);
        //     case 'acceptedKpw':
        //         return $this->acceptedKpwMail($data);
        //     default:
        //         return response()->json(['message' => 'Invalid email type'], 400);
        // }
    }
    

    public function interviewOnlineMail(request $data)
    {
        $name = $data->name;
        $email = $data->email;
        $date = $data->date;
        $time = $data->time;
        $link = $data->link;

        Mail::to($email)->send(new InterviewOnlineMail(
            $name,
            $email,
            $date,
            $time,
            $link
        ));

        return response()->json(['message' => 'Email sent successfully']);
    }

    public function interviewOfflineMail(request $data)
    {
        $name = $data->name;
        $email = $data->email;
        $date = $data->date;
        $time = $data->time;
        $place = $data->place;

        
        Mail::to($email)->send(new InterviewOfflineMail(
            $name,
            $email,
            $date,
            $time,
            $place
        ));

        return response()->json(['message' => 'Email sent successfully']);
    }

    public function rejectedMail($data)
    {
        $name = $data->name;
        $email = $data->email;

        Mail::to($email)->send(new RejectedMail(
            $name,
            $email
        ));

        return response()->json(['message' => 'Email sent successfully']);
    }

    public function acceptedHOMail($data)
    {
        $name = $data->name;
        $email = $data->email;

        Mail::to($email)->send(new AcceptedHOMail(
            $name,
            $email
        ));

        return response()->json(['message' => 'Email sent successfully']);
    }

    public function acceptedKpwMail($data)
    {
        $name = $data->name;
        $email = $data->email;

        Mail::to($email)->send(new AcceptedKpwMail(
            $name,
            $email
        ));

        return response()->json(['message' => 'Email sent successfully']);
    }   

    
}
