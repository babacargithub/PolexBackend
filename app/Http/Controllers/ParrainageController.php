<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParrainageRequest;
use App\Http\Requests\UpdateParrainageRequest;
use App\Models\Electeur;
use App\Models\Params;
use App\Models\Parrainage;
use App\Models\Parti;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ParrainageController extends Controller
{
    const jsonHeaders = ["Accept"=>"application/json",
        "Content-Type"=>"application/json"];
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

    public function index(): JsonResponse|array
    {
        if (!request()->user()->hasRole("owner")){
            abort(403,"Accès aux rapports refusé !");
        }
        $parti_id = Parti::partiOfCurrentUser()->id;
        $params = Params::getParams();
        $rapports["max_count"] = $params->max_count;
        $rapports["min_count"] = $params->min_count;



        $parti = Parti::partiOfCurrentUser();
        $has_endpoint = $parti->hasEndpoint();

        if ($has_endpoint) {
            try {
                $url = $parti->end_point . "parrainages";
                $response = Http::get($url);
                $response->throw();
                if ($response->successful()) {
                    $dataFromApi = json_decode($response->body(), true);
                    $rapports = array_merge($rapports, $dataFromApi);
                    $users = [];
                    foreach ($rapports["users"] as  $userItem) {
                        if ($userItem["user"] != null) {
                            $user = User::whereId($userItem["user"])->first();
                            $userItem["user"] = $user != null ? $user->name : null;
                            $users[] = $userItem;
                        }
                    }
                    $rapports["users"] = $users;



                }
            } catch (RequestException $e) {
                Log::error($e->getMessage());
                    return response()->json(["une erreur s'est produite ".$e->response->body()], 500);

            }
        }else{
            $total_saisi = Parrainage::wherePartiId($parti_id)->count();
            $rapports["total_saisi"] = $total_saisi;
            $rapports["regions"] = Parrainage::select('region as nom', DB::raw('count(*) as nombre'))
                ->where("parti_id",$parti_id)
                ->groupBy('region')
                ->get();


        }
        $total_saisi = $rapports["total_saisi"];
        $rapports["manquant"] = $params->min_count - $total_saisi;
        $rapports["manquant_min"] = $params->min_count - $total_saisi;
        $rapports["manquant_max"] = $params->max_count - $total_saisi;


        return $rapports;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreParrainageRequest $request
     * @return JsonResponse
     * @throws RequestException
     */
    public function store(StoreParrainageRequest $request)
    {
        //
        $data = $request->validated();
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

                $parti = Parti::partiOfCurrentUser();
                $has_endpoint = $parti->hasEndpoint();

                if ($has_endpoint) {
                    $url = $parti->end_point."parrainages";
                    try {
                        $data["user_id"] = request()->user()->id;
                        $response = Http::withHeaders(self::jsonHeaders)
                            ->post($url, $data);
                        $response->throw();
                        if ($response->successful()) {
                            return response()->json(json_decode($response->body(), true));
                        } else {
                            return response()->json(["message" => "Une erreur", "detail" => json_decode($response->body(), true)], 500);

                        }
                    } catch (RequestException $e) {
                        if ($e->response->unprocessableEntity()){
                            return response()->json(json_decode($e->response->body(), true), 422);

                        }else
                        return response()->json(["message" => "Une erreur from Polex api", "detail" => json_decode($e->response->body(), true)], 500);

                    }
                }else{
                    return  Parrainage::create($data);

                }

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
     * @return Parrainage|array|JsonResponse|object
     */
    public function update(UpdateParrainageRequest $request, $num_electeur)
    {
        //
        try {
            if ( Parti::partiOfCurrentUser()->hasEndpoint()) {
                $url = Parti::partiOfCurrentUser()->end_point . "parrainages/update/" . $num_electeur;
                $response = Http::post($url, $request->input());
                $response->throw();
                if ($response->successful()) {
                    return $response->object();

                }
            } else {
                $parrainage = Parrainage::whereNumElecteur($num_electeur)->first();
                if ($parrainage != null){
                    $parrainage->update($request->input());
                }else{
                    return \response()->json(["message"=>"Parrainage introuvable ! "],404);
                }
                return  $parrainage;
            }
        } catch (RequestException $e) {

                if ($e->response->notFound()) {
                    return \response()->json(["message" => "Electeur non trouvé"], 404);
                }else{
                    Log::error("Une erreur s'est produite au niveau de l'api ".$e->getMessage());
                    return \response()->json(["message" => "Une erreur s'est produite au niveau de l'api"], 404);

                }


        }

        return $request;

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
        if ($electeur == null){
            //no match
            return ["has_match"=>false, "all_fields_match"=> false, "fields"=>[]];
        }else{
             $result = [
                "has_match"=>true,
                "all_fields_match"=>
                    strtolower(trim($parrainage->prenom)) == strtolower(trim($electeur->prenom))
                    && strtolower(trim($parrainage->nom)) == strtolower(trim($electeur->nom))
                    && trim($parrainage->nin) == trim($electeur->nin)
                    && trim($parrainage->num_electeur) == trim($electeur->num_electeur)
                    && (strtolower(trim($parrainage->region)) == strtolower(trim($electeur->region)) || (self::isDiasporaRegion($electeur->region))),
                "fields"=>[
                    ["label"=>"PRENOM ".$parrainage->prenom, "matched"=> strtolower(trim($parrainage->prenom)) == strtolower(trim($electeur->prenom))],
                    ["label"=>"NOM ".$parrainage->nom, "matched"=> strtolower(trim($parrainage->nom)) == strtolower(trim($electeur->nom))],
                    ["label"=>"NIN ".$parrainage->nin, "matched"=>strtolower(trim($parrainage->nin)) == strtolower(trim($electeur->nin))],
                    ["label"=>"N° Electeur ".$parrainage->num_electeur, "matched"=> intval($parrainage->num_electeur) == intval(trim($electeur->num_electeur))],
                    ["label"=>"REGION ".$parrainage->region, "matched"=> (strtolower($parrainage->region) == strtolower(trim($electeur->region)) || ($isDiasporaElecteur && self::isDiasporaRegion($electeur->region)))]
                ]

            ];

             return $result;
        }
    }
    public static function isDiasporaRegion($region): bool
    {

        return in_array($region,self::REGIONS_DIASPORA);
    }

    public function bulkInsertFromExcel()
    {

        $data = request()->json('data');
        $dataWithoutDiscriminantFieldName = array_map(function ($item) {
            $parti_id = Parti::partiOfCurrentUser()->id;
            $item["parti_id"] = $parti_id;
            $item["created_at"] = Carbon::now();

            return $item;
        }, $data);

        $parti = Parti::partiOfCurrentUser();
        $has_endpoint = $parti->hasEndpoint();

        if ($has_endpoint) {
            $url = $parti->end_point.'parrainages/excel';
            $dataWithoutDiscriminantFieldName = array_map(function ($item) {
                $item["user_id"] = request()->user()->id;
                return $item;
            }, $dataWithoutDiscriminantFieldName);
            $response = Http::withHeaders([
                self::jsonHeaders
            ])->post($url,["data"=>$dataWithoutDiscriminantFieldName]);
            if ($response->successful()){
                return response()->json(json_decode($response->body(),true));
            }else{
                return response()->json(["message"=>"Une erreur","detail"=>$response->body()],500);

            }

        }else{

            Parrainage::insertOrIgnore($dataWithoutDiscriminantFieldName);
        }


        return response()->json(["total_inserted"=>count($data)]);


    }

    public function bulkProValidation(): array|JsonResponse
    {
        $has_pro = Parti::partiOfCurrentUser()->formule->has_pro_validation;
        if (!$has_pro){
            return response()->json(['Accès réservé aux clients Pro'],403);
        }

        $data = request()->json('parrainages');
        $region = request()->json('region');
        $parrainagesValides= [];
        $parrainagesInvalides= [];
        foreach ($data as $parrainage) {
            $table_name = $region == "SAINT LOUIS" ? 'saint_louis' : strtolower($region) ;
            $electeur = DB::table($table_name)->select(["prenom","nom","nin","num_electeur","region"])
                ->where("nin",$parrainage["nin"])
                ->orWhere("num_electeur",$parrainage["num_electeur"])
                ->first();
            $validationResult = ParrainageController::proValidation(new Parrainage($parrainage),$electeur);
            if ($validationResult["has_match"] && $validationResult["all_fields_match"]){
                $parrainagesValides[] = $parrainage;
            }else {
                $errors = [];
                if ($validationResult["has_match"]) {
                    $fields = $validationResult["fields"];
                    foreach ($fields as $field) {
                        if (!$field['matched']) {
                            $message = $field["label"] . ' non conforme';
                            $errors[] = $message;
                        }
                    }
                } else {
                    $errors[] = "Introuvable dans la région de ".$region." ou dans le fichier électoral";
                }
                $parrainage ["raison"] = implode(", ",$errors);
                $parrainagesInvalides[] = $parrainage;
            }
        }


        return ["parrainagesInvalides"=>$parrainagesInvalides, "parrainagesValides"=>$parrainagesValides];

    }
    public function bulkCorrection(): array|JsonResponse
    {
        $params = Params::getParams();
        $has_pro = Parti::partiOfCurrentUser()->formule->has_pro_validation;
        if (!$has_pro){
            return response()->json(['Accès réservé aux clients Pro'],403);
        }

        $data = request()->json('parrainages');
        $parrainagesCorriges = [];
        $parrainagesNonCorriges = [];
        foreach ($data as $parrainage) {
            $table_name = "electeurs";

            $query = DB::table($table_name)->select(["prenom","nom","nin","num_electeur","region"]);
            $electeur = $query
                ->where("nin",$parrainage["nin"])
                ->first();
            /** @var $electeur Electeur */
            if ($electeur == null){
                $electeur = $query->where("num_electeur",$parrainage["num_electeur"])
                    ->first();
            }

            if ($electeur != null){
                $corrected  = [];
                $corrected["prenom"] = $electeur->prenom;
                $corrected["nom"] = $electeur->nom;
                $corrected["nin"] = $electeur->nin;
                $corrected["num_electeur"] = $electeur->num_electeur;
                $corrected["date_expir"] = $parrainage["date_expir"];
                $corrected["region"] = self::isDiasporaRegion($electeur->region)? "DIASPORA": $electeur->region;
                $parrainagesCorriges[] = $corrected;
            }else{
                $parrainagesNonCorriges [] = $parrainage;

            }
        }


        return ["parrainagesCorriges"=>$parrainagesCorriges, "parrainagesNonCorriges"=>$parrainagesNonCorriges];

    }

    public function findForAutocomplete($param)
    {
        $electeur = DB::table("electeurs")->select(["prenom","nom","nin","num_electeur","region"])
            ->where("nin",$param)
            ->orWhere("num_electeur",$param)
            ->first();
        if ($electeur == null){
            return response()->json(['message'=>'not found'],404);
        }
        $electeur->date_expir = null;
        $electeur->region = ParrainageController::isDiasporaRegion($electeur->region)
            ?
            "DIASPORA": $electeur->region;
        if (Parti::partiOfCurrentUser()->created_at->isAfter("2023-06-17")){
            $parti = Parti::partiOfCurrentUser();
            $has_endpoint = $parti->hasEndpoint();

            if ($has_endpoint) {
                $url = $parti->end_point."parrainages/find/".$param;
                $response = Http::get($url);
                if ($response->successful()) {
                    return  ["already_exists"=>true, "electeur"=>$response->object()];

                } else {
                    if ($response->notFound()){
                        return ["already_exists"=>false, "electeur"=>$electeur];
                    }else{
                    return response()->json([],500);
                    }
                }
            }else{
                $parrainage = Parrainage::where("nin",$param)
                    ->orWhere("num_electeur",$param)
                    ->first();
                return ["already_exists"=>$parrainage != null, "electeur"=>$electeur];

            }

        }
        return $electeur;
    }
}
