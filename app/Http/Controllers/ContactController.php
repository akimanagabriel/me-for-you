<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Handle contact form submission.
     */
    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
        ]);

        // Log the contact submission
        Log::info('Contact form submission', [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? 'General Enquiry',
            'message' => $validated['message'],
        ]);

        // You can also send an email notification
        // Uncomment this when you have mail configured
        // try {
        //     Mail::send('emails.contact', $validated, function ($mail) use ($validated) {
        //         $mail->to('info@me-for-you.org')
        //             ->subject('New Contact Form Submission: ' . ($validated['subject'] ?? 'General Enquiry'))
        //             ->replyTo($validated['email'], $validated['name']);
        //     });
        // } catch (\Exception $e) {
        //     Log::error('Failed to send contact email: ' . $e->getMessage());
        // }

        return redirect()
            ->route('contact')
            ->with('success', 'Thank you for your message! We will get back to you shortly.');
    }
}