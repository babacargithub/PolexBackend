<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStructureRequest;
use App\Http\Requests\UpdateStructureRequest;
use App\Models\Commune;
use App\Models\Departement;
use App\Models\Membre;
use App\Models\Region;
use App\Models\Structure;

class StructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Structure::all()->map(function ($structure) {
            $structure->load('membre');
            return [
                "id" => $structure->id,
                "nom" => $structure->nom,
                "type" => $structure->type,
                "nombre_membres"=>$structure->membres->count(),
                "commune" => $structure->commune->nom ?? "Inconnu",
                "commune_id" => $structure->commune->id ?? 0,
                "responsable" => $structure->membre->nom_complet ?? "Inconnu",
            ];
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStructureRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStructureRequest $request)
    {
        //
        $input = $request->validated();
        $input["commune_id"] = Commune::whereNom($input["commune"])->first()->id;
        unset($input["commune"]);
        $structure = new Structure($input);
        $structure->save();
        return  $structure;
    }

    /**
     * Display the specified resource.
     *
     * @param Structure $structure
     * @return Structure
     */
    public function show(Structure $structure)
    {
        //
        $structure->load('membres');
        return  $structure;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStructureRequest  $request
     * @param Structure $structure
     * @return Structure
     */
    public function update(UpdateStructureRequest $request, Structure $structure)
    {
        //
        $input = $request->validated();
        $input['commune_id'] = Commune::whereNom($input['commune'])->first()->id;
        unset($input['commune']);
        $structure->update($input);
        return  $structure;
    }
    public function getListeStructuresDepartement($departement)
    {
        $departement = Departement::whereNom($departement)->with('structures')->firstOrFail();
        return $departement->structures;

    }
    public function getListeStructuresCommune($departement, $commune)
    {
        $commune = Commune::whereNom($commune)->whereRelation('departement','nom',$departement)->with('structures')->firstOrFail();
        return $commune->structures;

    }

    public function getListeStructuresRegion($region)
    {
        $departements = Region::whereNom($region)->with('departements')->firstOrFail();

        $structures = [];
        foreach ($departements->departements as $departement) {
            $structures = array_merge($structures, $departement->structures->toArray());
        }
        return $structures;


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Structure $structure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Structure $structure)
    {
        //
        $structure->delete();
        return  response()->noContent();
    }
    public function designerResponsable(Structure $structure, Membre $membre)
    {
        $structure->membre()->associate($membre);
        $structure->save();
        return $structure;
    }
}
