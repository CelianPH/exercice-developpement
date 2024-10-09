<?php

namespace App\Http\Controllers;

use App\Models\Encart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

    // 3. Stocker un nouvel encart. 
    public function store(Request $request)
    {
    
        $validatedData = $request->validate([
            'Référence' => 'required|string|max:255',
            'image_bannière' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'tags' => 'nullable|string',
        ]);

        
        if ($request->hasFile('image_bannière')) {
            $imagePath = $request->file('image_bannière')->store('images', 'public'); 
        }

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
}
