<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Departement;
use App\Models\Membre;
use App\Models\Region;
use App\Models\SmsBatch;
use App\Models\SmsBatchItem;
use App\Models\Structure;
use App\Models\TypeMembre;
use App\Rules\Telephone;
use App\Service\SMSSender;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SmsBatchController extends Controller
{
    const TYPE_DESTINATAIRE_COMMUNE = "commune";
    const TYPE_DESTINATAIRE_REGION = "region";
    const TYPE_DESTINATAIRE_DEPARTEMENT = "departement";
    const TYPE_DESTINATAIRE_STRUCTURE = "structure";
    const TYPE_DESTINATAIRE_MEMBRE_ALL = "membre_all";
const TYPE_DESTINATAIRE_RESPONSABLE = "responsable";
    const TYPE_DESTINATAIRE_TYPE_MEMBRE = "type_membre";

    //
    public function index()
    {
        return SmsBatch::withCount('items')->where("status","=","pending")
            ->orWhere('sent_all',false)->orderByDesc('created_at')->get();

    }
    public function show($id)
    {
        return SmsBatch::with('items')->find($id);
    }
    public function store(Request $request)
    {
        $batch = new SmsBatch($request->validate([
            "message"=>"required|string",
            "destinataires"=>"required|array",
            "destinataires.*.telephone"=> new Telephone(),
            "destinataires.*.message"=>"required|string"

        ],[
            "destinataires.*.telephone"=>"Le numéro de téléphone n'est pas valide",
            "destinataires.*.message.required"=>"Le message est requis"]));
        $batch->reference = "SMS lancé le : ".now()->format('d/m/Y H:i:s');
        $batch->status = "pending";
        $batch->sent_all = false;
        $batch->total = count($request->get('destinataires'));
        $batch->save();
        $batch->items()->createMany(collect($request->get('destinataires'))->map(function($message){

            return new SmsBatchItem([
                "telephone"=>$message['telephone'],
                "message"=>$message['message'],
                "sent" => false
            ]);
        })->toArray());

        $batch->load('items');
        // TODO réduire les champs inutiles
        /* "id"=>$item->id,
                "telephone"=>$item->telephone,
                "message"=>$item->message,
                "sent"=>$item->sent,
                "sent_at"=>$item->sent_at,
                "status"=>$item->status*/
        $batch->items = $batch->items->map(function($item){
            return [
                "id"=>$item->id,
                "telephone"=>$item->telephone,
                "message"=>$item->message,
                "sent"=>$item->sent,
                "sent_at"=>$item->sent_at,
                "status"=>$item->status
            ];

        });
        return  $batch;
    }
    public function update(Request $request, $id)
    {
        $smsBatch = SmsBatch::findOrFail($id);
        $smsBatch->update($request->all());
        return $smsBatch;
    }
    public function delete( SmsBatch $smsBatch)
    {
        $smsBatch->delete();
        return 204;
    }
    public function sendSMS(Request $request)
    {
        $data = $request->validate([
            "message"=>"required|string",
            "telephone"=> new Telephone()
        ]);


        return ["success"=>SMSSender::send($data["message"],$data["telephone"]), "message"=>"SMS envoyé avec succès"];
    } public function sendBatchItem(SmsBatchItem $batchItem)
    {
        $status = SMSSender::send($batchItem->message, $batchItem->telephone);
       $batchItem->status = $status ? "REUSSI" : "ECHEC";
         $batchItem->sent = true;
        $batchItem->sent_at = now();
           $batchItem->save();
        return ["status"=>$batchItem->status, "message"=>"SMS envoyé avec status ".$batchItem->status];
    }

    public function deleteBatchItem(SmsBatchItem $smsBatchItem)
    {
        $smsBatchItem->delete();
        return response()->noContent();
    }
    public function updateBatchItem(Request $request, SmsBatchItem $smsBatchItem)
    {
        $smsBatchItem->update($request->validate([
            "message"=>"string",
            "telephone"=> new Telephone()]));
        return $smsBatchItem;
    }
    public function getListDestinataires(Request $request)
    {
       $membres = [];
        $data = $request->validate([
            "type_destinataire"=>"required|in:commune,region,departement,structure,membre_all,responsable,type_membre",
            "values"=>"required|array"
        ]);
        $type_destinataire = $data["type_destinataire"];
        $values = $data["values"];
        switch ($type_destinataire){
            case self::TYPE_DESTINATAIRE_COMMUNE:
                $communes_Ids =  Commune::whereIn("nom", $values)->pluck('id')->all();
                $membres = Membre::with('structure')
                    ->whereHas('structure', function ($query) use ($communes_Ids) {
                        $query->whereIn('commune_id', $communes_Ids);
                    })
                    ->get();
                break;
            case self::TYPE_DESTINATAIRE_REGION:
                $regionIds = Region::whereIn("nom", $values)->pluck('id');
                $membres = Membre::with('structure.commune.departement')
                    ->whereHas('structure.commune.departement', function (Builder $query) use ($regionIds) {
                        $query->whereIn("region_id", $regionIds);
                    })
                    ->get();
                break;
            case self::TYPE_DESTINATAIRE_DEPARTEMENT:
                $regionIds = Departement::whereIn("nom", $values)->pluck('id');
                $membres = Membre::with('structure.commune.departement')
                    ->whereHas('structure.commune', function (Builder $query) use ($regionIds) {
                        $query->whereIn("departement_id", $regionIds);
                    })
                    ->get();
                break;
            case self::TYPE_DESTINATAIRE_STRUCTURE:
                $membres = Membre::whereHas("structure",function (Builder $builder) use ($values){
                    $builder->whereIn("nom", $values);

                })->get();
                break;
            case self::TYPE_DESTINATAIRE_MEMBRE_ALL:
                $membres = Membre::all();
                break;

            case self::TYPE_DESTINATAIRE_TYPE_MEMBRE:
                $membres = Membre::whereIn("type_membre_id", TypeMembre::whereIn("nom", $values)->get()->pluck('id')->all())->get();
                break;
        }

        if ($membres instanceof  Collection){
            $membres = $membres->map(function($membre){
                return [
                    "nom"=>$membre->nom,
                    "prenom"=>$membre->prenom,
                    "nom_complet"=>$membre->nom_complet,
                    "telephone"=> intval($membre->telephone)
                ];
            });
        }

    return $membres;
    }

    public function getDataPourTypesDestinataires()
    {
        return [
            "communes"=>Commune::all()->pluck('nom'),
            "regions"=>Region::all()->pluck('nom'),
            "departements"=>Departement::all()->pluck('nom'),
            "structures"=>Structure::all()->pluck('nom'),
            "membre_all"=>Membre::all()->map(function($membre){
                return [
                    "nom"=>$membre->nom,
                    "prenom"=>$membre->prenom,
                    "nom_complet"=>$membre->nom_complet,
                    "telephone"=> intval($membre->telephone)
                ];
            }),
            "type_membres"=>TypeMembre::all()->pluck('nom')
        ];
    }


}
