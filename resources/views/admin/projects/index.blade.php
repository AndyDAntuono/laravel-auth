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

                <!-- Bottone per mostrare la modale -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $project->id }}">
                    Elimina
                </button>

                <!--modale-->
                <div class="modal fade" id="deleteModal{{ $project->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Conferma eliminazione</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Sei sicuro di voler elinare questo progetto?
                            </div>
                            <div class="mdal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Elimina</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

@endsection
