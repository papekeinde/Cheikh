<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\Contact;
use App\Models\Projet;
use App\Models\User;
use Illuminate\Http\Request;

class VitrineController extends Controller
{
    /**
     * Affiche la page d'accueil de la vitrine
     */
    public function index()
    {
        // Récupère l'utilisateur principal (le propriétaire du portfolio)
        $user = User::first();

        // Récupère les compétences
        $competences = Competence::all();

        // Récupère les projets avec leur catégorie
        $projets = Projet::with('categorie')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.vitrine.index', compact(
            'user',
            'competences',
            'projets'
        ));
    }

    /**
     * Enregistre un message de contact
     */
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'sujet' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Votre message a été envoyé avec succès!');
    }
}
