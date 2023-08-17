<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParrainageRequest;
use App\Http\Requests\UpdateParrainageRequest;
use App\Models\Electeur;
use App\Models\Parrainage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ParrainageController extends Controller
{

    public function index()
    {
        $parti_id = 1;
        $rapports["total_demande"] = 120000;
        $rapports["total_saisi"] = Parrainage::count();
        $rapports["manquant"] = Parrainage::count();
        $rapports["minimum_demande"] = Parrainage::count();
        $rapports["max_demande"] = Parrainage::count();
        $rapports["regions"] = Parrainage::select('region as nom', DB::raw('count(*) as nombre'))
            ->where("parti_id",$parti_id)
            ->groupBy('region')
            ->get();

        return $rapports;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreParrainageRequest $request
     */
    public function store(StoreParrainageRequest $request)
    {
        //
        $data = $request->input();
        $haveAccessToProValidation = count($data) > 0;
        if ($haveAccessToProValidation){
            $validationResult = $this->proValidation($data);
            if($validationResult["all_fields_match"]){
                return  new JsonResponse($validationResult, 200);

            }else{
                return  new JsonResponse(["message"=>"pro_validation_failed", "errors"=>$validationResult], 422);
            }

        }
        return new Parrainage($data);
    }

    /**
     * Display the specified resource.
     *
     * @param Parrainage $parrainage
     * @return Parrainage
     */
    public function show(Parrainage $parrainage): Parrainage
    {
        //
        return $parrainage;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateParrainageRequest $request
     * @param Parrainage $parrainage
     * @return Parrainage
     */
    public function update(UpdateParrainageRequest $request, Parrainage $parrainage): Parrainage
    {
        //
         Parrainage::update($request->validated());
         return  $parrainage;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Parrainage $parrainage
     * @return Response
     */
    public function destroy(Parrainage $parrainage): Response
    {
        //
        $parrainage->delete();
        return new Response('deleted',204);
    }
    public function proValidation($data): array{
        $nin = $data["nin"];
        $num_electeur = $data["num_electeur"];

        $electeur = Electeur::where("nin",$nin)->orWhere('num_electeur',$num_electeur)->first();
        if ($electeur == null){
            //no match
            return ["has_match"=>false, "all_fields_match"=> false];
        }else{
            return [
                "has_match"=>true,
                "all_fields_match"=>
                    strtoupper($data["prenom"]) == $electeur->prenom
                    && strtoupper($data["nom"]) == $electeur->nom
                    && $data["nin"] == $electeur->nin
                    && $data["num_electeur"] == $electeur->num_electeur
                    && $data["bureau"] == $electeur->bureau
                    && strtoupper($data["region"]) == $electeur->region,
                "fields"=>[
                    ["label"=>"PRENOM", "matched"=> strtoupper($data["prenom"]) == $electeur->prenom],
                    ["label"=>"NOM", "matched"=> strtoupper($data["nom"]) == $electeur->nom],
                    ["label"=>"NIN", "matched"=>$data["nin"] == $electeur->nin],
                    ["label"=>"N° Electeur", "matched"=>$data["num_electeur"] == $electeur->num_electeur],
                    [ "label"=>"BUREAU", "matched"=>$data["bureau"] == $electeur->bureau],
                    ["label"=>"REGION", "matched"=> strtoupper($data["region"]) == $electeur->region]
                ]

            ];
        }
    }
}
