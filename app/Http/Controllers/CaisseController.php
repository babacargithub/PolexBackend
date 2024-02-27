<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\Depense;
use App\Models\Revenue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CaisseController extends Controller
{
    //
    public function index(){
        try {
           $caisse =  Caisse::firstOrFail();
           return ["caisse"=>$caisse,"depenses"=>Depense::all(),"revenues"=>Revenue::all()];
        } catch (ModelNotFoundException $e) {

          return Caisse::create(["libelle"=>"Caisse principale","solde"=>0,"updated_at" => now(),"created_at" => now()]);
        }
    }
    public function store(Request $request){
        return Caisse::create($request->validate([
            "solde"=>"required|numeric"
        ]));
    }
    public function show(Caisse $caisse){
        return $caisse;
    }
    public function update(Request $request, Caisse $caisse){
        $caisse->update($request->all());
        return $caisse;
    }
    public function depenses(){
        return Depense::all();
    }
    public function addDepense(Request $request){
        return Depense::create($request->validate([
            "libelle"=>"required",
            "montant"=>"required|numeric",
            "justification"=>"required",
            "date_depense"=>"required",
        ]));
    }
    public function deleteDepense(Depense $depense){
        $depense->delete();
        return response(null, 204);
    }
    public function updateDepense(Request $request, Depense $depense){
        $depense->update($request->all());
        return $depense;
    }
    public function depense(Depense $depense){
        return $depense;
    }
    public function addRevenue(Request $request){
        $revenue =  Revenue::create($request->validate([
            "libelle"=>"required",
            "montant"=>"required|numeric",
            "justification"=>"string",
        ]));
        $caisse = Caisse::firstOrFail();
        $caisse->solde += $revenue->montant;
        $caisse->save();
        return $revenue;
    }
    public function deleteRevenue(Revenue $revenue){
        $revenue->delete();
        return response(null, 204);
    }
    public function updateRevenue(Request $request, Revenue $revenue){
        $revenue->update($request->all());
        return $revenue;
    }
    public function revenue(Revenue $revenue){
        return $revenue;
    }
    public function revenues(){
        return Revenue::all();
    }

}
