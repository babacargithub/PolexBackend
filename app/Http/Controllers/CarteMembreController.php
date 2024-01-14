<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarteMembreRequest;
use App\Http\Requests\UpdateCarteMembreRequest;
use App\Models\CarteMembre;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class CarteMembreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        //
        return  CarteMembre::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCarteMembreRequest $request
     * @return CarteMembre
     * @throws Exception
     */
    public function store(StoreCarteMembreRequest $request)
    {
        $membre = new  CarteMembre($request->validated());
        $membre->numero = random_int(1000000000, 9999999999);
        $membre->save();
        return $membre;
    }

    /**
     * Display the specified resource.
     *
     * @param CarteMembre $carteMembre
     * @return CarteMembre
     */
    public function show(CarteMembre $carte)
    {
        return  $carte;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCarteMembreRequest $request
     * @param CarteMembre $carteMembre
     * @return CarteMembre
     */
    public function update(UpdateCarteMembreRequest $request, CarteMembre $carte)
    {
        //
        $carte->update($request->validated());
        return $carte;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CarteMembre $carteMembre
     * @return Response
     */
    public function destroy(CarteMembre $carte)
    {
        $carte->delete();
        return response()->noContent();
    }
}
