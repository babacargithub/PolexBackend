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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

                    $rapports["users"] = array_map(function ($item){
                        if ($item["user"] != null) {
                            $user = User::whereId($item["user"])->first();
                            $item["user"] = $user != null ? $user->name :  "Inconnu";
                            return $item;
                        }
                        return $item;

                    }, $rapports["users"]);
                    $rapports["today_counts_per_user"] = array_map(function ($item){
                        if ($item["user"] != null) {
                            $user = User::whereId($item["user"])->first();
                            $item["user"] = $user != null ? $user->name :  "Inconnu";
                            return $item;
                        }
                        return $item;

                    }, $rapports["today_counts_per_user"]);


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
        $rapports["parti_users"] = $parti->users()->get();

        return $rapports;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreParrainageRequest $request
     * @return Parrainage|\Illuminate\Database\Eloquent\Model|JsonResponse
     * @throws RequestException
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            "prenom"=>"required|min:2|max:50",
            "nom"=>"required|min:2|max:20",
            "nin"=>"required|string|min:13|max:14",
            "num_electeur"=>"required|digits:9",
            "date_expir"=>"required|string",
            "region"=>"required|string",
            "primo"=>"bool",
            "commune"=>"string"
        ]);
        $parti = Parti::partiOfCurrentUser();
        $haveAccessToProValidation = $parti->formule->has_pro_validation;
        $data["parti_id"] = $parti->id;
        if (! $parti->hasEndpoint()) {
            $request->validate([
                'nin' => [function ($attribute, $value, $fail) use ($data, $parti) {
                    $electeur = Parrainage::where("nin", $data["nin"])
                        ->wherePartiId($parti->id)
                        ->first();
                    if ($electeur != null) {
                        //no match
                        $fail('Un parrainage déjà enregistré avec la même cni ');
                    }
                }],
                'num_electeur' => [function ($attribute, $value, $fail) use ($data, $parti) {
                    $electeur =
                        Parrainage::where('num_electeur', $data['num_electeur'])
                            ->wherePartiId($parti->id)
                            ->first();
                    if ($electeur != null) {
                        //no match
                        $fail('Un parrainage déjà enregistré avec le même numéro électeur! ');
                    }
                }],
                'commune' => [function ($attribute, $value, $fail) use ($data, $parti) {
                   if (isset($data["primo"]) && $data["primo"]){
                       if ( ! isset($data["commune"]) || $data["commune"] == null){
                           $fail('Veuillez renseigner la commune car la case primo votant est cochée ');

                       }
                   }
                }],
            ]);
        }

        // Pro validation

       if ($haveAccessToProValidation){
            $electeur = Electeur::where("nin",$data['nin'])
                ->orWhere('num_electeur',$data['num_electeur'])->first();
           if ($electeur != null) {
               $commune = $electeur->commune;
               $data["commune"] = $commune;
           }

           $validationResult = self::proValidation(new Parrainage($data),$electeur);
            if($validationResult["all_fields_match"]){

                $parti = Parti::partiOfCurrentUser();
                $has_endpoint = $parti->hasEndpoint();

                if ($has_endpoint) {
                    $url = $parti->end_point."parrainages";
                    return $this->submitDataToPolexApi($data, $url);
                }else{
                    return  Parrainage::create($data);
                }

            }else{
                $primoVotant = isset($data["primo"]) && $data["primo"];
                $url = $parti->end_point."parrainages";

                if ($primoVotant){
                    if (!request()->user()->hasRole("owner") && !request()->user()->hasRole("supervisor")){
                        abort(403,"Seuls les admins ou superviseurs sont autorisés à enregistrer des données non validées comme les primo votants");
                    }
                    if (Parti::partiOfCurrentUser()->hasEndpoint()) {

                    return $this->submitDataToPolexApi($data, $url);}
                    else {
                        return Parrainage::create($data);
                    }
                }
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
        $isDiasporaElecteur = strtolower($parrainage->region) == "diaspora" || self::isDiasporaRegion($parrainage->region);
        if ($electeur == null){
            //no match
            return ["has_match"=>false, "all_fields_match"=> false, "fields"=>[]];
        }else{
             $result = [
                "has_match"=>true,
                "all_fields_match"=>
                    strtolower(trim($parrainage->prenom)) == strtolower(trim($electeur->prenom))
                    && strtolower(trim($parrainage->nom)) == strtolower(trim($electeur->nom))
                    && ($electeur->nin == null || trim($parrainage->nin) == trim($electeur->nin))
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
            $item["user_id"] = request()->user()->id;

            return $item;
        }, $data);

        $parti = Parti::partiOfCurrentUser();
        $has_endpoint = $parti->hasEndpoint();

        if ($has_endpoint) {
            $url = $parti->end_point.'parrainages/excel';

            $response = Http::withHeaders([
                self::jsonHeaders
            ])->post($url,["data"=>$dataWithoutDiscriminantFieldName]);
            if ($response->successful()){
                return response()->json(json_decode($response->body(),true));
            }else{
                return response()->json(["message"=>"Une erreur","detail"=>$response->body()],500);

            }

        }else{

            $total = Parrainage::insertOrIgnore($dataWithoutDiscriminantFieldName);
        }


        return response()->json(["total_inserted"=>$total]);


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
            $electeur = DB::table($table_name)->select(["prenom","nom","nin","num_electeur","region","commune"])
                ->where("nin",$parrainage["nin"])
                ->orWhere("num_electeur",$parrainage["num_electeur"])
                ->first();
            $validationResult = ParrainageController::proValidation(new Parrainage($parrainage),$electeur);
            if ($validationResult["has_match"] && $validationResult["all_fields_match"]){
                $parrainage["commune"] = $electeur->commune;
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

            $query = DB::table($table_name)->select(["prenom","nom","nin","num_electeur","region","commune"]);
            $electeur = $query
                ->where("nin", trim($parrainage["nin"]))
                ->orWhere("num_electeur", trim($parrainage["num_electeur"]))
                    ->first();


            if ($electeur != null){
                $corrected  = [];
                $corrected["prenom"] = $electeur->prenom;
                $corrected["nom"] = $electeur->nom;
                $corrected["nin"] = $electeur->nin;
                $corrected["num_electeur"] = $electeur->num_electeur;
                $corrected["date_expir"] = $parrainage["date_expir"];
                $corrected["region"] =  $electeur->region;
                $corrected["commune"] = $electeur->commune;

                $parrainagesCorriges[] = $corrected;
            }else{
                $parrainagesNonCorriges [] = $parrainage;

            }
        }


        return ["parrainagesCorriges"=>$parrainagesCorriges, "parrainagesNonCorriges"=>$parrainagesNonCorriges];

    }

    public function findForAutocomplete($param)
    {
        $electeur = DB::table("electeurs")->select(["prenom","nom","nin","num_electeur","region","commune"])
            ->where(DB::raw("TRIM(nin)"),$param)
            ->orWhere(DB::raw("TRIM(num_electeur)"),$param)
            ->first();
        if ($electeur == null){
            return response()->json(['message'=>'not found'],404);
        }
        $electeur->date_expir = null;
//        $electeur->region = ParrainageController::isDiasporaRegion($electeur->region)
//            ?
//            "DIASPORA": $electeur->region;
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
                    ->orWhere(DB::raw("TRIM(num_electeur)"),$param)
                    ->first();
                return ["already_exists"=>$parrainage != null, "electeur"=>$electeur];

            }

        }
        return $electeur;
    }

    /**
     * @param array $data
     * @param string $url
     * @return JsonResponse
     */
    public function submitDataToPolexApi(array $data, string $url): JsonResponse
    {
        try {
            $data["user_id"] = request()->user()->id;
            unset($data["primo"]);
            $response = Http::withHeaders(self::jsonHeaders)
                ->post($url, $data);
            $response->throw();
            if ($response->successful()) {
                return response()->json(json_decode($response->body(), true));
            } else {
                return response()->json(["message" => "Une erreur", "detail" => json_decode($response->body(), true)], 500);

            }
        } catch (RequestException $e) {
            if ($e->response->unprocessableEntity()) {
                return response()->json(json_decode($e->response->body(), true), 422);

            } else
                return response()->json(["message" => "Une erreur from Polex api", "detail" => json_decode($e->response->body(), true)], 500);

        }
    }

    public function exportCriteria()
    {
        return \response()->json(["users"=>Parti::partiOfCurrentUser()->user()->get()]);
    }
    public function searchParrainage(Request $request){
        function rejectResponseForMissingQuery($message) : JsonResponse{
            return \response()->json(["message"=>$message], 422);

        }
        $searchCriteria = $request->query("criteria");
        $dateStart = $request->query("dateStart");
        $dateStart = $dateStart == "null" ? null: $dateStart;
        $dateEnd = $request->query("dateEnd");
        $dateEnd = $dateEnd == "null" ? null: $dateEnd;
        if ($searchCriteria == null){
            return rejectResponseForMissingQuery("Aucun critère de recherche défini !");
        }
        $query = null;
        switch($searchCriteria){
            case "parrainages_today": $query = Parrainage::whereDate("created_at",Carbon::today()->toDateString());
            break;
            case "parrainages_date_interval":
                if ($dateStart == null){
                    return rejectResponseForMissingQuery("Vous avez choisi le critère <<Parrainages par intervalle>> sans précisé la date de début ! ");
                }
                if ($dateEnd == null){
                   return rejectResponseForMissingQuery("Vous avez choisi le critère <<Parrainages par intervalle>> sans préciser la date de fin ! ");
                }
                $query = Parrainage::query();

            break;
            case "parrainages_region":
                $region = $request->query("region");
                if ($region == null){
                    return rejectResponseForMissingQuery('Vous avez choisi le critère "Recherche par région" sans préciser la région ! ');

                }
                $query = Parrainage::whereRegion($region);
            break;
            case "parrainages_departement":
                $region = $request->query("departement");
                $query = Parrainage::whereRegion($region);
            break;
            case "parrainages_commune":
                $commune = $request->query("commune");
                if ($commune == null){
                    return rejectResponseForMissingQuery('Vous avez choisi le critère "Recherche par commune" sans préciser la commune ! ');

                }
                $query = Parrainage::whereCommune($commune);
            break;
            //http://localhost:8888/Polex/PolexBackend/public/api/parrainages/search?criteria=parrainages_by_user?user_id=1?region=null?departement=null?commune=null?dateStart=null?dateEnd=null
            case "parrainages_by_user":
                $user_id = $request->query("user_id");
                if ($user_id == null){
                    return rejectResponseForMissingQuery('Vous avez choisi le critère "Recherche par opérateur de saisie" sans préciser l\'utilisateur ! ');

                }
                $query = Parrainage::whereUserId($user_id);
            break;
            case "parrainages_by_user_interval":
                $user_id = $request->query("user_id");
                if ($user_id == null){
                    return rejectResponseForMissingQuery('Vous avez choisi le critère "Recherche par opérateur dans intervalle de date" sans préciser l\'utilisateur ! ');

                }
                if ($dateStart == null){
                    return rejectResponseForMissingQuery('Vous avez choisi le critère "Parrainages par utilisateur dans une intervalle de date" sans préciser la date de début ! ');
                }
                if ($dateEnd == null){
                    return rejectResponseForMissingQuery('Vous avez choisi le critère "Parrainages par utilisateur dans une intervalle de date" sans préciser la date de fin ! ');
                }

            break;
            default: return rejectResponseForMissingQuery("Critère de recherche inconnu ! ");

        }
        if ($query instanceof Builder){
            if ($dateStart != null && $dateEnd != null){
                $query->whereDate("created_at",'>=', $dateStart)
                    ->whereDate("created_at",'<=', $dateEnd);
            }
            $query->orderBy('created_at');
            $sql = $query->toSql();

// Get the bindings
            $bindings = $query->getBindings();

// Replace placeholders with actual values
            foreach ($bindings as $binding) {
                $sql = preg_replace('/\?/', "'$binding'", $sql, 1);
            }
            try {

                $url = Parti::partiOfCurrentUser()->end_point . "parrainages/search";
                $response = Http::withHeaders(ParrainageController::jsonHeaders)->post($url, ["secret" => "2022", "query" => $sql]);
                $response->throw();
                $results = $response->object();

                if (count($results) == 0) {
                    return \response()->json(["message" => "Aucun résultat trouvé !"], 404);
                }
                $results = array_map(function ($item){
                    $user = User::whereId($item->user_id)->first();
                    $item->saisi_par  = $user != null ? $user->name : 'Inconnu';
                    return $item;
                },$results);
                return $results;
            } catch (RequestException $e) {
               return json_decode($e->response->body());

            }
        }
        return \response()->json(["message"=>"Aucune recherche effectuée en fonction des critères"],404);


    }

    /**
     * @throws RequestException
     */
    public function delete($parrainage_id)
    {
        try {
            if ( ! \request()->user()->hasRole('owner')){
                abort(403,"Vous n'etes pas autorisé à supprimer un parrainage !");
            }
            $parti = Parti::partiOfCurrentUser();
            $response = Http::withHeaders(self::jsonHeaders)
                ->delete($parti->end_point .'parrainages/delete/'. $parrainage_id,["secret" => "2022"]);
            $response->throw();
            if ($response->successful()){
                return \response()->json(['message'=>'deleted'],204);
            }
        } catch (RequestException $e) {
            return response()->json(['message'=>$e->response->body()],500);
        }

    }
}
