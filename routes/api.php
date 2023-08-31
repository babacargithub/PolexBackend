<?php

use App\Http\Controllers\ParrainageController;
use App\Models\Electeur;
use App\Models\Formule;
use App\Models\Parrainage;
use App\Models\Parti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

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
        $token = request()->user()->createToken("name", [], Carbon::now()->addDays(30));
//        $parti  = Parti::where('user_id', request()->user()->id)->first();
        //TODO make dynamic
        $parti  = Parti::first();

        $parti["has_pro"] = $parti->formule->has_pro_validation;
        $parti["discriminantField"] = [
                     'label'=> "Année de Naissance ",
                      'name'=> 'annee_naiss',
                      'type'=> "text",
                      'maxLength'=> 4,
                      'minLength'=> 4,
                      'regex'=> '/\[d]*/',
        ];

        return response(["token"=>$token,"parti"=>$parti]);
    }else{

        return response("Invalid credentials")->setStatusCode(401);
    }

});

Route::get('parrainages//region/{region}', function ($region){
    //TODO make dynamic
    $parti_id = 1;
    // TODO check if current user owns the data
    return Parrainage::wherePartiId($parti_id)->whereRegion($region)->limit(10000)->paginate(1000);
});
Route::post('parrainages/excel', function (){

    $data = request()->json('data');

    if (count($data) <1000){
        $dataWithoutDiscriminantFieldName = array_map(function ($item) {
            //TODO make dynamic
            $parti_id = 1;
            $item = array_diff_key($item, array_flip(['discriminantFieldName']));
            $item["parti_id"] = $parti_id;
            return $item;
        }, $data);
        Parrainage::insert($dataWithoutDiscriminantFieldName);
    }

    return response()->json(["total_inserted"=>count($data),"duplicates"=>count($data)]);
})->withoutMiddleware("throttle:api");
Route::post('parrainages/bulk_pro_validation', function (){

    $data = request()->json('parrainages');
    $region = request()->json('region');
    $parrainagesValides= [];
    $parrainagesInvalides= [];
        foreach ($data as $parrainage) {
            //TODO ADD DISCRIMINANT
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
                    $errors[] = "Introuvable dans le fichier électoral";
                }
                $parrainage ["raison"] = implode(", ",$errors);
                $parrainagesInvalides[] = $parrainage;
            }
        }


    return ["parrainagesInvalides"=>$parrainagesInvalides, "parrainagesValides"=>$parrainagesValides];
})->withoutMiddleware("throttle:api");
Route::apiResource("parrainages", ParrainageController::class);

