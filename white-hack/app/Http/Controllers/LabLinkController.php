<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabTarget;

class LabLinkController extends Controller
{
    public function store(Request $req, LabTarget $target) {
        // TODO: générer un lien signé/JWT pour Guacamole / portail SSH.
        // Pour l’instant on simule.
        return back()->with('status', "Lien de connexion généré pour {$target->name} (placeholder).");
    }
}
