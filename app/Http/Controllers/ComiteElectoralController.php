<?php

namespace App\Http\Controllers;

use App\Models\Bureau;
use App\Models\Centre;
use App\Models\ComiteElectoral;
use App\Models\Departement;
use App\Models\Membre;
use App\Models\MembreComiteElectoral;
use App\Models\Region;
use Illuminate\Http\Request;

class ComiteElectoralController extends Controller
{
    //
    public function index()
    {
        $comites = ComiteElectoral::
        with('membre')
            ->withCount('membres')
            ->get()->map(function (ComiteElectoral $comiteElectoral){
                return [
                    "id"=>$comiteElectoral->id,
                    "nom"=>$comiteElectoral->nom,
                    "departement"=>$comiteElectoral->departement->nom,
                    "region"=>$comiteElectoral->departement->region->nom,
                    "nombre_membres"=> $comiteElectoral->membres_count,
                    "objectif_assigne"=>$comiteElectoral->membres->sum('objectif'),
                    "nombre_centres"=> Centre::whereHas('commune',function ($query) use ($comiteElectoral){
                        $query->whereDepartementId($comiteElectoral->departement_id);
                    })->count(),
                    "nombre_bureaux"=> Bureau::whereHas('centre', function ($query) use ($comiteElectoral){
                        $query->whereHas('commune',function ($communeQuery) use ($comiteElectoral){
                            $communeQuery->whereDepartementId($comiteElectoral->departement_id);
                        });
                    })->count(),
                    "nombre_electeurs"=> Bureau::whereHas('centre', function ($query) use ($comiteElectoral){
                        $query->whereHas('commune',function ($communeQuery) use ($comiteElectoral){
                            $communeQuery->whereDepartementId($comiteElectoral->departement_id);
                        });
                    })->sum('nombre_electeurs'),
                    "responsable"=>$comiteElectoral->responsable ? $comiteElectoral->responsable->nom : 'Pas de responsable'
                ];

            });

        $plenipots = Departement::all()->map(function (Departement $departement){
            return [$departement->nom=>$departement->plenipots()->get()];
        });

        return [
            "comites"=>$comites,
            "plenipots"=>$plenipots,
            "objectifs"=>$this->objectifs()
        ];
    }
    public function objectifs()
    {
        return [
            "nombre_electeurs"=> 5000000,
            "total_vise" => 1500000,
            "total_assigne"=>MembreComiteElectoral::all()->sum('objectif'),
            "objectifs_par_region"=> Region::all()->map(function (Region $region){
                return [
                    "region"=>$region->nom,
                    "objectif"=> $region->departements()->get()->map(function (Departement $departement){
                        return $departement->comites()->get()->map(function (ComiteElectoral $comiteElectoral){
                            return $comiteElectoral->membres->sum('objectif');
                        })->sum();
                    })->sum(),
                    "departements"=>$region->departements()->get()->map(function (Departement $departement){
                        return [
                            "nom"=>$departement->nom,
                            "objectif"=> $departement->comites()->get()->map(function (ComiteElectoral $comiteElectoral){
                                return $comiteElectoral->membres->sum('objectif');
                            })->sum()
                        ];
                    })
                ];
            })

        ];

    }
    public function store(Request $request)
    {
        $data = $request->validate([
            "nom" => "required|unique:comite_electorals,nom",
            "departement" => "required|exists:departements,nom",
        ], [
            "nom.unique" => "Un comité électoral avec ce nom existe déjà. Veuillez en choisir un autre."
        ]);
        $departement = Departement::where(['nom'=>$data['departement']])->firstOrFail();
        $comiteElectoral = new ComiteElectoral($data);
        $comiteElectoral->departement()->associate($departement);
        $comiteElectoral->membre()->associate(Membre::firstOrFail());
        $comiteElectoral->save();
        return $comiteElectoral;
    }
    public function show(ComiteElectoral $comiteElectoral)
    {
        $comiteElectoral->load('membres');
        $membres = $comiteElectoral->membres;
        return $membres->map(function (MembreComiteElectoral $membreComiteElectoral){
            $membreComiteElectoral->load('comiteRole');
            return [

                "id"=>$membreComiteElectoral->id,
                'role'=>$membreComiteElectoral->comiteRole != null ? $membreComiteElectoral->comiteRole->nom : null,
                'position'=>$membreComiteElectoral->comiteRole ? $membreComiteElectoral->comiteRole->position : 0,
                "nom_complet"=>$membreComiteElectoral->nom_complet,
                "telephone"=>$membreComiteElectoral->telephone,
                "objectif"=>$membreComiteElectoral->objectif,
                "commune"=>$membreComiteElectoral->commune,
            ];
        });
    }
    public function update(Request $request, ComiteElectoral $comiteElectoral)
    {
        $comiteElectoral->update($request->validate([
            "nom" => "string|required|unique:comite_electorals,nom," . $comiteElectoral->id,
            "departement_id" => "exists:departements,id",
            "membre_id" => "exists:membres,id",
        ], [
            "nom.unique" => "Impossible de modifier avec ce nom. Un comité électoral avec ce nom existe déjà. Veuillez en choisir un autre."
        ]));
        return $comiteElectoral;
    }
    public function delete(ComiteElectoral $comiteElectoral)
    {
        $comiteElectoral->delete();
        return response(null, 204);
    }
    public function getMembresResponsableComiteElectoral()
    {
        return Membre::whereHas('typeMembre', function ($query) {
            $query->where('libelle', 'Responsable comité électoral');
        })->get();

    }
    public function membres(ComiteElectoral $comiteElectoral)
    {
        $membres = $comiteElectoral->membres;
        return $membres->map(function (MembreComiteElectoral $membreComiteElectoral){
            return [
                "id"=>$membreComiteElectoral->id,
                'role'=>$membreComiteElectoral->role ? $membreComiteElectoral->role->libelle : null,
                'position'=>$membreComiteElectoral->role ? $membreComiteElectoral->role->position : 0,
                "nom_complet"=>$membreComiteElectoral->nom_complet,
                "telephone"=>$membreComiteElectoral->telephone,
                "objectif"=>$membreComiteElectoral->objectif,
                "commune"=>$membreComiteElectoral->commune,
            ];
        });

    }
    public function createMembre(ComiteElectoral $comiteElectoral, Request $request){
        $membreComiteElectoral = new MembreComiteElectoral($request->validate([
            "prenom"=>"required|string",
            "nom"=>"required|string",
            "telephone"=>"required|string",
            "nin"=>"string",
            "commune"=>"required|string",
            "type_membre_id"=>"required|exists:type_membres,id"

        ]));
        $membreComiteElectoral->comiteElectoral()->associate($comiteElectoral);
        $membreComiteElectoral->save();

        return $membreComiteElectoral;
    }

    public function logistics(ComiteElectoral $comiteElectoral)
    {
        /*nombre_centres: 0,
        nombre_bureaux: 0,
        nombre_cars: 0,
        car_seat_count: 42,
        prix_loc_cars: 1,*/

            $nombre_centres = Centre::whereHas('commune',function ($query) use ($comiteElectoral){
                $query->whereDepartementId($comiteElectoral->departement_id);
            })->count();
            $nombre_bureaux = Bureau::whereHas('centre', function ($query) use ($comiteElectoral){
                $query->whereHas('commune',function ($communeQuery) use ($comiteElectoral){
                    $communeQuery->whereDepartementId($comiteElectoral->departement_id);
                });
            })->count();
            $nombre_electeurs = Bureau::whereHas('centre', function ($query) use ($comiteElectoral){
                $query->whereHas('commune',function ($communeQuery) use ($comiteElectoral){
                    $communeQuery->whereDepartementId($comiteElectoral->departement_id);
                });
            })->sum('nombre_electeurs');
            $car_seat_count = 42;
            $prix_loc_cars = 50000;
            return [
                "nombre_centres"=>$nombre_centres,
                "nombre_bureaux"=>$nombre_bureaux,
                "nombre_electeurs"=>$nombre_electeurs,
                "nombre_cars"=> $nombre_centres ,
                "car_seat_count"=>42,
                "prix_loc_cars"=> $prix_loc_cars,
                "total_prix_loc_cars"=> $prix_loc_cars * $nombre_centres,
                "nombre_rotation_cars_par_centres"=> Centre::with('commune')->whereHas('commune',function ($query) use
                ($comiteElectoral, $car_seat_count){
                    $query->whereDepartementId($comiteElectoral->departement_id);
                })->orderBy('commune_id')->get()->map(function (Centre $centre) use($car_seat_count)  {
                    $nombre_electeurs = $centre->bureaux->sum('nombre_electeurs');
                    $nombre_electeurs = $nombre_electeurs - round($nombre_electeurs * 0.3);
                    return [
                        "commune"=>$centre->commune->nom,
                        "centre"=>$centre->nom,
                        "nombre_electeurs"=>$nombre_electeurs,
                        "nombre_rotations"=>round($nombre_electeurs / $car_seat_count)
                    ];
                })

            ];

    }

}
