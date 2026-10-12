@extends('layouts.admin')
@section('title', 'Nouvel article')
@section('heading', 'Nouvel article')

@section('content')
<form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.news._form')
</form>
@endsection