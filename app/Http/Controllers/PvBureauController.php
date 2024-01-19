<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePvBureauRequest;
use App\Http\Requests\UpdateResultatRequest;
use App\Models\Candidat;
use App\Models\Centre;
use App\Models\Commune;
use App\Models\Departement;
use App\Models\PvCentre;
use App\Models\Region;
use App\Models\ResultatBureau;
use App\Models\PvBureau;
use App\Models\ResultatCentre;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
    public function storePvCentre(Request $request)
    {
        //
        $data = $request->validate([
            'centre_id' => 'required|integer|exists:centres,id|unique:pv_centres,centre_id',
            'votants' => 'required|integer',
            'suffrages_exprimes' => 'required|integer',
            'bulletins_nuls' => 'required|integer',
            'inscrits' => 'required|integer',
            'resultats' => [
                'required',
                'array',
                //TODO un comment
//                'size:21', // Ensure the array has exactly 21 items
                // Add any other rules specific to the "resultats" array items if needed
            ],
            'resultats.*.candidat_id' => 'required|integer|exists:candidats,id',
            'resultats.*.nombre_voix' => 'required|integer',
        ],[
            'centre_id.unique' => 'Les résultats de ce centre ont déjà été enregistrés dans Polex',
        ]);
        // Create and save the main model

        $pv_bureau = PvCentre::create([
            'centre_id' => $data['centre_id'],
            'votants' => $data['votants'],
            'suffrages_exprimes' => $data['suffrages_exprimes'],
            'bulletins_nuls' => $data['bulletins_nuls'],
            'inscrits' => $data['inscrits'],
        ]);

        // Save the related "resultats" entries
        $resultatsData = $data['resultats'];
        $resultats = [];

        foreach ($resultatsData as $resultatData) {
            $resultats[] = new ResultatCentre([
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
        $candidats = Candidat::all();
        $resultats = $candidats->map(function (Candidat $candidat){
            return [
                "id"=>$candidat->id,
                "nom"=>$candidat->nom,
                "photo"=>'storage/'.$candidat->photo,
                "nombre_voix"=>rand(1000,9999)
            ];
        });
        return  $resultats;
            //TODO uncomment
//        return \DB::select("SELECT candidats.id,candidats.nom,candidats.photo, SUM(resultats_bureaux.nombre_voix) as nombre_voix FROM candidats,resultats_bureaux WHERE candidats.id = resultats_bureaux.candidat_id GROUP BY candidats.id, candidats.nom,candidats.photo ORDER BY nombre_voix DESC");

    }

    public function resultatsRegions()
    {
        //
        $resultatsRegions = [];
        $regions = Region::all();
        foreach ($regions as $region ) {
            $resultats = \DB::select("SELECT  c.nom, SUM(rb.nombre_voix) as nombre_voix FROM resultats_bureaux as rb
                                        INNER  JOIN pv_bureaux  pvb ON pvb.id = rb.pv_bureau_id
                                        INNER JOIN candidats  c ON c.id = rb.candidat_id
                                        INNER  JOIN bureaux  b ON b.id = pvb.bureau_id
                                        INNER  JOIN centres  ct ON ct.id = b.centre_id
                                        INNER  JOIN communes  com ON com.id = ct.commune_id
                                        INNER  JOIN departements  d ON d.id = com.departement_id
                                        INNER  JOIN regions  r ON r.id = d.region_id
                                        WHERE rb.pv_bureau_id = pvb.id AND r.id = $region->id
                                        GROUP BY c.nom, d.nom
                                        ORDER BY nombre_voix DESC"
            );
            if (count($resultats) > 0) {
                $resultatsDepartements[$region->nom] = $resultats;
            }

        }
        return response($resultatsDepartements);

    }
    public function resultatsDepartements()
    {
        //
        $resultatsDepartements = [];
        $departements = Departement::all();
        foreach ($departements as $departement ) {
            $resultats = \DB::select("SELECT  c.nom, SUM(rb.nombre_voix) as nombre_voix FROM resultats_bureaux as rb
                                        INNER  JOIN pv_bureaux  pvb ON pvb.id = rb.pv_bureau_id
                                        INNER JOIN candidats  c ON c.id = rb.candidat_id
                                        INNER  JOIN bureaux  b ON b.id = pvb.bureau_id
                                        INNER  JOIN centres  ct ON ct.id = b.centre_id
                                        INNER  JOIN communes  com ON com.id = ct.commune_id
                                        INNER  JOIN departements  d ON d.id = com.departement_id
                                        WHERE rb.pv_bureau_id = pvb.id AND d.id = $departement->id
                                        GROUP BY c.nom, d.nom
                                        ORDER BY nombre_voix DESC"
            );
            if (count($resultats) > 0) {
                $resultatsDepartements[$departement->nom] = $resultats;
            }

        }
        return response($resultatsDepartements);

    }
    public function resultatsCentreAggreges(Centre $centre)
    {
        //
        $resultatsCentre
         = \DB::select("SELECT  c.nom, SUM(rc.nombre_voix) as nombre_voix FROM resultat_centres as rc
                                        INNER  JOIN pv_centres  pvc ON pvc.id = rc.pv_centre_id
                                        INNER JOIN candidats  c ON c.id = rc.candidat_id
                                        INNER  JOIN centres  ct ON ct.id = pvc.centre_id
                                        WHERE rc.pv_centre_id = pvc.id AND ct.id = $centre->id
                                        GROUP BY c.nom, ct.nom
                                        ORDER BY nombre_voix DESC"
        );

        return  $resultatsCentre;

    }

    public function resultatsCommuneAggreges(Commune $commune)
    {
        //
        return \DB::select("SELECT  c.nom, SUM(rb.nombre_voix) as nombre_voix FROM resultats_bureaux as rb
                                       INNER  JOIN pv_bureaux  pvb ON pvb.id = rb.pv_bureau_id
                                       INNER JOIN candidats  c ON c.id = rb.candidat_id
                                       INNER  JOIN bureaux  b ON b.id = pvb.bureau_id
                                       INNER  JOIN centres  ct ON ct.id = b.centre_id
                                       INNER  JOIN communes  com ON com.id = ct.commune_id
                                       WHERE rb.pv_bureau_id = pvb.id AND com.id = $commune->id
                                       GROUP BY c.nom, com.nom
                                       ORDER BY nombre_voix DESC"
       );

    }

}
