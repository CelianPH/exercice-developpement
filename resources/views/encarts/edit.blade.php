@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier l'encart</h2>

    <form action="{{ route('encarts.update', $encart->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="Référence">Référence</label>
            <input type="text" name="Référence" class="form-control" value="{{ $encart->Référence }}" required>
        </div>

        <div class="form-group">
            <label for="image_bannière">Image Bannière</label>
            <input type="file" name="image_bannière" class="form-control">
            <small>Image actuelle: <img src="{{ asset('storage/' . $encart->image_bannière) }}" width="100" alt="Bannière"></small>
        </div>

        <div class="form-group">
            <label for="date_debut">Date de Début</label>
            <input type="date" name="date_debut" class="form-control" value="{{ $encart->date_debut }}" required>
        </div>

        <div class="form-group">
            <label for="date_fin">Date de Fin</label>
            <input type="date" name="date_fin" class="form-control" value="{{ $encart->date_fin }}" required>
        </div>

        <div class="form-group">
            <label>Tags</label><br>
            @foreach($tags as $tag)
                <div class="form-check">
                    <input 
                        type="checkbox" 
                        class="form-check-input" 
                        name="tags[]" 
                        id="tag_{{ $tag->id }}" 
                        value="{{ $tag->id }}"
                    >
                    <label class="form-check-label" for="tag_{{ $tag->id }}">
                        {{ $tag->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour l'encart</button>
    </form>
</div>
@endsection
