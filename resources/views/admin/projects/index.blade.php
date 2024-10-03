<!-- resources/views/admin/projects/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Progetti</h1>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">Crea nuovo progetto</a>

    <ul>
        @foreach ($projects as $project)
            <li><a href="{{ route('admin.projects.show', $project->id) }}">{{ $project->title }}</a></li>
        @endforeach
    </ul>
@endsection
