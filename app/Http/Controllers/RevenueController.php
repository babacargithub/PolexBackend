<?php

namespace App\Http\Controllers;

use App\Models\Revenue;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    //
    public function index(){
        return Revenue::all();
    }
    public function store(Request $request){
        return Revenue::create($request->validate([
            "libelle"=>"required",
            "montant"=>"required|numeric",
            "date_revenue"=>"required"
        ]));
    }
    public function show(Revenue $revenue){
        return $revenue;
    }
    public function update(Request $request, Revenue $revenue){
        $revenue->update($request->all());
        return $revenue;
    }
    public function delete(Revenue $revenue){
        $revenue->delete();
        return response()->noContent();
    }

    // ======== RECETTES VENTES =========
    public function recettesVentesCartes(){
        // TODO implement
        return[
            [ "id"=> 1,
        "responsable"=> "Inconnu",
        "structure"=> "Inconnu",
        "total_recette"=> 0,
        "nombre_carte"=> 0]
            ,[ "id"=> 1,
        "responsable"=> "Inconnu",
        "structure"=> "Inconnu",
        "total_recette"=> 0,
        "nombre_carte"=> 0] ,[ "id"=> 1,
        "responsable"=> "Inconnu",
        "structure"=> "Inconnu",
        "total_recette"=> 0,
        "nombre_carte"=> 0]

        ];
    }
}
