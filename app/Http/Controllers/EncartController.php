<?php

namespace App\Http\Controllers;

use App\Models\Encart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EncartController extends Controller
{
    // 1. Afficher la liste des encarts
    public function index()
    {
        $encarts = Encart::all();
        $encartsVisuels = Encart::where('date_fin', '>=', now())->get();
        return view('encarts.index', compact('encarts', 'encartsVisuels'));
    }

    // 2. Afficher le formulaire de création d'un encart
    public function create()
    {
        return view('encarts.create'); 
    }

    // 3. Stocker un nouvel encart
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Référence' => 'required|string|max:255',
            'image_bannière' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'tags' => 'nullable|string',
        ]);

        if ($request->hasFile('image_bannière')) {
            $imagePath = $request->file('image_bannière')->store('images', 'public'); 
        }

        // Création de l'encart
        Encart::create([
            'Référence' => $validatedData['Référence'],
            'image_bannière' => $imagePath,
            'date_debut' => $validatedData['date_debut'],
            'date_fin' => $validatedData['date_fin'],
            'tags' => $validatedData['tags'],
        ]);

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
        return view('encarts.edit', compact('encart'));
    }

    // 6. Mettre à jour un encart existant
    public function update(Request $request, $id)
    {
        $request->validate([
            'Référence' => 'required|string|max:255',
            'image_bannière' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'tags' => 'required|string',
        ]);

        $encart = Encart::findOrFail($id);
        $encart->Référence = $request->input('Référence');
        $encart->date_debut = $request->input('date_debut');
        $encart->date_fin = $request->input('date_fin');
        $encart->tags = $request->input('tags');

        if ($request->hasFile('image_bannière')) {
            if ($encart->image_bannière) {
                Storage::disk('public')->delete($encart->image_bannière);
            }
            $encart->image_bannière = $request->file('image_bannière')->store('images', 'public');
        }

        $encart->save();

        return redirect()->route('encarts.index')->with('success', 'Encart mis à jour avec succès.');
    }
}
