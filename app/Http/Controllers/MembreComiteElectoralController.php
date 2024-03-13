<?php

namespace App\Http\Controllers;

use App\Models\ComiteElectoral;
use App\Models\MembreComiteElectoral;
use Illuminate\Http\Request;

class MembreComiteElectoralController extends Controller
{
    const ROLES = [
        "Coordonnateur",
        "Adjoint au coordonnateur",
        "Secrétaire Général",
        "Secrétaire Général Adjoint",
        "Plénipotentiaire département",
        "Présidente des Femmes",
        "1ere Adjointe pdte des femmes",
        "Présidente des Amazones",
        "Adjointe pdte des Amazones",
        "Président des jeunes",
        "Adjoint pdt des jeunes",
        "Chargé des élections",
        "Trésorier",
        "Adjoint trésorier",
        "Commissaire aux comptes",
        "Pdt Commission d’organisation",
        "Adjoint Pdt Com d’organisation",
        "Chargé de la logistique",
        "Pdt Commission Sécurité",
        "Pdt cellule Communication",
        "Adjoint cellule Communication",
        "Président du Comité des Sages",
        "Porte-parole"];

    //
    public function store(ComiteElectoral $comiteElectoral, Request $request){

        $membreComiteElectoral =  new MembreComiteElectoral($request->validate([
            "prenom" => "required|string",
            "nom" => "required|string",
            "telephone" => "required|string",
            "sexe" => "required|string",
            "nin" => "string|unique:membre_comite_electorals,nin",
            "commune" => "required|string",
//            "type_membre_id" => "required|exists:type_membres,id",
            "comite_role_id" => "required|exists:comite_roles,id",
        ], [
            "nin.unique" => "Ce numéro NIN est déjà utilisé par un autre membre du comité électoral."
        ]));
        $membreComiteElectoral->comiteElectoral()->associate($comiteElectoral);
        $membreComiteElectoral->save();
        return  $membreComiteElectoral;
    }

    public function show(MembreComiteElectoral $membreComiteElectoral)
    {
        return $membreComiteElectoral;
    }
    public function update(Request $request, MembreComiteElectoral $membre)
    {
        $membre->update($request->validate([
            "comite_electoral_id" => "exists:comite_electorals,id",
            "prenom" => "string",
            "nom" => "string",
            "telephone" => "string",
            "sexe" => "string",
            "nin" => "string|unique:membre_comite_electorals,nin," . $membre->id,
            "commune" => "string",
            "objectif" => "integer",
            "comite_role_id" => "required|exists:comite_roles,id",
            "type_membre_id" => "exists:type_membres,id",
        ]));
        return $membre;
    }
    public function delete(MembreComiteElectoral $membreComiteElectoral)
    {
        $membreComiteElectoral->delete();
        return response(null, 204);
    }
    public function getMembresComiteElectoral()
    {
        return MembreComiteElectoral::all();
    }
    public function assignerObjectif(MembreComiteElectoral $membre, Request$request)
    {
        $membre->update($request->validate([
            "objectif" => "required|integer"
        ]));
        return $membre;
    }
}
