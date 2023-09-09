<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParrainageRequest;
use App\Http\Requests\UpdateParrainageRequest;
use App\Models\Electeur;
use App\Models\Params;
use App\Models\Parrainage;
use App\Models\Parti;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ParrainageController extends Controller
{
    const REGIONS_DIASPORA = [
        'AFRIQUE DU SUD',
        'ALLEMAGNE',
        'ARABIE SAOUDITE',
        'BELGIQUE',
        'BRESIL',
        'BURKINA FASO',
        'CAMEROUN',
        'CANADA',
        'CAP VERT',
        'CONGO',
        'COTE D\'IVOIRE',
        'EGYPTE',
        'EMIRATS ARABES UNIS',
        'ESPAGNE',
        'FRANCE',
        'GABON',
        'GAMBIE',
        'GHANA',
        'GRANDE BRETAGNE',
        'GUINEE',
        'GUINEE BISSAU',
        'ITALIE',
        'KOWEIT',
        'MALI',
        'MAROC',
        'MAURITANIE',
        'NIGER',
        'NIGERIA',
        'PAYS - BAS',
        'PORTUGAL',
        'SUISSE',
        'TOGO',
        'TUNISIE',
        'TURQUIE',
    ];

    public function index(): array
    {
        $parti_id = Parti::partiOfCurrentUser()->id;
        $params = Params::getParams();
        $rapports["max_count"] = $params->max_count;
        $rapports["min_count"] = $params->min_count;
        $total_saisi = Parrainage::wherePartiId($parti_id)->count();
        $rapports["total_saisi"] = $total_saisi;
        $rapports["manquant"] = $params->min_count - $total_saisi;
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
     * @return JsonResponse
     */
    public function store(StoreParrainageRequest $request)
    {
        //
        $data = $request->input();
        $parti = Parti::partiOfCurrentUser();
        $haveAccessToProValidation = $parti->formule->has_pro_validation;
        $data["parti_id"] = $parti->id;
        $request->validate([
            'nin' => [function($attribute,$value, $fail) use ($data, $parti){
                $electeur = Parrainage::where("nin",$data["nin"])
                    ->wherePartiId($parti->id)

                    ->first();
                if ($electeur != null){
                    //no match
                    $fail('Un parrainage déjà enregistré avec la même cni ');
                }
            }],
            'num_electeur' => [function($attribute,$value, $fail) use ($data,$parti){
                $electeur =
                    Parrainage::where('num_electeur',$data['num_electeur'])
                        ->wherePartiId($parti->id)
                        ->first();
                if ($electeur != null){
                    //no match
                    $fail('Un parrainage déjà enregistré avec le même numéro électeur! ');
                }
            }],
        ]);

        // Pro validation

        if ($haveAccessToProValidation){
            $electeur = Electeur::where("nin",$data['nin'])
                ->orWhere('num_electeur',$data['num_electeur'])->first();

            $validationResult = self::proValidation(new Parrainage($data),$electeur);
            if($validationResult["all_fields_match"]){

                return Parrainage::create($data);

            }else{
                return  new JsonResponse(["message"=>"pro_validation_failed", "errors"=>$validationResult], 422);
            }

        }
        return  Parrainage::create($data);
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
    public static function proValidation(Parrainage $parrainage, $electeur = null): array{
        $isDiasporaElecteur = strtolower($parrainage->region) == "diaspora";
        $params = Params::getParams();
        $discriminantFieldName = $params->discriminant_field_name;
        $shouldCheckDiscriminant = ($params->check_discriminant && isset($parrainage->{$discriminantFieldName}) && isset($electeur->{$discriminantFieldName}));
        if ($electeur == null){
            //no match
            return ["has_match"=>false, "all_fields_match"=> false, "fields"=>[]];
        }else{
             $result = [
                "has_match"=>true,
                "all_fields_match"=>
                    strtolower($parrainage->prenom) == strtolower($electeur->prenom)
                    && strtolower($parrainage->nom) == strtolower($electeur->nom)
                    && $parrainage->nin == $electeur->nin
                    && $parrainage->num_electeur == $electeur->num_electeur
                    && ($shouldCheckDiscriminant == true ? $parrainage->{$discriminantFieldName} == $electeur->{$discriminantFieldName} : true)
                    && (strtolower($parrainage->region) == strtolower($electeur->region) || ($isDiasporaElecteur && self::isDiasporaRegion($electeur->region))),
                "fields"=>[
                    ["label"=>"PRENOM ".$parrainage->prenom, "matched"=> strtolower($parrainage->prenom) == strtolower($electeur->prenom)],
                    ["label"=>"NOM ".$parrainage->nom, "matched"=> strtolower($parrainage->nom) == strtolower($electeur->nom)],
                    ["label"=>"NIN ".$parrainage->nin, "matched"=>strtolower($parrainage->nin) == strtolower($electeur->nin)],
                    ["label"=>"N° Electeur ".$parrainage->num_electeur, "matched"=> intval($parrainage->num_electeur) == intval($electeur->num_electeur)],
                    ["label"=>"REGION ".$parrainage->region, "matched"=> (strtolower($parrainage->region) == strtolower($electeur->region) || ($isDiasporaElecteur && self::isDiasporaRegion($electeur->region)))]
                ]

            ];
             if ($shouldCheckDiscriminant){
                 $result[] = ["label"=> $discriminantFieldName.' '.$parrainage->{$discriminantFieldName},"matched"=>$parrainage->{$discriminantFieldName} == $electeur->{$discriminantFieldName} ];
             }

             return $result;
        }
    }
    public static function isDiasporaRegion($region): bool
    {

        return in_array($region,self::REGIONS_DIASPORA);
    }
}
