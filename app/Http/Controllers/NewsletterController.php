<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $newsletter = Newsletter::where('email', $request->email)->first();

        if ($newsletter) {
            if (!$newsletter->is_subscribed) {
                $newsletter->update(['is_subscribed' => true]);
                return back()->with('success', 'You have been re-subscribed to our newsletter!');
            }
            return back()->with('info', 'You are already subscribed to our newsletter.');
        }

        Newsletter::create([
            'email' => $request->email,
            'is_subscribed' => true
        ]);

        return back()->with('success', 'Thank you for subscribing to our newsletter!');
    }
}
