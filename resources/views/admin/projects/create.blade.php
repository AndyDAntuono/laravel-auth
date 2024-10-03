@extends('layouts.app')

@section('content')
    <h1>Crea un nuovo progetto</h1>

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Descrizione</label>
            <textarea name="description" id="description" cols="30" rows="10" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn success">Salva progetto</button>
    </form>