<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Plenipot;
use Illuminate\Http\Request;

class PlenipotController extends Controller
{
    //
    public function index()
    {
        return Departement::all()->map(function (Departement $departement){
            return [$departement->nom=>$departement->plenipots()->get()];
        });

    }

    public function store(Request $request)
    {
       $data = $request->validate([
            "prenom" => "required|string",
            "nom" => "required|string",
            "telephone"=> "required|integer|unique:plenipots,telephone",
            "nin" => "required|unique:plenipots,nin",
            "departement"=> "required|exists:departements,nom",
            "arrondissement" => "string|unique:plenipots,arrondissement",
        ], [
            "telephone.unique" => "Ce numéro de téléphone est déjà utilisé par un autre plénipotentiaire.",
            "nin.unique" => "Ce numéro NIN est déjà utilisé par un autre plénipotentiaire.",
            "num_electeur.unique" => "Ce numéro d'électeur est déjà utilisé par un autre plénipotentiaire.",
            "arrondissement.unique" => "Ce plénipotentiaire est déjà enregistré pour cet arrondissement."
        ]);
        $departement = Departement::whereNom($data['departement'])->firstOrFail();
        $plenipot = new Plenipot($data);
        $departement->plenipots()->save($plenipot);
    }

    public function show(Plenipot $plenipot)
    {
        return $plenipot;
    }
    public function update(Request $request, Plenipot $plenipot)
    {
        return $plenipot->update($request->validate([
            "prenom" => "required|string",
            "nom" => "required|string",
            "nin" => "required|unique:plenipots,nin,".$plenipot->id,
            "num_electeur" => "required|integer|unique:plenipots,num_electeur,".$plenipot->id,
        ], [
            "nin.unique" => "Ce numéro NIN est déjà utilisé par un autre plénipotentiaire.",
            "num_electeur.unique" => "Ce numéro d'électeur est déjà utilisé par un autre plénipotentiaire."
        ]));
    }
    public function destroy(Plenipot $plenipot)
    {
        return $plenipot->delete();
    }

}
