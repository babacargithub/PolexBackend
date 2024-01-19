<?php

namespace App\Http\Controllers;

use App\Models\CarteMembre;
use App\Models\Departement;
use App\Models\LotCarte;
use App\Models\Membre;
use App\Models\Region;
use App\Models\Structure;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $regionData = $this->getRegionData();
        $data = [
            'nombre_cartes' => CarteMembre::whereNotNull("membre_id")->count(),
            'nombre_membres' => Membre::count(),
            'nombre_cellules'=> Structure::whereType('Cellule')->count(),
            'nombre_sections'=> Structure::whereType('Section')->count(),
            'nouveaux_membres'=> Membre::whereDate('created_at',today()->toDateString())->count(),
            //TODO uncomment latet
            /*'nombre_structures_alliees'=> Structure::whereType('Structure Alliée')->count(),
            'nombre_federations'=> Structure::whereType('Fédération')->count(),
            'nombre_mouvements_internes'=> Structure::whereType('Mouvement Interne')->count(),
            'nombre_autres'=> Structure::whereType('Autre')->count(),
            'nombre_membres_crees_aujourdhui'=> Membre::whereDate('created_at', today())->count(),
            'nombre_membres_crees_semaine'=> Membre::whereBetween('created_at', [today()->startOfWeek(), today()->endOfWeek()])->count(),
            'nombre_membres_crees_mois'=> Membre::whereMonth('created_at', today()->month)->count(),
            'nombre_membres_crees_annee'=> Membre::whereYear('created_at', today()->year)->count(),*/
            //TODO uncomment latet
           /* "Structure vedette"=> \DB::select( 'SELECT st.nom, COUNT(*) AS nombre FROM membres
                                    INNER JOIN structures st ON membres.structure_id = st.id
                                     GROUP BY st.nom
                                     ORDER BY st.nom  DESC LIMIT 1'),*/
            "structures" => [
                "Cellule" => Structure::whereType('Cellule')->count(),
                "Section" => Structure::whereType('Section')->count(),
                "Coordination" => Structure::whereType('Coordination')->count(),

            ],
            "cartes" => [
                "Nombre Lots"=> LotCarte::count(),
                "Nombre vendu" => CarteMembre::whereNotNull("membre_id")->count(),
                "Nombre en stock" =>CarteMembre::whereNull("membre_id")->count(),

            ],

            "regions"=> $regionData,
            "membres"=>\DB::select( 'SELECT tm.nom, COUNT(*) AS nombre FROM membres
                                   INNER JOIN type_membres tm ON membres.type_membre_id = tm.id
                                     GROUP BY tm.nom
                                     ORDER BY tm.nom'),

        ];
        return $data;
    }

    public function structures()
    {

        $structures = \DB::select( 'SELECT st.nom, st.commune, COUNT(*) AS nombre FROM membres m
                                  INNER JOIN structures st ON m.structure_id = st.id
                                  GROUP BY st.nom, commune');
        $commune = \DB::select( 'SELECT commune, COUNT(*) AS nombre FROM membres GROUP BY commune');

        return [
            'structures' => $structures,
            'commune' => $commune
        ];
    }
    public function membres()
    {

        $membres_stats = \DB::select( 'SELECT st.membre_id, COUNT(*) AS nombre FROM membres m
                                  INNER JOIN structures st ON m.structure_id = st.id
                                  GROUP BY st.membre_id');
        $commune = \DB::select( 'SELECT commune, COUNT(*) AS nombre FROM membres GROUP BY commune');

        return [
            'membres_stats' => $membres_stats,
            'commune' => $commune
        ];
    }
    public function regions(){
        $communes = \DB::select( 'SELECT commune, COUNT(*) AS nombre FROM membres GROUP BY commune');

    }
    public function cartographie()
    {
         $DEPARTEMENT_FROM_MAPS = [
        "Salémata",
        "Kédougou",
        "Tambacounda",
        "Nioro du rip",
        "Kaolack",
        "Guinguinéo",
        "Bakel",
        "Birkelane",
        "Mbour",
        "Koumpentoum",
        "Koungheul",
        "Goudiry",
        "Malem-Hodar",
        "Gossas",
        "Thiès",
        "Dakar",
        "Mbacké",
        "Diourbel",
        "Guédiawaye",
        "Pikine",
        "Bambey",
        "Rufisque",
        "Tivaouane",
        "Kébémer",
        "Linguère",
        "Kanel",
        "Louga",
        "Ranérou",
        "Matam",
        "Saint-Louis",
        "Podor",
        "Dagana",
        "Oussouye",
        "Ziguinchor",
        "Bignona",
        "Sédhiou",
        "Goudomp",
        "Kolda",
        "Médina-Yorofoula",
        "Bounkiling",
        "Vélingara",
        "Foundiougne",
        "Saraya",
        "Kaffrine",
        "Fatick"];

         $departementsData = \DB::select( 'SELECT d.nom, COUNT(*) AS nombre FROM membres
                                    INNER JOIN structures st ON membres.structure_id = st.id
                                    INNER JOIN  communes c ON st.commune_id = c.id
                                    INNER JOIN  departements d ON c.departement_id = d.id
                                     GROUP BY d.nom
                                     ORDER BY d.nom');
         $departementsStructures = \DB::select( 'SELECT d.nom, COUNT(*) AS nombre FROM structures st
                                    INNER JOIN  communes c ON st.commune_id = c.id
                                    INNER JOIN  departements d ON c.departement_id = d.id
                                     GROUP BY d.nom
                                     ORDER BY d.nom');
         $departementsNom = array_map(function ($item){
                return  $item->nom;
            },$departementsData);
         $departementsCellulesNom = array_map(function ($item){
                return  $item->nom;
            },$departementsStructures);

         $donnesOK = [];

        foreach ($DEPARTEMENT_FROM_MAPS as $name) {
            $name_transformed = strtoupper(str_replace("-"," ",str_replace("è","e", str_replace("é","e", $name))));
            $item = [];
            if(in_array($name_transformed,$departementsNom)){
                $item["membres"] =  $departementsData[array_search($name_transformed,$departementsNom)]->nombre;
            }else{
                $item["membres"] =  0;
            }
            if(in_array($name_transformed,$departementsCellulesNom)){
                //TODO uncomment later
//                $item["cellules"] = $departementsData[array_search($name_transformed,$departementsCellulesNom)]->nombre;
                $item["cellules"] = 122;
            }else{
                $item["cellules"] =  0;
            }
            if (count($item) > 0) {
                $item["nom"] = $name;
                $donnesOK[] = $item;
            }
        }
        return [
            "regions"=> $this->getRegionData(),
            "departements"=> $donnesOK,
            "communes"=> \DB::select( 'SELECT c.nom, COUNT(*) AS nombre FROM membres
                                    INNER JOIN structures st ON membres.structure_id = st.id
                                    INNER JOIN  communes c ON st.commune_id = c.id
                                     GROUP BY c.nom
                                     ORDER BY c.nom'),

        ];

    }

    /**
     * @return array
     */
    public function getRegionData(): array
    {
        $REGIONS_FROM_MAPS = ["Kédougou",
            "Tambacounda",
            "Kaolack",
            "Thiès",
            "Dakar",
            "Diourbel",
            "Louga",
            "Matam",
            "Saint-Louis",
            "Ziguinchor",
            "Sédhiou",
            "Kolda",
            "Kaffrine",
            "Fatick"];
        $regions = Region::all();
        $regionData = [];
        foreach ($regions as $region) {
            $membres = \DB::select('SELECT  COUNT(*) AS nombre FROM membres
                                    INNER JOIN structures st ON membres.structure_id = st.id
                                    INNER JOIN  communes c ON st.commune_id = c.id
                                    INNER JOIN  departements d ON c.departement_id = d.id
                                    INNER JOIN  regions r ON d.region_id = r.id
                                   WHERE r.id = ?', [$region->id]);
            $cellules = \DB::select('SELECT  COUNT(*) AS nombre FROM structures st
                                    INNER JOIN  communes c ON st.commune_id = c.id
                                    INNER JOIN  departements d ON c.departement_id = d.id
                                    INNER JOIN  regions r ON d.region_id = r.id
                                      WHERE r.id = ?', [$region->id]);

            $regionData[] = [
                "nom" => $region->nom,
                "membres" => $membres[0]->nombre ?? 0,
                "cellules" => $cellules[0]->nombre ?? 0,
            ];
        }
        $regionDataTransformed = [];
        foreach ($REGIONS_FROM_MAPS as $name) {
            $name_transformed = strtoupper(str_replace("-"," ",str_replace("è","e", str_replace("é","e", $name))));
            $item = [];
            if(in_array($name_transformed,array_map(function ($item){
                    return  $item["nom"];
                },$regionData))){
                $item["membres"] =  $regionData[array_search($name_transformed,array_map(function ($item){
                        return  $item["nom"];
                    },$regionData))]["membres"];
                $item["cellules"] =  $regionData[array_search($name_transformed,array_map(function ($item){
                        return  $item["nom"];
                    },$regionData))]["cellules"];
            }
            else{
                $item["membres"] =  0;
                $item["cellules"] =  0;
            }
            $item["nom"] = $name;
            $regionDataTransformed[] = $item;
        }
        return $regionDataTransformed;
    }
}
