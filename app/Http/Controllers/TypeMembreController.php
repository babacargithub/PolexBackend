<?php

namespace App\Http\Controllers;

use App\Models\TypeMembre;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TypeMembreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TypeMembre[]|Collection
     */
    public function index()
    {
        //
        return  TypeMembre::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return TypeMembre::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param TypeMembre $typesMembre
     * @return TypeMembre
     */
    public function show(TypeMembre $typesMembre)
    {
        return $typesMembre;
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param TypeMembre $typesMembre
     * @return TypeMembre
     */
    public function update(Request $request, TypeMembre $typesMembre)
    {
        $typesMembre->update($request->all());
        return $typesMembre;

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TypeMembre $typesMembre
     * @return Response
     */
    public function destroy(TypeMembre $typesMembre)
    {
        //
        $typesMembre->delete();
        return response()->noContent();
    }
}
