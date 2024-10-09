<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    // Afficher la liste des tags
    public function index()
    {
        $tags = Tag::all();
        return view('tags.tag', compact('tags'));
    }

    // Afficher le formulaire pour créer un nouveau tag
    public function create()
    {
        return view('tags.createTag');  // Changer ici
    }

    // Stocker un nouveau tag
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Tag::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag créé avec succès !');
    }

    // Supprimer un tag
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'Tag supprimé avec succès !');
    }
}
