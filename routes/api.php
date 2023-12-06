<?php

use App\Http\Controllers\ParrainageController;
use App\Http\Controllers\PartiController;
use App\Models\Params;
use App\Models\Parrainage;
use App\Models\Parti;
use App\Models\PartiUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
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
    $params = Params::getParams();

    $partis_that_disable_date_expir_repeat = ['Pape '];

    $parti["has_pro"] = $parti->formule->has_pro_validation;
    $parti["has_correction"] = true;
    $parti["has_autocomplete"] = true;
    $parti["repeat_date_expir"] = ! in_array($parti->nom, $partis_that_disable_date_expir_repeat);

    $parti["discriminantField"] = json_decode($params->discriminant_field);
    $params->discriminant_field = json_decode($params->discriminant_field);
    $roles = [];
    foreach (request()->user()->roles as $role) {
        $roles[] = $role->name;

    }
    $permissions = [];
    foreach (request()->user()->permissions as $permission) {
        $roles[] = $permission->name;

    }
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
        Auth::user()->tokens->each(function ($token, $key) {
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
    Route::get("export_criteria",[ParrainageController ::class,"exportCriteria"]);
    Route::get("parrainages/search",[ParrainageController ::class,"searchParrainage"]);
    Route::delete("parrainages/{parrainage_id}/delete",[ParrainageController ::class,"delete"]);
    Route::delete("parrainages/bulk_delete",[ParrainageController ::class,"bulkDelete"]);
    Route::post("parrainages/identify",[ParrainageController ::class,"bulkIdentify"]);
    Route::get("parrainages/user_report/{user}",[ParrainageController ::class,"userReport"]);

    Route::get('parrainages/region/{region}', function ($region){

        $parti = Parti::partiOfCurrentUser();
        $parti_id = $parti->id;
        if ($parti->has_debt ){
          abort(403,"L'état de votre compte ne permet pas de faire cette opération. Contactez l'équipe de Polex");

        }
        if (Parti::partiOfCurrentUser()->hasEndpoint()) {
            $url = Parti::partiOfCurrentUser()->end_point."parrainages/region/" . $region . "?page=" . request()->query('page');
            $response = Http::withHeaders(ParrainageController::jsonHeaders)
                ->get($url);
            if ($response->successful()) {
                return json_decode($response->body());
            } else {
                return response()->json(["une erreur s'est produite !"], 500);
            }
        }
        return Parrainage::wherePartiId($parti_id)->whereRegion($region)->orderBy("created_at")->paginate(1000);
    });
    Route::get('parrainages/autocomplete/{param}',[ParrainageController::class,'findForAutocomplete']);
    Route::post('parrainages/excel', [ParrainageController::class,"bulkInsertFromExcel"])
        ->withoutMiddleware("throttle:api");
    Route::post('parrainages/bulk_pro_validation',[ParrainageController::class,'bulkProValidation'])
        ->withoutMiddleware("throttle:api");
    Route::post('parrainages/bulk_correction',[ParrainageController::class,'bulkCorrection'])
        ->withoutMiddleware("throttle:api");
    Route::put('parrainages/update/{num_electeur}',[ParrainageController::class,'update']);

    Route::apiResource("parrainages", ParrainageController::class);

});

