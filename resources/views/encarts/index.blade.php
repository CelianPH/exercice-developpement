@extends('layouts.app')

@section('title', 'Liste des encarts')

@section('content')
<div class="container">
    <h2>Liste des encarts publicitaires :</h2>

    <a href="{{ route('encarts.create') }}" class="btn btn-primary mb-3">Créer un nouvel encart</a>

    @if($encarts->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Référence</th>
                    <th>Image</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Tags</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($encarts as $encart)
                    <tr>
                        <td>{{ $encart->id }}</td>
                        <td>{{ $encart->Référence }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $encart->image_bannière) }}" width="100" alt="Bannière">
                        </td>
                        <td>{{ $encart->date_debut }}</td>
                        <td>{{ $encart->date_fin }}</td>
                        <td>{{ $encart->tags }}</td>
                        <td>
                            <form action="{{ route('encarts.destroy', $encart->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun encart disponible pour le moment.</p>
    @endif

    @if($encarts->count())
    <h2>Visuel des encarts :</h2>
    <br>
    @foreach($encartsVisuels as $encart)
    <div>
        <img src="{{ asset('storage/' . $encart->image_bannière) }}" alt="Bannière">
    </div>
    @endforeach
     @else
        <p>Aucun encart disponible pour le moment.</p>
    @endif
</div>
@endsection
