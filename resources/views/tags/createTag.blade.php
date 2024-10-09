@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter un Tag</h2>

    <form action="{{ route('tags.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nom du Tag</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Ajouter le Tag</button>
    </form>
</div>
@endsection
