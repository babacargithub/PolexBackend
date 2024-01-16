<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePvBureauRequest;
use App\Http\Requests\UpdateResultatRequest;
use App\Models\Candidat;
use App\Models\Centre;
use App\Models\Commune;
use App\Models\Departement;
use App\Models\Region;
use App\Models\ResultatBureau;
use App\Models\PvBureau;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class PvBureauController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $resultats = PvBureau::all();
        return response($resultats);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePvBureauRequest $request
     * @return Response
     */
    public function store(StorePvBureauRequest $request)
    {
        //
        $data = $request->validated();
        // Create and save the main model

        $pv_bureau = PvBureau::create([
            'bureau_id' => $data['bureau_id'],
            'votants' => $data['votants'],
            'suffrages_exprimes' => $data['suffrages_exprimes'],
            'bulletins_null' => $data['bulletins_null'],
            'inscrits' => $data['inscrits'],
        ]);

        // Save the related "resultats" entries
        $resultatsData = $data['resultats'];
        $resultats = [];

        foreach ($resultatsData as $resultatData) {
            $resultats[] = new ResultatBureau([
                'candidat_id' => $resultatData['candidat_id'],
                'nombre_voix' => $resultatData['nombre_voix'],
            ]);
        }

        $pv_bureau->resultats()->saveMany($resultats);

        return $pv_bureau;

    }    /**
     * Store a newly created resource in storage.
     *
     * @param StorePvBureauRequest $request
     * @return Response
     */
    public function storePvCentre(\Request $request)
    {
        //
        $data = $request->validated();
        // Create and save the main model

        $pv_bureau = PvBureau::create([
            'bureau_id' => $data['bureau_id'],
            'votants' => $data['votants'],
            'suffrages_exprimes' => $data['suffrages_exprimes'],
            'bulletins_null' => $data['bulletins_null'],
            'inscrits' => $data['inscrits'],
        ]);

        // Save the related "resultats" entries
        $resultatsData = $data['resultats'];
        $resultats = [];

        foreach ($resultatsData as $resultatData) {
            $resultats[] = new ResultatBureau([
                'candidat_id' => $resultatData['candidat_id'],
                'nombre_voix' => $resultatData['nombre_voix'],
            ]);
        }

        $pv_bureau->resultats()->saveMany($resultats);

        return $pv_bureau;

    }

    /**
     * Display the specified resource.
     *
     * @param PvBureau $pvBureau
     * @return Builder|Model|object
     */
    public function show(PvBureau $pvBureau)
    {
        //
        return  $pvBureau
            ->with('bureau')
            ->with('resultats')
            ->first();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateResultatRequest $request
     * @param PvBureau $pvBureau
     * @return Response
     */
    public function update(UpdateResultatRequest $request, PvBureau $pvBureau)
    {
        //
        $data = $request->validated();
        $pvBureau->update($data);
        return  $pvBureau;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PvBureau $pvBureau
     * @return Response
     */
    public function destroy(PvBureau $pvBureau)
    {
        //
        $pvBureau->delete();
        return response(null, 204);

    }
    public function getListDepartementsRegion(Region $region)
    {
        //
        $region->load('departements');
        return response($region->departements);
     }
     public function getListCommuneDepartements(Departement $departement)
    {
        //
        $departement->load('communes');
        return response($departement->communes);
     }
 public function getListCentresCommune(Commune $commune)
    {
        //
        $commune->load('centres');
        $commune->centres->load('bureaux');
        return response($commune->centres);

    }

    public function listCandidats()
    {
        return response(Candidat::all());

    }
    public function getListBureauxCentre(Centre $centre)
    {
        //
        $centre->load('bureaux');
        return response($centre->bureaux);

    }
    public function resultatsGlob()
    {
        //
      return \DB::select("SELECT candidats.id,candidats.nom,candidats.photo, SUM(resultats.nombre_voix) as nombre_voix FROM candidats,resultats WHERE candidats.id = resultats.candidat_id GROUP BY candidats.id, candidats.nom,candidats.photo ORDER BY nombre_voix DESC");

    }
}
