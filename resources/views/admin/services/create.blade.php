@extends('layouts.admin')
@section('title', 'Nouveau service')
@section('heading', 'Nouveau service')

@section('content')
<form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.services._form')
</form>
@endsection