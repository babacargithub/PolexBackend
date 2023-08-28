<?php

use App\Http\Controllers\ParrainageController;
use App\Models\Electeur;
use App\Models\Parti;
use Illuminate\Http\Request;
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
        $parti  = Parti::first();

        return response(["token"=>$token,"parti"=>$parti]);
    }else{

        return response("Invalid credentials")->setStatusCode(401);
    }

});

Route::get('parrainages/{parti}/region/{region}', function (Parti $parti){

    // TODO check if current user owns the data
    return Electeur::where("nom","MBACKE")->limit(10000)->paginate(1000);
});
Route::post('parrainages/excel', function (){

    $data = json_decode(request()->input('data'), true);

    foreach ($data as $index=> $parrainage) {
        $parrainage["taille"] = $parrainage["discriminant"];
        unset($parrainage["discriminant"]);
        $data[$index] = $parrainage;

    }
    \App\Models\Parrainage::insert($data);
    return $data;
});
Route::apiResource("parrainages", ParrainageController::class);
