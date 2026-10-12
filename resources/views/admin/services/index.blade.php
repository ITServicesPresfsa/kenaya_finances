@extends('layouts.admin')
@section('title', 'Services')
@section('heading', 'Services')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nouveau service</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Nom</th><th>Description</th><th>Statut</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse ($services as $service)
                    <tr>
                        <td class="fw-semibold">{{ $service->name }}</td>
                        <td class="text-muted">{{ \Illuminate\Support\Str::limit($service->description, 80) }}</td>
                        <td>
                            <span class="badge {{ $service->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $service->is_active ? 'Actif' : 'Désactivé' }}
                            </span>
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce service ?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Aucun service.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection