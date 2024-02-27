<?php

namespace App\Http\Controllers;

use App\Models\Collecte;
use App\Models\CollecteParticipant;
use App\Service\OrangeMoneyService;
use App\Service\WaveService;
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
    public function addParticipant(Request $request, Collecte $collecte, OrangeMoneyService $moneyService){

        $participant = new CollecteParticipant($request->validate([
            "nom"=>"required",
            "montant"=>"required|numeric",
            "telephone"=>"required|numeric",
            "prenom"=>"required",
            "paye_par"=>"required",
        ]));

        $participant->reference = "REF".now()->format('YmdHis');

        $collecte->participants()->save($participant);
        $metaData = [
            "type"=>"collecte",
            "collecte_id" => $collecte->id,
            "participant_id" => $participant->id,
            "telephone"=>$request->get('telephone')
        ];
        $data = [
            "client_reference"=>json_encode($metaData),
            "amount"=>$participant->montant,
        ];
        if ($participant->paye_par == "wave"){
            $waveReponse = WaveService::getWavePaymentUrl($data);
            $wave_launch_url = json_decode($waveReponse->content())->wave_launch_url ?? null;
            return response()->json(["wave_launch_url"=>$wave_launch_url]);
        }else if ($participant->paye_par == "om" || $participant->paye_par == "orange_money" ){
            $data['metadata'] = $metaData;
            $data['telephone'] = $request->get('telephone');
            $omResponse = $moneyService->initOMPayment($data);
            return  ["participant"=>$participant, "om_data"=>json_decode($omResponse->getContent())];

        }
        else if ($participant->paye_par == "carte" || $participant->paye_par == "fm") {
            return response()
                ->json(["message" => "Methode de paiement non supporté", 422]);
        }
        return $participant;
    }
    public function participants(Collecte $collecte){

        return $collecte->participants()->get();
    }
}
