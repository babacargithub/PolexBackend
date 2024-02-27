<?php

namespace App\Http\Controllers;

use App\Models\Collecte;
use App\Models\CollecteParticipant;
use Illuminate\Http\Request;

class CollecteController extends Controller
{
    //
    public function index(){

        return Collecte::withCount('participants')->get();
    }
    public function store(Request $request){
        return Collecte::create($request->validate([
            "libelle"=>"required|unique:collectes,libelle",
            "description"=>"required",
            "objectif"=>"required|numeric",
        ],[
            "libelle.unique"=>"Une collecte avec ce meme nom existe déjà. Veuillez en choisir un autre."
        ]));
    }
    public function show(Collecte $collecte){
        $collecte->load("participants");
        return $collecte;
    }
    public function update(Request $request, Collecte $collecte){
        $collecte->update($request->validate([
            "libelle"=>"string|required|unique:collectes,libelle,".$collecte->id,
            "description"=>"string",
            "objectif"=>"numeric",
        ],[
            "libelle.unique"=>"Impossible de modifier avec ce nom. Une collecte avec ce meme nom existe déjà. Veuillez en choisir un autre."
        ]));
        return $collecte;
    }
    public function delete(Collecte $collecte){
        $collecte->delete();
        return response(null, 204);
    }
    public function addParticipant(Request $request, Collecte $collecte){

        $participant = new CollecteParticipant($request->validate([
            "nom"=>"required",
            "montant"=>"required|numeric",
            "telephone"=>"required|numeric",
            "prenom"=>"required",
            "paye_par"=>"required",
        ]));

        $participant->reference = "REF".now()->format('YmdHis');

        $collecte->participants()->save($participant);
        return $participant;
    }
    public function participants(Collecte $collecte){

        return $collecte->participants()->get();
    }
}
