<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidatRequest;
use App\Http\Requests\UpdateCandidatRequest;
use App\Models\Candidat;

class CandidatController extends Controller
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
     * @param  \App\Http\Requests\StoreCandidatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCandidatRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidat  $candidat
     * @return \Illuminate\Http\Response
     */
    public function show(Candidat $candidat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidat  $candidat
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidat $candidat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCandidatRequest  $request
     * @param  \App\Models\Candidat  $candidat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCandidatRequest $request, Candidat $candidat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidat  $candidat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidat $candidat)
    {
        //
    }
}
