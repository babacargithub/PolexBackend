<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Membre;
use App\Models\Structure;
use App\Models\TypeMembre;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MembreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Membre[]|Collection|Response
     */
    public function index()
    {
        //
        return  Membre::all();
    }

 /**
     * Display a listing of the resource.
     *
     * @return Membre[]|Collection|Response
     */
    public function getListResponsables()
    {
        //
        // TODO un comment
//        return  Membre::whereTypeMembreId(TypeMembre::where("nom","Responsable Cellule")->first()->id)->get();
        return  Membre::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Membre
     */
    public function store(Request $request)
    {
        //
        $input = $request->validate([
            "nom" => "required",
            "prenom" => "required",
            "telephone" => "required||unique:membres,telephone",
            "sexe" => "required",
            "nin" => "required|unique:membres,nin",
            "structure_id" => "required",
            "type_membre_id" => "required",

        ]);


        $membre = new Membre($input);
        $membre->save();
        $membre->load("structure","typeMembre");
        return  $membre;
    }

    /**
     * Display the specified resource.
     *
     * @param Membre $membre
     * @return Membre
     */
    public function show(Membre $membre)
    {
        //
        return  $membre;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Membre $membre
     * @return Membre
     */
    public function update(Request $request, Membre $membre)
    {
        //
        $input = $request->validate([
            "nom" => "string",
            "prenom" => "string",
            "telephone" => "integer|unique:membres,telephone,".$membre->id,
            "sexe" => "string",
            "nin" => "string|unique:membres,nin,".$membre->id,
            "commune"=>"string",
            "structure_id" => "integer|exists:structures,id",
            "type_membre_id" => "integer:exists:type_membres,id",

        ]);
        $input["commune_id"] = Commune::whereNom($input["commune"])->first()->id;
        unset($input["commune"]);
        $membre->update($input);
        return  $membre;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Membre $membre
     * @return JsonResponse
     */
    public function destroy(Membre $membre)
    {
        //
        $membre->delete();
        return  response()->json(["message"=>"membre deleted"],204);
    }

    public function membresCommune($commune){
        return Membre::where("commune",$commune)->get();
    }

    public function membresStructure(Structure $structure)
    {
        return $structure->membres()->get();
    }
}
