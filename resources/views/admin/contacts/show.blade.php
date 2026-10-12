@extends('layouts.admin')
@section('title', 'Message')
@section('heading', 'Détail du message')

@section('content')
@php $treated = (bool) ($contact->is_treated ?? $contact->treated_at ?? false); @endphp
<div class="card border-0 shadow-sm"><div class="card-body">
    <h2 class="h5 fw-bold">{{ $contact->subject }}</h2>
    <dl class="row mb-4">
        <dt class="col-sm-3">Nom</dt><dd class="col-sm-9">{{ $contact->name }}</dd>
        <dt class="col-sm-3">E-mail</dt><dd class="col-sm-9"><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></dd>
        <dt class="col-sm-3">Téléphone</dt><dd class="col-sm-9">{{ $contact->phone ?: '—' }}</dd>
        <dt class="col-sm-3">Reçu le</dt><dd class="col-sm-9">{{ $contact->created_at->translatedFormat('d F Y à H:i') }}</dd>
        <dt class="col-sm-3">Statut</dt>
        <dd class="col-sm-9"><span class="badge {{ $treated ? 'bg-success' : 'bg-warning text-dark' }}">{{ $treated ? 'Traité' : 'À traiter' }}</span></dd>
    </dl>
    <div class="p-3 bg-light rounded mb-4" style="white-space:pre-wrap">{{ $contact->message }}</div>

    <div class="d-flex flex-wrap gap-2">
        <a href="mailto:{{ $contact->email }}?subject=Re: {{ rawurlencode($contact->subject) }}" class="btn btn-blue">
            <i class="bi bi-reply me-1"></i>Répondre par e-mail
        </a>
        @unless ($treated)
            <form action="{{ route('admin.contacts.treat', $contact) }}" method="POST">
                @csrf @method('PATCH')
                <button class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i>Marquer comme traité</button>
            </form>
        @endunless
        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
              onsubmit="return confirm('Supprimer ce message ?');">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger"><i class="bi bi-trash me-1"></i>Supprimer</button>
        </form>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary ms-auto">Retour</a>
    </div>
</div></div>
@endsection