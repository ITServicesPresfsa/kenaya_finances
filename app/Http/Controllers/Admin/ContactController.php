<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        $query = ContactMessage::orderByDesc('created_at');

        if ($request->query('statut') === 'non_traite') {
            $query->untreated();
        } elseif ($request->query('statut') === 'traite') {
            $query->where('is_treated', true);
        }

        $messages = $query->paginate(20)->appends($request->query());

        return view('admin.contacts.index', compact('messages'));
    }

    public function show(ContactMessage $contact): View
    {
        return view('admin.contacts.show', compact('contact'));
    }

    public function markTreated(ContactMessage $contact): RedirectResponse
    {
        $contact->update(['is_treated' => ! $contact->is_treated]);
        $label = $contact->is_treated ? 'traité' : 'non traité';

        return back()->with('success', "Message marqué comme {$label}.");
    }

    public function destroy(ContactMessage $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message supprimé.');
    }
}
