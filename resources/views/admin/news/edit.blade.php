@extends('layouts.admin')
@section('title', 'Modifier l\'article')
@section('heading', 'Modifier l\'article')

@section('content')
<form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.news._form')
</form>
@endsection