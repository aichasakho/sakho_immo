<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Méthode pour bloquer un utilisateur
     */
    public function bloquer($id)
    {
        $user = User::findOrFail($id);
        $user->est_bloque = true;
        $user->save();
        return response()->json($user, 200);
    }
    /**
     * Méthode pour débloquer un utilisateur
     */
    public function debloquer($id)
    {
        $user = User::findOrFail($id);
        $user->est_bloque = false;
        $user->save();
        return response()->json($user, 200);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
