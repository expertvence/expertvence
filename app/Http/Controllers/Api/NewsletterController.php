<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterWelcomeMail;
use App\Mail\NewSubscriberNotificationMail;

class NewsletterController extends Controller
{
   public function subscribe(Request $request)
{
    $request->validate([
        'name' => 'nullable|string|max:255',
        'email' => 'required|email|unique:newsletter_subscribers,email',
    ]);

    $subscriber = NewsletterSubscriber::create([
        'name' => $request->name ?? 'Subscriber',
        'email' => $request->email
    ]);

    Mail::to($subscriber->email)
        ->send(new NewsletterWelcomeMail($subscriber));

    Mail::to('mofazzal.dv@gmail.com')
        ->send(new NewSubscriberNotificationMail($subscriber));

    return response()->json(['message' => 'Subscribed successfully']);
}

}
