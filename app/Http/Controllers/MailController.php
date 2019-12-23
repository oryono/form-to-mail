<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MailOutService;

class MailController extends Controller
{
    /**
     * @var MailOutService
     */
    private $mailOutService;

    public function __construct(MailOutService $mailOutService)
    {
        $this->mailOutService = $mailOutService;
    }

    public function send(Request $request)
    {
        $redirect_to = $request->redirect_to;
//        dd($redirect_to);
        $sender_name = $request->sender_name;
        $sender_email = $request->sender_email;
        $sender = ['name' => $sender_name, 'email' => $sender_email];

        $receipient_name = $request->receipient_name;
        $receipient_email = $request->receipient_email;

        $receipient = ['name' => $receipient_name, 'email' => $receipient_email];
        $message = $request->message;
        $subject = $request->subject;
        $replyTo = ['name' => $request->reply_to_name, 'email' => $request->reply_to_email];


        try {
            $this->mailOutService->send($subject, $message, $receipient, $sender, '', '', $replyTo);
        }catch (\Exception $exception) {
            return response()->json(['message' => "Something went wrong ".$exception->getMessage()]);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Successful']);
        }

        return $redirect_to ? redirect()->to($redirect_to) : redirect('success');

    }
}
