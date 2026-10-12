@extends('layouts.admin')
@section('title', 'Paramètres')
@section('heading', 'Paramètres du site')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf @method('PUT')
    <div class="card border-0 shadow-sm"><div class="card-body">
        @forelse ($settings as $key => $value)
            <div class="mb-3">
                <label for="s-{{ $key }}" class="form-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                @if (strlen((string) $value) > 80)
                    <textarea id="s-{{ $key }}" name="{{ $key }}" rows="3" class="form-control">{{ old($key, $value) }}</textarea>
                @else
                    <input type="text" id="s-{{ $key }}" name="{{ $key }}" value="{{ old($key, $value) }}" class="form-control">
                @endif
            </div>
        @empty
            <p class="text-muted mb-0">Aucun paramètre défini.</p>
        @endforelse
    </div></div>
    <button type="submit" class="btn btn-primary mt-4"><i class="bi bi-check-lg me-1"></i>Enregistrer</button>
</form>
@endsection