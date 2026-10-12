<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('pages.contact');
    }

    // public function store(Request $request): RedirectResponse
    // {
    //     // Rate limiting: max 3 submissions per 10 minutes per IP
    //     $key = 'contact:'.$request->ip();
    //     if (RateLimiter::tooManyAttempts($key, 3)) {
    //         $seconds = RateLimiter::availableIn($key);

    //         return back()
    //             ->withInput()
    //             ->with('error', "Trop de tentatives. Réessayez dans {$seconds} secondes.");
    //     }
    //     RateLimiter::hit($key, 600);

    //     $validated = $request->validate([
    //         'first_name' => ['required', 'string', 'max:100'],
    //         'last_name' => ['required', 'string', 'max:100'],
    //         'email' => ['required', 'email', 'max:255'],
    //         'phone' => ['nullable', 'string', 'max:30'],
    //         'subject' => ['required', 'string', 'max:200'],
    //         'message' => ['required', 'string', 'min:20', 'max:3000'],
    //     ], [
    //         'first_name.required' => 'Le prénom est obligatoire.',
    //         'last_name.required' => 'Le nom est obligatoire.',
    //         'email.required' => 'L\'adresse e-mail est obligatoire.',
    //         'email.email' => 'Veuillez saisir une adresse e-mail valide.',
    //         'subject.required' => 'Le sujet est obligatoire.',
    //         'message.required' => 'Le message est obligatoire.',
    //         'message.min' => 'Le message doit contenir au moins 20 caractères.',
    //     ]);

    //     $message = ContactMessage::create([
    //         ...$validated,
    //         'ip_address' => $request->ip(),
    //     ]);

    //     // Try to send email notification (fail gracefully)
    //     try {
    //         $notifEmail = Setting::get('notification_email', config('mail.from.address'));
    //         // Mail::to($notifEmail)->send(new \App\Mail\ContactNotification($message));
    //     } catch (\Exception $e) {
    //         Log::warning('Contact email failed: '.$e->getMessage());
    //     }

    //     return back()->with('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
    // }

    public function store(Request $request): RedirectResponse
{
    $key = 'contact:'.$request->ip();

    if (RateLimiter::tooManyAttempts($key, 3)) {
        $minutes = (int) ceil(RateLimiter::availableIn($key) / 60);

        return back()
            ->withInput()
            ->with('error', "Vous avez envoyé plusieurs messages à la suite. Réessayez dans {$minutes} minute(s).");
    }

    $validated = $request->validate([
        'first_name' => ['required', 'string', 'max:100'],
        'last_name' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:255'],
        'phone' => ['nullable', 'string', 'max:30'],
        'subject' => ['required', 'string', 'max:200'],
        'message' => ['required', 'string', 'min:20', 'max:3000'],
    ], [
        'first_name.required' => 'Le prénom est obligatoire.',
        'last_name.required' => 'Le nom est obligatoire.',
        'email.required' => 'L\'adresse e-mail est obligatoire.',
        'email.email' => 'Veuillez saisir une adresse e-mail valide.',
        'subject.required' => 'Le sujet est obligatoire.',
        'message.required' => 'Le message est obligatoire.',
        'message.min' => 'Le message doit contenir au moins 20 caractères.',
    ]);

    $message = ContactMessage::create([
        ...$validated,
        'ip_address' => $request->ip(),
    ]);

    // On ne compte que les messages réellement enregistrés
    RateLimiter::hit($key, 600);

    // Notification par e-mail (échec toléré, le message est déjà enregistré)
    try {
        $notifEmail = Setting::get('notification_email', config('mail.from.address'));
        // Mail::to($notifEmail)->send(new \App\Mail\ContactNotification($message));
    } catch (\Throwable $e) {
        Log::warning('Contact email failed: '.$e->getMessage());
    }

    return back()->with('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
}
}
