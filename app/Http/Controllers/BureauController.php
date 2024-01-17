<?php

namespace App\Http\Controllers;

use App\Models\Bureau;
use App\Models\RepresBureau;
use App\Rules\Telephone;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BureauController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Bureau[]|Collection
     */
    public function index()
    {
        //
        return [
            "nombre_bureau"=>Bureau::count(),
            "nombre_represente"=>Bureau::whereHas("representant")->count(),
            ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function storeRepresentant(Request $request)
    {
        //
        $data = $request->validate([
            "prenom" => "required|string",
            "nom" => "required|string",
            "telephone" => ["required", new Telephone(),"unique:repres_bureaux,telephone"],
            "num_electeur" => "required|integer:digits:9|unique:repres_bureaux,num_electeur",
            "bureau_id" => "integer",
        ],[
            "telephone.unique"=>"Ce numéro de téléphone est déjà utilisé",
            "num_electeur.unique"=>"Ce numéro d'électeur est déjà utilisé",
        ]);
        $representant = RepresBureau::create($data);
        return response($representant,201);
    }
    public function designerRepresentant(Bureau $bureau,RepresBureau $representant)
    {
        //
        $representant->bureau()->associate($bureau);
        $representant->save();
        return response($representant,200);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bureau  $bureau
     * @return Response
     */
    public function show(Bureau $bureau)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bureau  $bureau
     * @return Response
     */
    public function edit(Bureau $bureau)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\Bureau  $bureau
     * @return Response
     */
    public function update(Request $request, Bureau $bureau)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bureau  $bureau
     * @return Response
     */
    public function destroy(Bureau $bureau)
    {
        //
    }
}
