@extends('layouts.app')

@section('content')
    <h1>Lista dei progetti</h1>

    <a href="{{ route('projects.create') }}" class="btn btn-primary">Crea nuovo progetto</a>

    <ul>
        @foreach ($projects as $project)
            <li>{{ $project->title }}</li>
        @endforeach
    </ul>
@endsection
