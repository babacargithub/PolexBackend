<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartiRequest;
use App\Http\Requests\UpdatePartiRequest;
use App\Models\Parti;

class PartiController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePartiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUser(StorePartiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parti  $parti
     * @return \Illuminate\Http\Response
     */
    public function show(Parti $parti)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePartiRequest  $request
     * @param  \App\Models\Parti  $parti
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePartiRequest $request, Parti $parti)
    {
        //
    }


}
