<?php

namespace App\Http\Controllers;

use App\Models\Bureau;
use App\Models\CarteMembre;
use App\Models\Centre;
use App\Models\Commune;
use App\Models\Departement;
use App\Models\LotCarte;
use App\Models\Membre;
use App\Models\Region;
use App\Models\Structure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
            "structuration_politique"=> $this->structurationPolitique(),
            "structuration_electorale"=> $this->structurationElectorale(),
            'dernieres_notifications'=>$this->getDernieresNotifications(),
            // TODO MAKE THIS DYNAMIC
            "objectif_massif_mensuel"=> 34,
            "top_structures"=> \DB::select('SELECT st.nom, COUNT(*) AS nombre FROM membres m
                                  INNER JOIN structures st ON m.structure_id = st.id
                                  GROUP BY st.nom
                                  ORDER BY nombre DESC
                                  LIMIT 5'),
            "evolution_adhesions_et_ventes_cartes"=> $this->evolutionAdhesionsEtVentesCartes(),
            "origine_des_membres"=> $this->origineDesMembres()
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

         $departementsMembres = \DB::select( 'SELECT d.nom, COUNT(*) AS nombre FROM membres
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
        $departementsMembresFormatted =[] ;
        $departementsStructuresFormatted =[] ;
        foreach ($departementsMembres as $departementsMembre) {
            $departementsMembresFormatted[ $departementsMembre->nom] = $departementsMembre;

        }
        foreach ($departementsStructures as $departementsStructure) {
            $departementsStructuresFormatted[ $departementsStructure->nom] = $departementsStructure;

        }



         $donnesOK = [];

        foreach ($DEPARTEMENT_FROM_MAPS as $name) {
            $name_transformed = strtoupper(str_replace("-"," ",str_replace("è","e", str_replace("é","e", $name))));
            $item = [];
            if(in_array($name_transformed,array_keys($departementsMembresFormatted))){
                $item["membres"] =  $departementsMembresFormatted[$name_transformed]->nombre;
            }else{
                $item["membres"] =  0;
            }
            if(in_array($name_transformed,array_keys($departementsStructuresFormatted))){

                $item["cellules"] =  $departementsStructuresFormatted[$name_transformed]->nombre;
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
            //TODO CHANGE LATER
//            "communes"=> \DB::select( 'SELECT c.nom, COUNT(*) AS nombre FROM membres
//                                    INNER JOIN structures st ON membres.structure_id = st.id
//                                    INNER JOIN  communes c ON st.commune_id = c.id
//                                     GROUP BY c.nom
//                                     ORDER BY c.nom'),
        "communes"=>Region::all()->map(function ($region){
            return [
                "nom"=>$region->nom,
                "departements"=>$region->departements()->get()->map(function ($departement){
                    return[
                        "nom"=>$departement->nom,
                        "communes"=>$departement->communes()->get()->map(function ($commune){
                            return [
                                "nom"=>$commune->nom,
                                // TODO make dynamique later
                                "coordonnateurs_communaux"=> 0,
                                "responsables_de_section"=> 0,
                                "responsables_de_cellule"=> 0,
                                "cellules"=> $commune->structures()->count(),
                                "membres"=> $commune->membres()->count(),
                                "cartes_vendues"=>0,


                            ];

                        })
                    ];
                }
                )

            ];

        }),
            'zones_non_representes'=> $this->communesEtRegionsFaibles(),
            'cartographie_electorale'=> $this->cartographieElectorale()


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

    private function getDernieresNotifications()
    {
        $structures = Structure::with('commune.departement.region')->orderByDesc('created_at')->limit(10)->get();

        $notifications = [];

        foreach ($structures as $structure) {
            $notifications[] = [
                "label" => "Structure crée : ". $structure->nom,
                "created_at" => $structure->created_at,
                'type_notif'=>"structure",
                'extra_data'=>[  "id" => $structure->id,
                    "structure" => $structure->nom,
                    "type" => $structure->type,
                    "commune" => $structure->commune->nom,
                    "departement" => $structure->commune->departement->nom,
                    "region" => $structure->commune->departement->region->nom,
                    "date_creation" => $structure->created_at],
            ];
        }

        return $notifications;

    }

    private function structurationElectorale()
    {
        $nombre_required = [
            "Mandataire national"=> 1,
            'Plénipotentiaire'=> 132 + Departement::count(),
            "Plénipotentiaire de département"=> Departement::count(),
            "Plénipotentiaire d'arrondissement"=> 132,
            'Représentant de centre'=> Centre::count(),
            'Représentant de bureau'=> Bureau::count(),

        ];

        $data = DB::select('SELECT tm.nom, COUNT(*) AS nombre FROM membres m
                                  INNER JOIN type_membres tm ON m.type_membre_id = tm.id
                                  LEFT JOIN organigrammes og ON og.type_membre_id = tm.id
                                   WHERE tm.nom IN  (SELECT nom FROM type_membres INNER JOIN organigrammes ON type_membres.id = organigrammes.type_membre_id WHERE type_organigramme = "electorale")
                                  GROUP BY tm.nom, og.position
                                  ORDER BY og.position');
        foreach ($data as $index=>$datum) {
            $data[$index] = [
                "nom"=>$datum->nom,
                "nombre"=>$datum->nombre,
                "nombre_requis"=> $nombre_required[$datum->nom] ?? 0,
                "pourcentage"=>isset($nombre_required[$datum->nom]) ? round(($datum->nombre/$nombre_required[$datum->nom])*100,2): 0.0
            ];
        }

      return $data;
    }

    private function evolutionAdhesionsEtVentesCartes()
    {


        $currentMonth = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        $data = [];

        foreach ($currentMonth->weeksUntil($currentMonthEnd) as $index=>$week) {
            $is_last = count($currentMonth->weeksUntil($currentMonthEnd)) == $index+1;
            $start = clone $week;
            $end =  !$is_last ? $week->addDays(6) : $week->addDays($currentMonthEnd->day - $week->day);

            $periodStart = $start->toDateString();
            $periodEnd = $end->toDateString();
            $label = "Semaine du ".$start->format('d'). " au ".$end->format('d');


            $data[] = [
                "periode"=>$label,
                "nouveaux_membres"=> Membre::whereBetween('created_at', [$periodStart, $periodEnd])
                        ->count(),
                "cartes_vendues"=>CarteMembre::whereBetween('created_at', [$periodStart, $periodEnd])
                ->count()
            ];
        }
       return  $data;

    }

    private function origineDesMembres()
    {
        //TODO change later
        return [
            ["value"=>10, "name"=>"Adhérants en ligne"],
            ["value"=>60, "name"=>"Inscrit par des responsables"],
            ["value"=>20, "name"=>"Aliés"],
            ["value"=>10, "name"=>"Autres"],

        ];
    }
    public function communesEtRegionsFaibles()
    {
        $communesRepresentes = Structure::select('commune_id')->pluck('commune_id')->toArray();
        $departementsRepresentes = Commune::select('departement_id')
            ->whereIn('id', $communesRepresentes)
            ->get()->pluck('departement_id')->toArray();
        $departementsNonRepresentes = Departement::with('region')->whereNotIn('id', $departementsRepresentes)->get()->map(function ($departement){
            return [
                "nom"=>$departement->nom,
                "region"=>$departement->region->nom
            ];
        })->groupBy('region');
        $regionsRepresentes = Departement::select('region_id')
            ->whereIn('id', $departementsRepresentes)
            ->get()->pluck('region_id')->toArray();

        $communesNonRepresentes = Region::all()->map(function (Region $region) use ($communesRepresentes){
        return [
            "nom"=>$region->nom,
            "departements"=>$region->departements()->get()->map(function ($departement) use($communesRepresentes){
                return[
                    "nom"=>$departement->nom,
                    "communes"=>$departement->communes()
                        ->whereNotIn('id',$communesRepresentes)->get()->map(function ($commune){
                        return [
                            "nom"=>$commune->nom
                        ];

                    })
                ];
            }
            )

        ];

    });

        return [
            "departements"=>$departementsNonRepresentes,
            "communes"=>$communesNonRepresentes
        ];


    }

    private function cartographieElectorale()
    {
        $organigramme_electoral = DB::select('SELECT tm.nom, COALESCE(m.nombre, 0) AS nombre
                                  FROM type_membres tm
                                  LEFT JOIN (
                                      SELECT type_membre_id, COUNT(*) AS nombre
                                      FROM membres
                                      GROUP BY type_membre_id
                                  ) m ON m.type_membre_id = tm.id
                                  LEFT JOIN organigrammes og ON og.type_membre_id = tm.id
                                  WHERE og.type_organigramme LIKE "electorale"
                                  GROUP BY tm.nom, nombre, og.position
                                  ORDER BY og.position');
        return ["resume" => $organigramme_electoral, 'departements_representes'=>[], 'departements_non_representes'=>[],'arrondissements_representes'=>[],'arrondissements_non_representes'=>[]];


    }

    /**
     * @return array
     */
    public function structurationPolitique(): array
    {
        return DB::select('SELECT tm.nom, COUNT(*) AS nombre FROM membres m
                                  INNER JOIN type_membres tm ON m.type_membre_id = tm.id
                                  LEFT JOIN organigrammes og ON og.type_membre_id = tm.id
                                   WHERE tm.nom IN  (SELECT nom FROM type_membres INNER JOIN organigrammes ON type_membres.id = organigrammes.type_membre_id WHERE type_organigramme = "politique")
                                  GROUP BY tm.nom, og.position
                                  ORDER BY og.position');
    }
}
