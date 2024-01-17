<?php

namespace App\Http\Controllers;

use App\Models\Membre;
use App\Models\TypeMembre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MembreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Membre[]|\Illuminate\Database\Eloquent\Collection|Response
     */
    public function index()
    {
        //
        return  Membre::all();
    }

 /**
     * Display a listing of the resource.
     *
     * @return Membre[]|\Illuminate\Database\Eloquent\Collection|Response
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
            "commune"=>"required",
            "structure_id" => "required",
            "type_membre_id" => "required",

        ]);

        $membre = new Membre($input);
        $membre->save();
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
        $membre->update($request->all());
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
}
