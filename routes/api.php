<?php

use App\Http\Controllers\BureauController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\CarteElectoralController;
use App\Http\Controllers\CarteMembreController;
use App\Http\Controllers\CollecteController;
use App\Http\Controllers\CommuneController;
use App\Http\Controllers\CotizController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MembreController;
use App\Http\Controllers\PartiController;
use App\Http\Controllers\PvBureauController;
use App\Http\Controllers\RepresBureauController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\SmsBatchController;
use App\Http\Controllers\SondageController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\TypeMembreController;
use App\Models\Commune;
use App\Models\Cotiz;
use App\Models\Departement;
use App\Models\Membre;
use App\Models\Parti;
use App\Models\PartiUser;
use App\Models\PvBureau;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/**
 * @return Application|ResponseFactory|\Illuminate\Http\Response
 */
function loginResponse(): ResponseFactory|Application|\Illuminate\Http\Response
{
    $token = request()->user()->createToken("name", [], Carbon::now()->addDay());
//        $parti  = Parti::where('user_id', request()->user()->id)->first();
    $parti = Parti::partiOfCurrentUser();
    $params = [];

    $partis_that_disable_date_expir_repeat = ['Pape '];

    $parti["has_pro"] = true;
    $parti["has_correction"] = true;
    $parti["has_autocomplete"] = true;
    $parti["repeat_date_expir"] = ! in_array($parti->nom, $partis_that_disable_date_expir_repeat);

    $roles = [];
    foreach (request()->user()->roles as $role) {
        $roles[] = $role->name;

    }
    $permissions = [];
    /*foreach (request()->user()->permissions as $permission) {
        $roles[] = $permission->name;

    }*/
    $user = request()->user();
    return response(["token" => $token, "parti" => $parti, "params" => $params,
        "user" => [
            "email" => $user->email,
            "token" => $token->plainTextToken,
            "tokenExpiresAt" => $token->accessToken->expires_at,
            "name" => $user->name,
            "roles" => $roles,
            "permissions" => $permissions,
            "isAuthenticated" => true
        ],
        "should_change_password" => (Hash::check("0000", $user->password) || Hash::check("1234", $user->password))
    ]);
}
Route::post('/upload_pv/{pvBureau}', function (PvBureau $pvBureau, Request $request) {
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $pvBureau->setPhotoAttribute($file);
        $pvBureau->save();
        return response()->json('submitted', 200);
    } else {
        return response()->json(['message'=>'Aucun fichier soumis !'], 422);
    }

})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class,'auth:sanctum']);


Route::post('/login', function (Request $request){
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);
    if (Auth::attempt($credentials)) {
        $request->validate([
            'email' => [function($attribute,$value, $fail){
                if (request()->user()->disabled){
                    $fail("Compte désactivé !");
                    Auth::logout();
                }
            }],
        ]);
        return loginResponse();
    }else{

        return response("Invalid credentials")->setStatusCode(401);
    }

});

Route::middleware(["auth:sanctum"])->group(function() {
    Route::get('users', function (Request $request){

        if (! $request->user()->hasPermissionTo('user-crud')){
            abort(403,"Action non autorisée");
        }
        return Parti::partiOfCurrentUser()->users;
    });
    Route::post('users/create', function (Request $request){

       if (! $request->user()->hasPermissionTo('user-crud')){
           abort(403,"Action non autorisée");
       }
        $validated = $request->validate([
            "email"=>"required|email|unique:users",
            "name"=>"required|string"
        ]);
        $user = new User($validated);
        $user->password = Hash::make("0000");
        $user->email_verified_at = null;
        $user->assignRole("writer");
        $user->save();
        $parti = Parti::partiOfCurrentUser();
        $parti_user = new PartiUser();
        $parti_user->user_id = $user->id;
        $parti_user->parti_id = $parti->id;
        $parti_user->save();

        return $user;
    });
    Route::post('users/change_password', function (Request $request){

        $validated = $request->validate([
            "oldPassword"=>"required",
            "newPassword"=>"required",
            "repeatedPassword"=>"required"
        ]);

        $user = $request->user();
        $user->password = Hash::make($validated["newPassword"]);
        $user->save();
        Auth::user()->tokens->each(function ($token) {
            $token->delete();
        });


        return loginResponse();
    });
    Route::put("users/{user}/promote",[PartiController::class,"promoteUser"]);
    Route::put("users/{user}/disable",[PartiController::class,"disableUser"]);
    Route::delete("users/{user}/delete",[PartiController::class,"deleteUser"]);
    Route::put("users/{user}/reset_password",[PartiController::class,"resetUserPassword"]);
    Route::put("users/{user}/add_role/{role}",[PartiController::class,"userAddRole"]);
    Route::put("users/{user}/remove_role/{role}",[PartiController::class,"removeUserRole"]);
    // =================== DASHBOARD ===================
    Route::group(["prefix" => "dashboard/"],function (){
        Route::get("",[DashboardController::class,"index"]);
        Route::get("cartographie",[DashboardController::class,"cartographie"]);
        Route::get("structures",[DashboardController::class,"structures"]);

    });
    // =================== MEMBRES ===================
    Route::prefix("membres/")->group(function (){
       Route::get('/responsables',[MembreController::class,'getListResponsables']);
       Route::get('/categorie/{categorie}',[MembreController::class,'listMembresCategorie']);

       Route::get('structure/{structure}',[MembreController::class,'membresStructure']);
       Route::put('{membre}/attribuer_carte/{numeroCarte} ',[CarteMembreController::class,'attribuerUneCarteAUnMembre']);
    });
    // =================== STRUCTURES ===================

    Route::group(["prefix" => "structures/"],function (){

        Route::put("{structure}/designer_responsable/{membre}",[StructureController::class,'designerResponsable']);
        Route::get("departement/{departement}",[StructureController::class,'getListeStructuresDepartement']);
        Route::get("region/{region}",[StructureController::class,'getListeStructuresRegion']);
        Route::get("commune/{departement}/{commune}",[StructureController::class,'getListeStructuresCommune']);
    });
    // =================== CARTES ===================
    Route::group(["prefix" => "cartes/"],function (){
        Route::post("attribuer_lot/{membre}",[CarteMembreController::class,'attribuerLotCarte']);
        Route::post("creer_lot_carte",[CarteMembreController::class,'creerLotCarte']);
        Route::get("types_cartes/list",[CarteMembreController::class,'listTypeCartes']);
        Route::put("{carte}/membre/{membre}",[CarteMembreController::class,'attribuerUneCarteAUnMembre']);
        Route::get("lots/list",[CarteMembreController::class,'listDesLotsDeCarte']);
//        Route::get("{carte}",[CarteMembreController::class,'show']);
//        Route::post("{membre}",[CarteMembreController::class,'attribuerLotCarte']);
//        Route::put("{carte}",[CarteMembreController::class,'update']);
//        Route::delete("{carte}",[CarteMembreController::class,'destroy']);
    });

    // =================== SONDAGES ===================
    Route::group(["prefix" => "sondages/"],function (){
        Route::get("",[SondageController::class,'index']);
        Route::post("creer",[SondageController::class,'store']);
        Route::get("{sondage}/questions",[SondageController::class,'questions']);
        Route::post("{sondage}/ajouter_question",[SondageController::class,'ajouterQuestion']);
        Route::post("questions/{question}/ajouter_reponse",[SondageController::class,'ajouterReponseAUneQuestion']);
        Route::put("{sondage}",[SondageController::class,'update']);
        Route::put("modifier_question/{question}",[SondageController::class,'modifierQuestion']);
        Route::put("modifier_reponse_autorisee/{reponse}",[SondageController::class,'modifierReponseAutorisee']);
        Route::delete("supprimer_question/{question}",[SondageController::class,'supprimerQuestion']);
        Route::delete("supprimer_reponse/{reponse}",[SondageController::class,'supprimerReponse']);
        Route::delete("{sondage}",[SondageController::class,'destroy']);
        Route::get("{sondage}/resultats",[SondageController::class,'resultats']);
        Route::get("{sondage}/reponses",[SondageController::class,'reponses']);
        Route::post("{sondage}/vote",[SondageController::class,'saveResponse']);

    });
 // =================== FINANCES ===================
    Route::group(["prefix" => "finances/"],function (){
        // ==== cotisations ====
        Route::post("cotisations",[CotizController::class,'store']);
        Route::get("cotisations",[CotizController::class,'index']);
        Route::put("cotisations/{cotiz}",[CotizController::class,'update']);
        Route::post("cotisations/{cotiz}/verser",[CotizController::class,'addVersement']);
        Route::get("cotisations/{cotiz}/versements",[CotizController::class,'versements']);
        Route::get("cotisations/{cotiz}/membre/{membre}",function (Cotiz $cotiz, Membre $membre){
            return response()->json(["membre"=>$membre,"cotiz"=>$cotiz]);
        });
        Route::post("cotisations/{cotiz}/envoyer_message_paiement",[CotizController::class,'envoyerMessagePaiement']);
        Route::get("cotisations/{cotiz}",[CotizController::class,'show']);

        // ===== collecte =======
        Route::group(["prefix" => "collectes/"],function (
        ){  Route::get("",[CollecteController::class,'index']);
            Route::post("",[CollecteController::class,'store']);
            Route::get("{collecte}/participants",[CollecteController::class,'participants']);
            Route::post("collectes",[CollecteController::class,'store']);
            Route::get("{collecte}",[CollecteController::class,'show']);
            Route::put("{collecte}",[CollecteController::class,'update']);
            Route::delete("{collecte}",[CollecteController::class,'delete']);
            Route::post("{collecte}/participer",[CollecteController::class,'addParticipant']);
        });

        // =======  Caisse =======
        Route::group(["prefix" => "caisse/"],function (){

            Route::get("caisse_principale",[CaisseController::class,'index']);
            Route::get("depenses",[CaisseController::class,'depenses']);
            Route::post("new_depense",[CaisseController::class,'addDepense']);
            Route::post("new_revenue",[CaisseController::class,'addRevenue']);
            Route::get("revenues",[CaisseController::class,'revenues']);

           });
        // =======  Ventes =======
        Route::group(["prefix" => "ventes/"],function (){

            Route::get("recettes",[RevenueController::class,'recettesVentesCartes']);


           });

    });

    // =================== SMS ===================

    Route::group(["prefix" => "sms/"],function (){
        Route::post("send",[SmsBatchController::class,'sendSMS']);
        Route::get("batches",[SmsBatchController::class,'index']);
        Route::post("batches",[SmsBatchController::class,'store']);
        Route::put("batch_items/{batchItem}/send",[SmsBatchController::class,'sendBatchItem']);
        Route::get("batches/{batch}",[SmsBatchController::class,'show']);
        Route::put("batches/{batch}",[SmsBatchController::class,'update']);
        Route::delete("batches/{batch}",[SmsBatchController::class,'delete']);
        Route::post("batches/{batch}/send",[SmsBatchController::class,'send']);
        Route::post("batches/{batch}/send_one/{item}",[SmsBatchController::class,'sendOne']);

        Route::post('liste_destinataires',[SmsBatchController::class,'getListDestinataires']);
        Route::get('type_destinataires',[SmsBatchController::class,'getDataPourTypesDestinataires']);
    });

    // =================== DEPARTEMENTS ===================

    Route::group(["prefix" => "departements/"],function (){

        Route::get("",[PvBureauController::class,'getListDepartements']);
        Route::get("{departement}/structures",function (Departement $departement){
            $departement->load("structures");
            return $departement->structures;
        });
    });

    // =================== Elections ===================
    Route::group(["prefix" => "elections/"],function (){
        Route::get("departements_region/{region}",[PvBureauController::class,'getListDepartementsRegion']);
        Route::get("communes_departement/{departement}",[PvBureauController::class,'getListCommuneDepartements']);
        Route::get("centres_commune/{departement}/{commune}",[PvBureauController::class,'getListCentresCommune']);
        Route::get("bureaux_centre/{centre}",[PvBureauController::class,'getListBureauxCentre']);
        Route::get("pv_bureaux/{pvBureau}",[PvBureauController::class,'show']);
        Route::get("candidats",[PvBureauController::class,'listCandidats']);
        Route::post("pv_bureaux",[PvBureauController::class,'store']);
        Route::put("pv_bureaux/certifier/{pvBureau}",function (PvBureau $pvBureau){
            $pvBureau->certifie = true;
            $pvBureau->save();
            return $pvBureau;
        });
        Route::post("pv_centres",[PvBureauController::class,'storePvCentre']);
        Route::get("elections/carte_electorale",[CarteElectoralController::class,'index']);

        // ========== Bureaux ==========
        Route::get("bureaux",[BureauController::class,'index']);
        Route::get("bureaux_centre/{commune}/{centre}",function ($commune, $centre){

            $commune = Commune::whereNom($commune)->firstOrFail();
            $centre = $commune->centres()->whereNom($centre)->firstOrFail();
            $centre->load("bureaux");
            $centre->bureaux->load('pvBureau');
            if (\request()->query('with_representant')){
                $centre->bureaux->load('representant');
            }
            return $centre->bureaux;
        });
        Route::get("bureaux/representants",[RepresBureauController::class,'listRepres']);
        Route::delete("bureaux/representants/{represBureau}",[RepresBureauController::class,'destroy']);
        Route::get("bureaux/representants/index",[RepresBureauController::class,'index']);
        Route::post("bureaux/representants",[RepresBureauController::class,'store']);
        Route::put("bureaux/designer_representant/{bureau}/{representant}",[BureauController::class,'designerRepresentant']);
        Route::post("bureaux",[PvBureauController::class,'storeBureau']);
        Route::put("bureaux/{bureau}",[PvBureauController::class,'updateBureau']);
        Route::delete("bureaux/{bureau}",[PvBureauController::class,'deleteBureau']);
        // ========== Centres ==========
        Route::get("centres",[PvBureauController::class,'getListCentres']);
        Route::get("centres/{centre}",[PvBureauController::class,'showCentre']);
        Route::post("centres",[PvBureauController::class,'storeCentre']);
        Route::put("centres/{centre}",[PvBureauController::class,'updateCentre']);

        //=================== Resultats ===================
        Route::get("resultats",[PvBureauController::class,'resultatsGlob']);
        Route::get("pv_remontes",[PvBureauController::class,'pvRemontes']);
        Route::get("resultats_detailles",[PvBureauController::class,'resultatsDetailles']);
        Route::get("resultats/regions",[PvBureauController::class,'resultatsRegions']);
        Route::get("resultats/region/{region}",[PvBureauController::class,'getListBureauxCentre']);
        Route::get("resultats/departements",[PvBureauController::class,'resultatsDepartements']);
        Route::get("resultats/departement/{departement}",[PvBureauController::class,'getListBureauxCentre']);
        Route::get("resultats/communes/{commune}",[PvBureauController::class,'resultatsCommuneAggreges']);
        Route::get("resultats/centres/{centre}",[PvBureauController::class,'resultatsCentreAggreges']);
        Route::get("resultats/bureau/{bureau}",[PvBureauController::class,'getListBureauxCentre']);
        Route::get("carte_electorale",[CarteElectoralController::class,'index']);

    });
    // =================== Type membre ===================
    Route::group(["prefix" => "organigramme/"],function (){
        Route::get("",[TypeMembreController::class,'organigramme']);
        Route::put("",[TypeMembreController::class,'organigrammeUpdate']);

    });


    // =================== RESOURCES ===================
    Route::get("membres_commune/{commune}", [MembreController::class,'membresCommune']);
    Route::resource("membres", MembreController::class);
    Route::resource("communes", CommuneController::class);
    Route::resource("cartes", CarteMembreController::class);
    Route::resource("types_membre", TypeMembreController::class);
    Route::resource("structures", StructureController::class);
});

