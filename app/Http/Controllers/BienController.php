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
<<<<<<< HEAD
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $data = $request->only('titre', 'description', 'prix', 'disponible', 'type');

=======
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Exemple de validation
        ]);

>>>>>>> 7a929f142c0fa72b7766e2ace77cb68096b6e904
        // Traitement de l'image
        if ($request->hasFile('image')) {
            $data['imagePath'] = $request->file('image')->store('images', 'public');
        }

        // Créer le bien
<<<<<<< HEAD
        $bien = Bien::create($data);
        return response()->json($bien, 201);
    }

=======
        Bien::create($data);
        return response()->json($data, 201);
    }


>>>>>>> 7a929f142c0fa72b7766e2ace77cb68096b6e904
    public function show(Bien $bien) {
        return $bien;
    }

<<<<<<< HEAD
    public function update(Request $request, $id)
    {
        $bien = Bien::find($id);
        if (!$bien) {
            return response()->json(['message' => 'Bien non trouvé'], 404);
        }

        $bien->titre = $request->input('titre');
        $bien->description = $request->input('description');
        $bien->prix = $request->input('prix');
        $bien->disponible = $request->input('disponible') == '1';
        $bien->type = $request->input('type');

        // Si une image est envoyée, vous devrez la gérer ici.
        if ($request->hasFile('imagePath')) {
            $file = $request->file('imagePath');
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
=======
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
>>>>>>> 7a929f142c0fa72b7766e2ace77cb68096b6e904
}
