<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use Illuminate\Http\Request;

class BienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return Bien::all();
    }

    public function store(Request $request) {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'disponible' => 'boolean',
            'type' => 'required|string|in:appartement,studio,magasin,terrain,maison',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Exemple de validation
        ]);

        // Traitement de l'image
        if ($request->hasFile('image')) {
            $data['imagePath'] = $request->file('image')->store('images', 'public');
        }

        // Créer le bien
        Bien::create($data);
        return response()->json($data, 201);
    }


    public function show(Bien $bien) {
        return $bien;
    }

    public function update(Request $request, Bien $bien)
    {
        $request->validate([
            'titre' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'prix' => 'sometimes|required|numeric',
            'disponible' => 'sometimes|boolean',
            'type' => 'sometimes|required|string|in:appartement,studio,magasin,terrain,maison',
            'image' => 'nullable|image|max:2048', // Validation pour l'image
        ]);

        $bien->update($request->all());

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $bien->imagePath = $path; // Enregistrer le chemin de l'image
            $bien->save();
        }

        return response()->json($bien, 200);
    }
}
