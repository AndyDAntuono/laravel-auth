@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifica Progetto</h1>

    <!-- mostra errori di validazione -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form per modificare il progetto -->
    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- metodo HTTP PUT per aggiornare -->

        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $project->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Descrizione</label>
            <textarea name="description" class="form-control" id="description" rows="3" required>{{ old('description', $project->description) }}" </textarea>
        </div>

        <button type="submit" class="btn btn-primary">Salva modifiche</button>
    </form>
</div>
@endsection