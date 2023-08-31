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
        //TODO change these 2 lines later
        $haveAccessToProValidation = count($data) > 100000;
        $data["parti_id"] = 1;
        $request->validate([
            'nin' => [function($attribute,$value, $fail) use ($data){
                $electeur = Parrainage::where("nin",$data["nin"])->first();
                if ($electeur != null){
                    //no match
                    $fail('Un parrainage déjà enregistré avec la même cni ');
                }
            }],
            'num_electeur' => [function($attribute,$value, $fail) use ($data){
                $electeur = Parrainage::where('num_electeur',$data['num_electeur'])->first();
                if ($electeur != null){
                    //no match
                    $fail('Un parrainage déjà enregistré avec le même numéro électeur! ');
                }
            }],
        ]);

        // Pro validation

        if ($haveAccessToProValidation){
            $electeur = Electeur::where("nin",$data['nin'])->orWhere('num_electeur',$data['num_electeur'])->first();

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
    public static function proValidation(Parrainage $parrainage, $electeur): array{
        $isDiasporaElecteur = strtolower($parrainage->region) == "diaspora";
        if ($electeur == null){
            //no match
            return ["has_match"=>false, "all_fields_match"=> false, "fields"=>[]];
        }else{
            return [
                "has_match"=>true,
                "all_fields_match"=>
                    strtolower($parrainage->prenom) == strtolower($electeur->prenom)
                    && strtolower($parrainage->nom) == strtolower($electeur->nom)
                    && $parrainage->nin == $electeur->nin
                    && $parrainage->num_electeur == $electeur->num_electeur
                    //TODO changer later && $data["bureau"] == $electeur->bureau
                    && (strtolower($parrainage->region) == strtolower($electeur->region) || ($isDiasporaElecteur && self::isDiasporaRegion($electeur->region))),
                "fields"=>[
                    ["label"=>"PRENOM ".$parrainage->prenom, "matched"=> strtolower($parrainage->prenom) == strtolower($electeur->prenom)],
                    ["label"=>"NOM ".$parrainage->nom, "matched"=> strtolower($parrainage->nom) == strtolower($electeur->nom)],
                    ["label"=>"NIN ".$parrainage->nin, "matched"=>strtolower($parrainage->nin) == strtolower($electeur->nin)],
                    ["label"=>"N° Electeur ".$parrainage->num_electeur, "matched"=> intval($parrainage->num_electeur) == intval($electeur->num_electeur)],
//TODO changer later
//                    [ "label"=>"BUREAU", "matched"=>$data["bureau"] == strtoupper($electeur->bureau)],
                    ["label"=>"REGION ".$parrainage->region, "matched"=> (strtolower($parrainage->region) == strtolower($electeur->region) || ($isDiasporaElecteur && self::isDiasporaRegion($electeur->region)))]
                ]

            ];
        }
    }
    public static function isDiasporaRegion($region): bool
    {

        return in_array($region,self::REGIONS_DIASPORA);
    }
}
