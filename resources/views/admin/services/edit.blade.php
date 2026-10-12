@extends('layouts.admin')
@section('title', 'Modifier le service')
@section('heading', 'Modifier le service')

@section('content')
<form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.services._form')
</form>
@endsection