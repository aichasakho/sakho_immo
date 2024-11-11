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
            'imagePath' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $data = $request->only('titre', 'description', 'prix', 'disponible', 'type');

        // Traitement de l'image
        if ($request->hasFile('imagePath')) {
            $data['imagePath'] = $request->file('imagePath')->store('images', 'public');
        }

        // Créer le bien
        $bien = Bien::create($data);
        return response()->json($bien, 201);
    }



    public function show(Bien $bien) {
        return $bien;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titre' => 'nullable|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'disponible' => 'boolean',
            'type' => 'required|string|in:appartement,studio,magasin,terrain,maison',
            'imagePath' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $bien = Bien::find($id);
        if (!$bien) {
            return response()->json(['message' => 'Bien non trouvé'], 404);
        }

        $bien->titre = $request->input('titre');
        $bien->description = $request->input('description');
        $bien->prix = $request->input('prix');
        $bien->disponible = $request->input('disponible') == '1';
        $bien->type = $request->input('type');

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('images', 'public');
            $bien->imagePath = $path; // Mettez à jour le chemin de l'image
        }

        $bien->save();

        return response()->json($bien, 200);
    }
    public function destroy($id)
    {
        $bien = Bien::find($id);
        if ($bien) {
            $bien->delete();
            return response()->json(['message' => 'Bien supprimé avec succès'], 200);
        } else {
            return response()->json(['message' => 'Bien non trouvé'], 404);
        }
    }

}
