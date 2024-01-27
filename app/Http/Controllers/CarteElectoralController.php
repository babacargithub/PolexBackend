<?php

namespace App\Http\Controllers;

use App\Models\Bureau;
use App\Models\Centre;
use App\Models\Commune;
use App\Models\Departement;
use App\Utils\CarteElectoralData;
use Illuminate\Http\Request;

class CarteElectoralController extends Controller
{



    //
    public function index()
    {
        $nombresInscrit = CarteElectoralData::NOMBRE_INSCRITS;
       return [
           "electeurs"=>
           array_map(function($item) use($nombresInscrit){
               return [
                    'region'=>$item["region"],
                    'inscrits'=> $item["total"],
                   "pourcentage"=> floatval(number_format(($item["total"]*100/$nombresInscrit), 3, '.', ''))
               ];
           },
              CarteElectoralData::REGIONS),
           "departements"=>
           array_map(function($item)use($nombresInscrit){
               return [

                    'region'=>Departement::whereNom($item["departement"])->first()?? null,
                    'departement'=>$item["departement"],
                    'inscrits'=> $item["total"],
                   "pourcentage"=> floatval(number_format(($item["total"]*100/$nombresInscrit), 3, '.', ''))
               ];
           },
              CarteElectoralData::DEPARTEMENTS),
           "communes"=>
           array_map(function($item)use($nombresInscrit){
               return [
                    'region'=>$item["region"],
                    'departement'=>$item["departement"],
                    'commune'=>$item["commune"],
                    'inscrits'=> $item["total"],
                   "pourcentage"=> floatval(number_format(($item["total"]*100/$nombresInscrit), 3, '.', ''))
               ];
           },
              CarteElectoralData::COMMUNES),
           "stats"=>[
               "inscrits"=> $nombresInscrit,
               "hommes"=> 3319429,
                "femmes"=> 3303179,
               'sexe indeterminé par Polex'=>	364218,
                "pourcentage_hommes"=> round(3319429*100/$nombresInscrit,2),
                "pourcentage_femmes"=> round(3303179*100/$nombresInscrit,2),
                "pourcentage_non_determiné"=> round(364218*100/$nombresInscrit,2),
               'moins_de_25_ans'=> 346576,
                'entre_25_et_30_ans'=> 1144749,
                'entre_30_et_40_ans'=> 1916196,
                'entre_40_et_50_ans'=> 1512396,
                'entre_50_et_60_ans'=> 1089406,
                'plus_de_60_ans'=> 1062553,

               "nombre_bureaux"=> Bureau::count(),
                "nombre_centres"=> Centre::count(),
                "nombre_communes"=> Commune::count(),
           ]
       ];
    }
}
