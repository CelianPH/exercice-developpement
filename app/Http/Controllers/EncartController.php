<?php

namespace App\Http\Controllers;

use App\Models\Encart;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class EncartController extends Controller
{
    // 1. Afficher la liste des encarts
    public function index()
    {
        $encarts = Encart::select('encarts.id', 'encarts.Référence', 'encarts.image_bannière', 'encarts.date_debut', 'encarts.date_fin')
        ->leftJoin('encart_tag', 'encarts.id', '=', 'encart_tag.encart_id')
        ->leftJoin('tags', 'encart_tag.tag_id', '=', 'tags.id')
        ->groupBy('encarts.id', 'encarts.Référence', 'encarts.image_bannière', 'encarts.date_debut', 'encarts.date_fin')
        ->addSelect(DB::raw('GROUP_CONCAT(tags.name SEPARATOR ", ") AS tags'))
        ->get();
        $encartsVisuels = Encart::where('date_fin', '>=', now())
                                ->where('date_debut', '<=', now())
                                ->get();
        return view('encarts.index', compact('encarts', 'encartsVisuels'));
    }

    // 2. Afficher le formulaire de création d'un encart
    public function create()
    {
        $tags = Tag::all();
        return view('encarts.create', compact('tags'));
    }

    // 3. Stocker un nouvel encart
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Référence' => 'required|string|max:255',
            'image_bannière' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:width=1000,height=250',
            'date_debut' => 'required|date',
            'date_fin' => [
                'required',
                'date',
                'after:date_debut',
                function ($attribute, $value, $fail) use ($request) {
                    $date_debut = strtotime($request->input('date_debut'));
                    $date_fin = strtotime($value);
                    if (($date_fin - $date_debut) < 7 * 24 * 60 * 60) {
                        $fail('La période doit être de minimum 1 semaine.');
                    }
                },
            ],
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ], [
            'Référence.required' => 'Le champ Référence est obligatoire.',
            'image_bannière.required' => 'L\'image est obligatoire.',
            'image_bannière.dimensions' => 'Les dimensions de l\'image doivent être de 1000x250 pixels.',
            'tags.required' => 'Veuillez sélectionner au moins un tag.',
        ]);     

        $imagePath = $request->file('image_bannière')->store('images', 'public');

        // Création de l'encart
        $encart = Encart::create([
            'Référence' => $validatedData['Référence'],
            'image_bannière' => $imagePath,
            'date_debut' => $validatedData['date_debut'],
            'date_fin' => $validatedData['date_fin'],
        ]);

        // Synchronisation des tags
        $encart->tags()->sync($validatedData['tags']);

        return redirect()->route('encarts.index')->with('success', 'Encart créé avec succès !');
    }

    // 4. Supprimer un encart
    public function destroy($id)
    {
        $encart = Encart::findOrFail($id);

        if ($encart->image_bannière) {
            Storage::disk('public')->delete($encart->image_bannière);
        }

        $encart->delete();

        return redirect()->route('encarts.index')->with('success', 'Encart supprimé avec succès.');
    }

    // 5. Afficher le formulaire de modification d'un encart
    public function edit($id)
    {
        $encart = Encart::findOrFail($id);
        $tags = Tag::all();
        return view('encarts.edit', compact('encart', 'tags'));
    }

    // 6. Mettre à jour un encart existant
    public function update(Request $request, $id)
    {
        $request->validate([
            'Référence' => 'required|string|max:255',
            'image_bannière' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:width=1000,height=250',
            'date_debut' => 'required|date',
            'date_fin' => [
                'required',
                'date',
                'after_or_equal:date_debut',
                function ($attribute, $value, $fail) use ($request) {
                    $date_debut = strtotime($request->input('date_debut'));
                    $date_fin = strtotime($value);
                    if (($date_fin - $date_debut) < 7 * 24 * 60 * 60) {
                        $fail('La période doit être de minimum 1 semaine.');
                    }
                },
            ],
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ], [
            'Référence.required' => 'Le champ Référence est obligatoire.',
            'image_bannière.required' => 'L\'image est obligatoire.',
            'image_bannière.dimensions' => 'Les dimensions de l\'image doivent être de 1000x250 pixels.',
            'tags.required' => 'Veuillez sélectionner au moins un tag.',
        ]); 

        $encart = Encart::findOrFail($id);
        $encart->Référence = $request->input('Référence');
        $encart->date_debut = $request->input('date_debut');
        $encart->date_fin = $request->input('date_fin');

        if ($request->hasFile('image_bannière')) {
            if ($encart->image_bannière) {
                Storage::disk('public')->delete($encart->image_bannière);
            }
            $encart->image_bannière = $request->file('image_bannière')->store('images', 'public');
        }

        $encart->save();

        // Synchronisation des tags
        $encart->tags()->sync($request->input('tags'));

        return redirect()->route('encarts.index')->with('success', 'Encart mis à jour avec succès.');
    }
}
