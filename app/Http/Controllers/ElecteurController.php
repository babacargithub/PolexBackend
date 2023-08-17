<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreElecteurRequest;
use App\Http\Requests\UpdateElecteurRequest;
use App\Models\Electeur;

class ElecteurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreElecteurRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreElecteurRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Electeur  $electeur
     * @return \Illuminate\Http\Response
     */
    public function show(Electeur $electeur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Electeur  $electeur
     * @return \Illuminate\Http\Response
     */
    public function edit(Electeur $electeur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateElecteurRequest  $request
     * @param  \App\Models\Electeur  $electeur
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateElecteurRequest $request, Electeur $electeur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Electeur  $electeur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Electeur $electeur)
    {
        //
    }
}
