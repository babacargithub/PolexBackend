<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStructureRequest;
use App\Http\Requests\UpdateStructureRequest;
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
        return  Structure::all();
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
        $structure = new Structure($input);
        $structure->save();
        return  $structure;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Structure  $structure
     * @return \Illuminate\Http\Response
     */
    public function show(Structure $structure)
    {
        //
        return  $structure;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStructureRequest  $request
     * @param  \App\Models\Structure  $structure
     * @return Structure
     */
    public function update(UpdateStructureRequest $request, Structure $structure)
    {
        //
        $input = $request->validated();
        $structure->update($input);
        return  $structure;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Structure  $structure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Structure $structure)
    {
        //
        $structure->delete();
        return  response()->noContent();
    }
}
