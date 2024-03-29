<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePvBureauRequest;
use App\Http\Requests\UpdateResultatRequest;
use App\Models\Bureau;
use App\Models\Candidat;
use App\Models\Centre;
use App\Models\Commune;
use App\Models\Departement;
use App\Models\Membre;
use App\Models\PvCentre;
use App\Models\Region;
use App\Models\ResultatBureau;
use App\Models\PvBureau;
use App\Models\ResultatCentre;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use LaravelIdea\Helper\App\Models\_IH_PvBureau_QB;

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
            'typeable_id' => $data['typeable_id'],
            'typeable_type' => $data['type_pv'] == 'bureau' ? Bureau::class : ($data['type_pv'] == 'centre' ? Centre::class : ($data['type_pv'] == 'commune' ? Commune::class : Departement::class)),
            'votants' => $data['votants'],
            'suffrages_exprimes' => $data['suffrages_exprimes'],
            'bulletins_nuls' => $data['bulletins_nuls'],
            'inscrits' => $data['inscrits'],
            'region_id' => $data['region_id'],
            'departement_id' => $data['departement_id'],

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
    public function getListCentresCommune($departement, $commune)
    {
        //
        $commune = Commune::whereNom($commune)
            ->whereRelation('departement','nom',$departement)
            ->firstOrFail();


        return response( $commune->centres()->withCount('bureaux')->get()->map(function ($centre) use($commune){
            return [
                'id' => $centre->id,
                'nom' => $centre->nom,
                "commune"=> $commune->nom,
                'representant'=> $centre->representant,
                'nombre_bureaux' => $centre->bureaux_count,
            ];
        }));

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
        $idsOfPvToSum = $this->getCalculatedPvBureaux();

        $results = ResultatBureau::selectRaw('candidat_id, sum(nombre_voix) as total')
            ->with('candidat')
            ->whereIn('pv_bureau_id', $idsOfPvToSum)
            ->groupBy('candidat_id')
            ->orderByDesc('total')
            ->get();



        return array_map(function ($result) use ($idsOfPvToSum ){
            return [
                "nom"=>$result['candidat']['nom'],
                "photo"=>'storage/'.$result['candidat']['photo'],
                "parti"=>$result['candidat']['parti'],
                "nombre_voix"=>intval($result['total']),
                "pourcentage"=>round((intval($result['total']) *100)/\DB::table('resultats_bureaux')->whereIn('pv_bureau_id',$idsOfPvToSum)->sum('nombre_voix'),2)
            ];
        },$results->toArray());
    }
    public function resultatsDetailles()
    {

        $nombre_bureau = Bureau::count();
        $nombre_bureau_remonte = PvBureau::where('typeable_type', Bureau::class)->count();
        $nombre_centre = Centre::count();
        $nombre_departement = Departement::count();
        $statsRemontesPv =[
            "nombre_bureau"=> $nombre_bureau,
            "nombre_bureau_remonte"=>$nombre_bureau_remonte,
            "nombre_bureau_restant"=> Bureau::count() - PvBureau::where('typeable_type', Bureau::class)->count(),
            'pourcentage_bureau_remonte'=>round(PvBureau::where('typeable_type', Bureau::class)->count()*100 / $nombre_bureau,2),
            "nombre_centre"=> $nombre_centre,
            "nombre_centre_remonte"=> PvBureau::where('typeable_type', Centre::class)->count(),
            "nombre_centre_restant"=> Centre::count() - PvBureau::where('typeable_type', Centre::class)->count(),
            "pourcentage_centre_remonte"=>round(PvBureau::where('typeable_type', Centre::class)->count()*100 / $nombre_centre,2),
            "nombre_departement"=> $nombre_departement,
            "nombre_departement_remonte"=> PvBureau::where('typeable_type', Departement::class)->count(),
            "nombre_departement_restant"=>$nombre_departement - PvBureau::where('typeable_type', Departement::class)->count(),
            "pourcentage_departement_remonte"=>round(PvBureau::where('typeable_type', Departement::class)->count()*100 / $nombre_departement,2),
        ];

        $idsOfPvToSum = $this->getCalculatedPvBureaux();
        $results = DB::table('pv_bureaux')
            ->join('resultats_bureaux', 'pv_bureaux.id', '=', 'resultats_bureaux.pv_bureau_id')
            ->join('regions', 'pv_bureaux.region_id', '=', 'regions.id')
            ->join('candidats', 'resultats_bureaux.candidat_id', '=', 'candidats.id')
            ->whereIn('pv_bureaux.id', $idsOfPvToSum)
            ->select('regions.nom as region_nom', 'candidats.nom', 'candidats.photo',
                DB::raw('SUM(resultats_bureaux.nombre_voix) as nombre_voix'),
                DB::raw('(SELECT SUM(rb.nombre_voix)
                               FROM resultats_bureaux rb
                               JOIN pv_bureaux pb ON rb.pv_bureau_id = pb.id
                               WHERE pb.region_id = regions.id) as total_voix_region'),
                'regions.id') // Include regions.id in the selection.
            ->groupBy('regions.nom', 'candidats.nom', 'candidats.photo', 'regions.id') // Add regions.id to the GROUP BY clause.
            ->get();

// Step 2: Process the results to include the percentage.
        $resultatsParRegions = $results->groupBy('region_nom')
            ->map(function ($items) {
                $totalVotes = $items->sum('nombre_voix'); // This should match total_voix_region if calculated correctly.
                return $items->map(function ($item) use ($totalVotes) {
                    $percentage = ($item->nombre_voix / $item->total_voix_region) * 100; // Calculate percentage based on total votes per region
                    return [
                        'nom' => $item->nom,
                        'photo' => 'storage/' . $item->photo,
                        'pourcentage' => round($percentage, 2), // Round the percentage to 2 decimal places
                        'nombre_voix' => intval($item->nombre_voix)
                    ];
                });
            });


        $resultsDepartements =  DB::table('pv_bureaux')
            ->join('resultats_bureaux', 'pv_bureaux.id', '=', 'resultats_bureaux.pv_bureau_id')
            ->join('departements', 'pv_bureaux.departement_id', '=', 'departements.id') // Change from regions to departements
            ->join('candidats', 'resultats_bureaux.candidat_id', '=', 'candidats.id')
            ->whereIn('pv_bureaux.id', $idsOfPvToSum)
            ->select('departements.nom as departement_nom', 'candidats.nom', 'candidats.photo', // Change from regions.nom to departements.nom
                DB::raw('SUM(resultats_bureaux.nombre_voix) as nombre_voix'),
                DB::raw('(SELECT SUM(rb.nombre_voix)
                               FROM resultats_bureaux rb
                               JOIN pv_bureaux pb ON rb.pv_bureau_id = pb.id
                               WHERE pb.departement_id = departements.id) as total_voix_departement'), // Change the subquery to focus on departements
                'departements.id') // Change from regions.id to departements.id
            ->groupBy('departements.nom', 'candidats.nom', 'candidats.photo', 'departements.id') // Change the GROUP BY clause to target departements
            ->get();

        $resultatsParDepartements = $resultsDepartements->groupBy('departement_nom')
            ->map(function ($items) {
                $totalVotes = $items->sum('nombre_voix'); // This remains the same, as it's a sum of votes within the grouping
                return $items->map(function ($item) use ($totalVotes) {
                    $percentage = ($item->nombre_voix / $item->total_voix_departement) * 100; // Change from total_voix_region to total_voix_departement
                    return [
                        'nom' => $item->nom,
                        'photo' => 'storage/' . $item->photo,
                        'pourcentage' => round($percentage, 2), // No change needed here
                        'nombre_voix' => intval($item->nombre_voix) // No change needed here
                    ];
                });
            });
       $resultsCommunes =  collect(DB::select("SELECT
    cnd.nom,
    cnd.photo,
    combined.commune,
    SUM(combined.nombre_voix) AS total_voix,
    -- Calculate percentage using a subquery for total voix per commune to ensure alignment with GROUP BY
    (SUM(combined.nombre_voix) / (
        SELECT SUM(inner_combined.nombre_voix)
        FROM (
            SELECT cm.nom AS commune, rb.nombre_voix
            FROM pv_bureaux pb
            JOIN centres c ON pb.typeable_id = c.id AND pb.typeable_type LIKE '%Centre%'
            JOIN communes cm ON cm.id = c.commune_id
            JOIN resultats_bureaux rb ON rb.pv_bureau_id = pb.id
            UNION ALL
            SELECT cm.nom AS commune, rb.nombre_voix
            FROM pv_bureaux pb
            JOIN bureaux b ON pb.typeable_id = b.id AND pb.typeable_type LIKE '%Bureau%'
            JOIN centres c ON b.centre_id = c.id
            JOIN communes cm ON cm.id = c.commune_id
            JOIN resultats_bureaux rb ON rb.pv_bureau_id = pb.id
            WHERE NOT EXISTS (
                SELECT 1
                FROM pv_bureaux pb2
                WHERE pb2.typeable_type LIKE '%Centre%'
                AND pb2.typeable_id = c.id
            )
        ) AS inner_combined
        WHERE inner_combined.commune = combined.commune
    ) * 100) AS percentage
FROM (
    -- Your UNION ALL subquery remains unchanged
  SELECT
        pb.id AS pb_id,
        c.id AS centre_id,
        cm.id AS commune_id,
        cm.nom AS commune,
        rb.candidat_id,
        rb.nombre_voix
    FROM pv_bureaux pb
    JOIN centres c ON pb.typeable_id = c.id
    JOIN communes cm ON cm.id = c.commune_id
    JOIN resultats_bureaux rb ON rb.pv_bureau_id = pb.id
    WHERE pb.typeable_type LIKE '%Centre%'

    UNION ALL

    -- Second part: Joins with `bureaux`, then `centres`, and `communes` for Bureau type,
    -- ensuring no double-counting of centres
    SELECT
        pb.id AS pb_id,
        b.centre_id,
        cm.id AS commune_id,
        cm.nom AS commune,

        rb.candidat_id,
        rb.nombre_voix
    FROM pv_bureaux pb
    JOIN bureaux b ON pb.typeable_id = b.id
    JOIN centres c ON b.centre_id = c.id
    JOIN communes cm ON cm.id = c.commune_id
    JOIN resultats_bureaux rb ON rb.pv_bureau_id = pb.id
    WHERE pb.typeable_type LIKE '%Bureau%'
    AND NOT EXISTS (
        SELECT 1
        FROM pv_bureaux pb2
        WHERE pb2.typeable_type LIKE '%Centre%'
        AND pb2.typeable_id = c.id
    )
) AS combined
JOIN candidats cnd ON cnd.id = combined.candidat_id
GROUP BY combined.commune, cnd.nom, cnd.photo
ORDER BY combined.commune, total_voix DESC"));


       $resultatsParCommunes = $resultsCommunes->groupBy('commune')
                ->map(function ($items) {
                    $totalVotes = $items->sum('nombre_voix'); // Sum of votes within each commune, logic remains unchanged
                    return $items->map(function ($item) use ($totalVotes) {
                        $percentage = ($item->percentage); // Calculate percentage
                        // based on
                        // total votes per commune
                        return [
                            'nom' => $item->nom,
                            'photo' => 'storage/' . $item->photo,
                            'pourcentage' => $percentage, // Rounding remains the same
                            'nombre_voix' => intval($item->total_voix) // Conversion remains unchanged
                        ];
                    });
                });



         $resultsParCandidats = DB::table('pv_bureaux')
            ->join('resultats_bureaux', 'pv_bureaux.id', '=', 'resultats_bureaux.pv_bureau_id')
            ->join('candidats', 'resultats_bureaux.candidat_id', '=', 'candidats.id')
            ->join('regions', 'pv_bureaux.region_id', '=', 'regions.id')
            ->joinSub(function ($query) {
                // This subquery calculates the total votes per region
                $query->from('resultats_bureaux')
                    ->join('pv_bureaux', 'resultats_bureaux.pv_bureau_id', '=', 'pv_bureaux.id')
                    ->selectRaw('pv_bureaux.region_id, SUM(resultats_bureaux.nombre_voix) as total_voix')
                    ->groupBy('pv_bureaux.region_id');
            }, 'total_votes_region', function ($join) {
                $join->on('pv_bureaux.region_id', '=', 'total_votes_region.region_id');
            })
            ->join('centres', 'pv_bureaux.typeable_id', '=', 'centres.id')
            ->join('communes', 'centres.commune_id', '=', 'communes.id')
            ->whereIn('pv_bureaux.id', $idsOfPvToSum)
            ->select(
                'candidats.nom as candidat',
                'regions.nom as region_nom',
                DB::raw('SUM(resultats_bureaux.nombre_voix) as nombre_voix'),
                'total_votes_region.total_voix'
            )
            ->groupBy('regions.nom', 'candidats.nom', 'total_votes_region.total_voix')
            ->get();
        $resultsParCandidats = $resultsParCandidats->groupBy('candidat')
            ->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'nom' => $item->region_nom,
                        'nombre_voix' => intval($item->nombre_voix),
                        'pourcentage' => round((($item->nombre_voix)/$item->total_voix) * 100,3)
                    ];
                });
            });

        $resultsParCandidatsDepartements = DB::table('pv_bureaux')
            ->join('resultats_bureaux', 'pv_bureaux.id', '=', 'resultats_bureaux.pv_bureau_id')
            ->join('candidats', 'resultats_bureaux.candidat_id', '=', 'candidats.id')
            ->join('centres', 'pv_bureaux.typeable_id', '=', 'centres.id')
            ->join('departements', 'pv_bureaux.departement_id', '=', 'departements.id')
            ->join('communes', 'centres.commune_id', '=', 'communes.id')
            ->where('pv_bureaux.typeable_type', Centre::class)
            ->whereIn('pv_bureaux.id', $idsOfPvToSum)
            ->select( 'candidats.nom as candidat','departements.nom', DB::raw('SUM(resultats_bureaux.nombre_voix) as nombre_voix'))
            ->groupBy('departements.nom', 'candidats.nom')
            ->get();


        $resultsParCandidatsDepartements = $resultsParCandidatsDepartements->groupBy('candidat')
            ->map(function ($items) {
                return $items->map(function ($item) {
                    return [

                        'nom' => $item->nom,
                        'nombre_voix' => intval($item->nombre_voix)
                    ];
                });
            });
        //TODO make dynamic later
        $candidat = Candidat::all();
        $resultsParCandidatsCommunes = [];
        foreach ($candidat as $candidat) {
            $resultsParCandidatsCommunes[$candidat->nom] = [
                "regions"=> Region::all()->map(function (Region $region) use ($candidat){
                    return [
                         "region"=>$region->nom,
                                "departements"=>$region->departements()->get()->map(function (Departement $departement){
                                    return [
                                        "nom"=>$departement->nom,
                                        "communes"=>$departement->communes()->get()->map(function (Commune $commune){
                                            return [
                                                "nom"=>$commune->nom,
                                                "nombre_voix"=>null,
                                                "pourcentage"=>null

                                            ];
                                        })
                                    ];
                                })];

                })


            ];
        }

        return [
            'stats_remontes_pv' => $statsRemontesPv,
            'regions' => $resultatsParRegions,
            'departements' => $resultatsParDepartements,
            'communes' => $resultatsParCommunes,
           'par_candidats_regions' => $resultsParCandidats,
            'par_candidats_departements' => $resultsParCandidatsDepartements,
            'par_candidats_communes' => $resultsParCandidatsCommunes
        ];

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

    /** @noinspection UnknownColumnInspection */
    function baseQueryForResultats() : Builder
    {
        return PvBureau::select(['id','photo_pv','votants','created_at','inscrits','bulletins_nuls','suffrages_exprimes','certifie','typeable_id','typeable_type'])
            ->with(['resultats' => function ($query) {
                $query->orderByDesc('nombre_voix', 'desc')
                    ->with('candidat');
            }])->orderByDesc('created_at');
    }
    public function pvRemontes()
    {


        $bureaux = $this->baseQueryForResultats()->with('bureau')
            ->with('bureau.centre')
            ->with('bureau.centre.commune')
            ->with('bureau.centre.commune.departement')

//            ->with('resultats.candidat')
            ->where('typeable_type', Bureau::class)->get();
        $centres = $this->baseQueryForResultats()->where('typeable_type', Centre::class)
            ->with('centre')
            ->with('centre.commune')
            ->with('centre.commune.departement')
            ->get();
        $communes = $this->baseQueryForResultats()->where('typeable_type', Commune::class)
            ->with('commune')
            ->with('commune.departement')

            ->get();
        $departements =  $this->baseQueryForResultats()->where('typeable_type', Departement::class)
            ->with('departement')

            ->get();
        // TODO optimize this
        function mapItems($property)
        {
            $result = array_map(function ($item){
            $itemMapped = [
                'id' => $item['id'],
                'photo_pv' => $item['photo_pv'] !== null ? 'storage/'.$item['photo_pv'] : null,
                'votants' => $item['votants'],
                'created_at' => $item['created_at'],
                'inscrits' => $item['inscrits'],
                'bulletins_nuls' => $item['bulletins_nuls'],
                'suffrages_exprimes' => $item['suffrages_exprimes'],
                'certifie' => $item['certifie'],

                'resultats' => array_map(function ($resultat){
                    return [
                        'id' => $resultat['id'],
                        'candidat' => $resultat['candidat']['nom'],
                        'photo' => 'storage/'.$resultat['candidat']['photo'],
                        'nombre_voix' => $resultat['nombre_voix'],
                    ];
                },$item['resultats'])
            ];
            if (isset($item['bureau'])) {
                $itemMapped['departement']=$item['bureau']['centre']['commune']['departement']['nom'];
                $itemMapped['commune']=$item['bureau']['centre']['commune']['nom'];
                $itemMapped['centre']=$item['bureau']['centre']['nom'];
                $itemMapped['bureau'] = $item['bureau']['nom'];
            } else if (isset($item['centre'])) {
                $itemMapped['departement']=$item['centre']['commune']['departement']['nom'];
                $itemMapped['commune']=$item['centre']['commune']['nom'];
                $itemMapped['centre']=$item['centre']['nom'];
            } else if (isset($item['commune'])) {
                $itemMapped['departement']=$item['commune']['departement']['nom'];
                $itemMapped['commune']=$item['commune']['nom'];
            } else if (isset($item['departement'])) {
                $itemMapped['departement']=$item['departement']['nom'];
            }

            return $itemMapped;

        },$property);
            return $result;

        }
        return response([
            'bureaux' => mapItems($bureaux->toArray()),
            'centres' => mapItems($centres->toArray()),
            'communes' => mapItems($communes->toArray()),
            'departements' => mapItems($departements->toArray()),
        ]);
    }

    /**
     * @return array
     */
    public function getCalculatedPvBureaux(): array
    {
        $pv_departements_enregistres = PvBureau::where('typeable_type',Departement::class)
            ->whereIn('typeable_id', Departement::all()->pluck('id')->toArray())
            ->get();



        // ====
        $idsOfPvCentresDesDepartementsNonEnregistres = PvBureau::where('typeable_type', Centre::class)
            ->whereNotIn('departement_id', $pv_departements_enregistres->pluck('typeable_id')->toArray())
            ->get()->pluck('id')->toArray();

        $idsOfBureauxNonEnregistres = PvBureau::
        select(["pv_bureaux.*",'bureaux.centre_id','bureaux.id as bureau_id'])
            ->join('bureaux', 'pv_bureaux.typeable_id', '=', 'bureaux.id')
            ->where('typeable_type', Bureau::class)
            ->whereHas('bureau', function ($query) use ($idsOfPvCentresDesDepartementsNonEnregistres) {
                $query->whereNotIn('centre_id', $idsOfPvCentresDesDepartementsNonEnregistres);
            })
            ->get()->pluck('id')->toArray();
        return array_merge($idsOfPvCentresDesDepartementsNonEnregistres,
            $pv_departements_enregistres->pluck('id')->toArray(),
            $idsOfBureauxNonEnregistres);
    }

}
