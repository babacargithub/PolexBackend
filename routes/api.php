<?php

use App\Http\Controllers\ParrainageController;
use App\Models\Company;
use App\Models\Params;
use App\Models\Parrainage;
use App\Models\Parti;
use App\Models\User;
use App\Policies\RoleNames;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
 */
function loginResponse(): \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\Response
{
    $token = request()->user()->createToken("name", [], Carbon::now()->addDay());
//        $parti  = Parti::where('user_id', request()->user()->id)->first();
    $parti = Parti::partiOfCurrentUser();
    $params = Params::getParams();

    $parti["has_pro"] = $parti->formule->has_pro_validation;
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
       /* $request->validate([
            'email' => [function($attribute,$value, $fail){
                if (request()->user()->disabled){
                    $fail("Compte désactivé !");
                    Auth::logout();
                }
            }],
        ]);*/
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
        $parti_user = new \App\Models\PartiUser();
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

    Route::get('parrainages/region/{region}', function ($region){

        $parti_id = Parti::partiOfCurrentUser()->id;
        return Parrainage::wherePartiId($parti_id)->whereRegion($region)->paginate(1000);
    });
    Route::post('parrainages/excel', function (){

        $data = request()->json('data');
        $dataWithoutDiscriminantFieldName = array_map(function ($item) {
            $parti_id = Parti::partiOfCurrentUser()->id;
            $item = array_diff_key($item, array_flip(['discriminantFieldName']));
            $item["parti_id"] = $parti_id;
            return $item;
        }, $data);
        Parrainage::insert($dataWithoutDiscriminantFieldName);

        return response()->json(["total_inserted"=>count($data),"duplicates"=>/* TODO change this later */count($data)]);
    })->withoutMiddleware("throttle:api");
    Route::post('parrainages/bulk_pro_validation', function (){

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
    })->withoutMiddleware("throttle:api");
    Route::apiResource("parrainages", ParrainageController::class);

});

