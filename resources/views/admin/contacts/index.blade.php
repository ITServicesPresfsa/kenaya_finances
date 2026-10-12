@extends('layouts.admin')
@section('title', 'Messages')
@section('heading', 'Messages de contact')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Date</th><th>De</th><th>Sujet</th><th>Statut</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse ($messages as $msg)
                    @php $treated = (bool) ($msg->is_treated ?? $msg->treated_at ?? false); @endphp
                    <tr class="{{ $treated ? '' : 'fw-semibold' }}">
                        <td class="text-nowrap">{{ $msg->created_at->translatedFormat('d/m/Y H:i') }}</td>
                        <td>{{ $msg->name }}<div class="small text-muted fw-normal">{{ $msg->email }}</div></td>
                        <td>{{ \Illuminate\Support\Str::limit($msg->subject, 50) }}</td>
                        <td><span class="badge {{ $treated ? 'bg-success' : 'bg-warning text-dark' }}">{{ $treated ? 'Traité' : 'À traiter' }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.contacts.show', $msg) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                            <form action="{{ route('admin.contacts.destroy', $msg) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce message ?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Aucun message reçu.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if ($messages instanceof \Illuminate\Pagination\AbstractPaginator)
    <div class="mt-3">{{ $messages->links() }}</div>
@endif
@endsection