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

        $bien = Bien::create($data);
        return response()->json($bien, 201);
    }

    public function show(Bien $bien) {
        return $bien;
    }

    public function update(Request $request, $id)
    {
        $bien = Bien::find($id);
        if (!$bien) {
            return response()->json(['message' => 'Bien non trouvé'], 404);
        }

        $request->validate([
            'titre' => 'required|string',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'type' => 'required|string',
            'imagePath' => 'nullable|image',
        ]);

        $bien->titre = $request->input('titre');
        $bien->description = $request->input('description');
        $bien->prix = $request->input('prix');
        $bien->disponible = $request->input('disponible', false);
        $bien->type = $request->input('type');

        if ($request->hasFile('imagePath')) {
            $imagePath = $request->file('imagePath')->store('images');
            $bien->imagePath = $imagePath;
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



    public function appeler(Request $request, Bien $bien)
    {
        // Récupérer les informations nécessaires (agent, coordonnées de l'utilisateur, etc.)
        $agent = $bien->agent;
        $utilisateur = [
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone')
        ];

        // Envoyer un email à l'agent
        Mail::to($agent->email)->send(new AppelBien($bien, $utilisateur));

        return response()->json(['message' => 'Demande d\'appel envoyée avec succès']);}

    public function contacter(Request $request, Bien $bien)
    {

        // Créer un nouvel enregistrement de contact
        $contact = Contact::create([
            'bien_id' => $bien->id,
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'message' => $request->input('message')
        ]);

        return response()->json(['message' => 'Demande de contact envoyée avec succès']);}



}
