<?php

use App\Http\Controllers\CarteMembreController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MembreController;
use App\Http\Controllers\PartiController;
use App\Http\Controllers\PvBureauController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\TypeMembreController;
use App\Models\Parti;
use App\Models\PartiUser;
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
    Route::group(["prefix" => "dashboard/"],function (){
        Route::get("",[DashboardController::class,"index"]);
        Route::get("structures",[DashboardController::class,"structures"]);

    });
    Route::get("membres_commune/{commune}", [MembreController::class,'membresCommune']);
    Route::resource("membres", MembreController::class);
    Route::resource("structures", StructureController::class);
    Route::resource("cartes", CarteMembreController::class);
    Route::resource("types_membre", TypeMembreController::class);

    Route::group(["prefix" => "elections/"],function (){
        Route::get("departements_region/{region}",[PvBureauController::class,'getListDepartementsRegion']);
        Route::get("communes_departement/{departement}",[PvBureauController::class,'getListCommuneDepartements']);
        Route::get("centres_commune/{commune}",[PvBureauController::class,'getListCentresCommune']);
        Route::get("bureaux_centre/{centre}",[PvBureauController::class,'getListBureauxCentre']);
        Route::get("pv_bureaux/{pvBureau}",[PvBureauController::class,'show']);
        Route::get("candidats",[PvBureauController::class,'listCandidats']);
        Route::post("pv_bureaux",[PvBureauController::class,'store']);
        Route::post("pv_centres",[PvBureauController::class,'storePvCentre']);

        //=================== Resultats ===================
        Route::get("resultats",[PvBureauController::class,'resultatsGlob']);
        Route::get("resultats/regions",[PvBureauController::class,'resultatsRegions']);
        Route::get("resultats/region/{region}",[PvBureauController::class,'getListBureauxCentre']);
        Route::get("resultats/departements",[PvBureauController::class,'resultatsDepartements']);
        Route::get("resultats/departement/{departement}",[PvBureauController::class,'getListBureauxCentre']);
        Route::get("resultats/commune/{commune}",[PvBureauController::class,'getListBureauxCentre']);
        Route::get("resultats/centre/{centre}",[PvBureauController::class,'getListBureauxCentre']);
        Route::get("resultats/bureau/{bureau}",[PvBureauController::class,'getListBureauxCentre']);

    });



});

