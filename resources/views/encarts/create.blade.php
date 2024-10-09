@extends('layouts.app')


@section('content')
<div class="container">
    <h2>Créer un nouvel encart publicitaires</h2>


    <form action="{{ route('encarts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="Référence">Référence</label>
            <input type="text" name="Référence" class="form-control" value="{{ old('Référence') }}" required>
        </div>

        <div class="form-group">
            <label for="image_bannière">Image de la bannière (1000x250px)</label>
            <input type="file" name="image_bannière" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="date_debut">Date de début</label>
            <input type="date" name="date_debut" class="form-control" value="{{ old('date_debut') }}" required>
        </div>

        <div class="form-group">
            <label for="date_fin">Date de fin</label>
            <input type="date" name="date_fin" class="form-control" value="{{ old('date_fin') }}" required>
        </div>

        <div class="form-group">
            <label for="tags">Tags (facultatif)</label>
            <input type="text" name="tags" class="form-control" placeholder="artisan, commerce, etc">
        </div>

        <button type="submit" class="btn btn-primary">Créer l'encart</button>
    </form>

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</div>
@endsection
