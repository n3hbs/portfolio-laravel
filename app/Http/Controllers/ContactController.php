<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|min:2',
            'email'   => 'required|email',
            'message' => 'required|string|min:10',
        ]);

        Mail::raw("From: {$validated['name']} ({$validated['email']})\n\nMessage:\n{$validated['message']}", function ($message) use ($validated) {
            $message->to(env('MAIL_TO_ADDRESS', 'bhnsgrl20@gmail.com'))
                ->replyTo($validated['email'], $validated['name'])
                ->subject("Portfolio Inquiry from {$validated['name']}");
        });

        return response()->json([
            'status'  => 200,
            'message' => 'Message successfully sent!',
            'payload' => [
                'sender'   => $validated['name'],
                'reply_to' => $validated['email'],
            ]
        ], 200);
    }
}
