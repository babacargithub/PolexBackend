<?php

namespace App\Http\Controllers;

use App\Models\CarteMembre;
use App\Models\Membre;
use App\Models\Structure;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $data = [
            'nombre_cartes' => CarteMembre::count(),
            'nombre_membres' => Membre::count(),
            'nombre_cellules'=> Structure::whereType('Cellule')->count(),
            'nombre_sections'=> Structure::whereType('Section')->count(),
            'nombre_coordinations'=> Structure::whereType('Coordination')->count(),
            'nombre_structures_alliees'=> Structure::whereType('Structure Alliée')->count(),
            'nombre_federations'=> Structure::whereType('Fédération')->count(),
            'nombre_mouvements_internes'=> Structure::whereType('Mouvement Interne')->count(),
            'nombre_autres'=> Structure::whereType('Autre')->count(),
            'nombre_membres_crees_aujourdhui'=> Membre::whereDate('created_at', today())->count(),
            'nombre_membres_crees_semaine'=> Membre::whereBetween('created_at', [today()->startOfWeek(), today()->endOfWeek()])->count(),
            'nombre_membres_crees_mois'=> Membre::whereMonth('created_at', today()->month)->count(),
            'nombre_membres_crees_annee'=> Membre::whereYear('created_at', today()->year)->count(),

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
}
