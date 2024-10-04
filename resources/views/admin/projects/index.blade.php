@extends('layouts.app')

@section('content')

    <h1>Lista dei progetti</h1>

    <!-- Pulsante per creare un nuovo progetto -->
    <a href="{{ route('projects.create') }}" class="btn btn-primary">Crea nuovo progetto</a>

    <ul>
        @foreach ($projects as $project)
            <li>
                {{ $project->title }}

                <!-- Pulsante per modificare il progetto corrente -->
                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning">Modifica</a>

                <!-- Pulsante per eliminare il progetto corrente -->
                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Elimina</button>
                </form>
            </li>
        @endforeach
    </ul>

@endsection
