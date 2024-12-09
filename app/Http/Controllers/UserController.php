<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user, 200);
    }
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

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();


        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['l\'email ou le mot de passe est incorrect'],
            ]);
        }


        if (!$user->statut) {
            throw ValidationException::withMessages([
                'email' => ['Votre compte est inactif. Si Vous venez de vous inscrire veuillez
        attendre votre compte est en cours d\'activation.'],
            ]);
        }

        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 200);
    }



    public function logout()
    {
        User::find(Auth::user()->id)->tokens()->delete();
        return response()->json(['message' => 'Logged out'], 200);
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
