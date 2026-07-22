<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactInquiryMail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($validated);

        try {
            // Send email to admin
            Mail::to('admin@sricrackers.com')->send(new ContactInquiryMail($contact));
        } catch (\Exception $e) {
            // Log the error but don't stop the user experience since SMTP might not be configured
            Log::error('Failed to send contact inquiry email: ' . $e->getMessage());
        }

        return back()->with('success', 'Thank you for reaching out! We have received your message and will get back to you shortly.');
    }
}
