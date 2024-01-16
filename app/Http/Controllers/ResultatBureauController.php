<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResultatBureauRequest;
use App\Http\Requests\UpdateResultatBureauRequest;
use App\Models\PvBureau;

class ResultatBureauController extends Controller
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
     * @param  \App\Http\Requests\StoreResultatBureauRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResultatBureauRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PvBureau  $resultatBureau
     * @return \Illuminate\Http\Response
     */
    public function show(PvBureau $resultatBureau)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PvBureau  $resultatBureau
     * @return \Illuminate\Http\Response
     */
    public function edit(PvBureau $resultatBureau)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateResultatBureauRequest  $request
     * @param  \App\Models\PvBureau  $resultatBureau
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResultatBureauRequest $request, PvBureau $resultatBureau)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PvBureau  $resultatBureau
     * @return \Illuminate\Http\Response
     */
    public function destroy(PvBureau $resultatBureau)
    {
        //
    }

}
