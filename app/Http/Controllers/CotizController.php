<?php

namespace App\Http\Controllers;

use App\Models\Cotiz;
use App\Models\CotizVersement;
use App\Models\Membre;
use App\Service\OrangeMoneyService;
use App\Service\WaveService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CotizController extends Controller
{
    //
    public function index(){

        return Cotiz::all();
    }
    public function store(Request $request){

        return Cotiz::create($request->validate([
            "libelle"=>"required|unique:cotizs,libelle",
            "date_debut"=>"required",
            "date_fin"=>"required",
            "montant"=>"required|numeric"
        ],[
            "libelle.unique"=>"Une campagne de cotisation avec ce meme nom existe déjà. Veuillez en choisir un autre."
        ]));
    }
    public function show(Cotiz $cotiz){
        return  $cotiz;
    }
    public function update(Request $request, Cotiz $cotiz){
        $cotiz->update($request->all());
        return $cotiz;
    }
    public function delete(Cotiz $cotiz){
        $cotiz->delete();
        return response(null, 204);
    }
    public function addVersement(Request $request, Cotiz $cotiz, OrangeMoneyService $omService, WaveService $waveService): JsonResponse|array
    {

        $cotizVersement = new CotizVersement($request->validate([
            "membre_id"=>"required|exists:membres,id",
            "montant"=>"required|numeric",
            "paye_par"=>"required|in:wave,om,carte,fm",
        ]));
        $cotizVersement->reference = "REF".now()->format('YmdHis');
        $cotiz->cotisations()->save($cotizVersement);
        $metaData = [
            "type"=>"cotiz","id" => $cotiz->id,
            "cotiz_versement_id" => $cotizVersement->id,
            "telephone"=>$request->get('telephone')
        ];

        // prepare data for wave and OM payment
        $data = [
            "client_reference"=>json_encode($metaData),
            "amount"=>$cotizVersement->montant,
            "telephone"=>$request->get('telephone'),
            'metadata'=>$metaData,
        ];
        if ($cotizVersement->paye_par == "wave"){

            $wavePayementLink =  WaveService::getWavePaymentUrl($data);
            $responseData = json_decode($wavePayementLink->content());


            return  ["cotiz"=>$cotiz, "versement"=>$cotizVersement, "wave_launch_url"=>$responseData->wave_launch_url];
        }
        else if ($cotizVersement->paye_par == "om"){
            $omResponse = $omService->initOMPayment($data);
           return  ["cotiz"=>$cotiz, "versement"=>$cotizVersement, "om_data"=>json_decode($omResponse->getContent())];
        }
        else  if ($cotizVersement->paye_par == "carte"){
            // TODO implement carte
           return  response()->json(["cotiz"=>$cotiz, "versement"=>$cotizVersement]);
        }
        return  ["cotiz"=>$cotiz, "versement"=>$cotizVersement];
    }
    public function versements(Cotiz $cotiz){

        $versements = $cotiz->cotisations()->with('membre.structure')->get()->map(function ($item){
            return [
                "id"=>$item->id,
                "membre"=>$item->membre->nom_complet,
                "reference"=>$item->reference,
                "structure"=>$item->membre->structure->nom,
                "montant"=>$item->montant,
                "telephone"=>intval($item->membre->telephone),
                "paye_par"=>$item->paye_par,
                "date_versement"=>$item->created_at->format('d/m/Y H:i:s')
            ];
        });
        $non_cotisants = Membre::with('structure')->whereNotIn('id', $cotiz->cotisations()->pluck('membre_id'))->get()->map(function (Membre $item){
            return [
                "id"=> $item->id,
                "nom_complet"=>$item->nom_complet,
                "prenom"=>$item->prenom,
                "nom"=>$item->nom,
                "structure"=>$item->structure->nom,
                "telephone"=>intval($item->telephone),
            ];
        });
        return response()->json(["cotiz"=>$cotiz,"versements"=>$versements, "non_cotisants"=>$non_cotisants]);
    }

    /** @noinspection PhpUnused */
    public function onPaymentSuccess()
    {
        $paymentMethod = request()->validate([
            "payment_method" => "required",
            "reference" => "required",
            "montant" => "required|numeric",
            "telephone" => "required|numeric"
        ]);
        $participant = CotizVersement::whereReference($paymentMethod['reference'])->first();
        if ($participant) {
            $participant->update([
                "paye_par" => $paymentMethod['payment_method'],
                "montant" => $paymentMethod['montant'],
                "paye"=> true,
                "paye_le" => now()
            ]);
            return $participant;

        }

        return response()->noContent(200);
    }
}
