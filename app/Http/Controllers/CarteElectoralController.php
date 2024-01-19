<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarteElectoralController extends Controller
{
    //
    public function index()
    {
       return [
           "electeurs"=> [
               "DAKAR"=> 1230033,
            "THIES"=> 1230033,
            "SAINT-LOUIS"=> 1230033,
            "KAOLACK"=> 1230033,
            "DIOURBEL"=> 1230033,
            "LOUGA"=> 1230033,
            "TAMBACOUNDA"=> 1230033,
            "FATICK"=> 1230033,
            "KAFFRINE"=> 1230033,
            "SEDHIOU"=> 1230033,
            "KEDOUGOU"=> 1230033,
            "MATAM"=> 1230033,
            "ZIGUINCHOR"=> 1230033,
            "KOLDA"=> 1230033,
               "DIASPORA"=> 1230033,
               ],
           "stats"=>[
               "inscrits"=>"7351805",
               "hommes"=> "3675902",
                "femmes"=> "3675903",
               "moins_de_35_ans"=> "3675903",
               "entre_35_et_55_ans"=> "3675903",
               "nombre_bureaux"=> 1483939,
                "nombre_centres"=> 234494,
           ]
       ];
    }
}
