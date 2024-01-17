<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarteMembreRequest;
use App\Http\Requests\UpdateCarteMembreRequest;
use App\Models\CarteMembre;
use App\Models\LotCarte;
use App\Models\Membre;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
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
     * Store a newly created resource in storage.
     *
     * @param StoreCarteMembreRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function creerLotCarte(Request $request)
    {
        $data = $request->validate([
            "nombre" => "required|integer|min:1",
            "type_carte_membre_id" => "required|integer|exists:type_carte_membres,id",
        ]);
        $nombre_a_genere = $data["nombre"];
        while ($nombre_a_genere > 0) {
            $nombre_a_genere--;
            $carte = new CarteMembre();
            $carte->numero = CarteMembre::count()> 0 ? intval(CarteMembre::count() . "" . random_int(10000, 99999)) : intval("1" . random_int(10000, 99999));
            $carte->type_carte_membre_id = $data["type_carte_membre_id"];
            $carte->save();
        }

        return \response()->json([$data["nombre"]. " cartes ont été générées avec succès !"]);
    }/**
     * Store a newly created resource in storage.
     *
     * @param StoreCarteMembreRequest $request
     * @return LotCarte
     * @throws Exception
     */
    public function attribuerLotCarte(Request $request, Membre $membre)
    {
        $data = $request->validate([
            "nombre" => "required|integer|min:1",
            "type_carte_membre_id" => "required|integer|exists:type_carte_membres,id",
        ]);
        $cartes = CarteMembre::whereLotCarteId(null)->whereTypeCarteMembreId($data["type_carte_membre_id"])->limit($data["nombre"])->get();

        $request->validate([
            "nombre" => function ($attribute, $value, $fail) use ($cartes) {
                if ($cartes->count() < $value) {
                    $fail("Le nombre de carte disponible est de " . $cartes->count());
                }
            },

        ]);
        $lot = new LotCarte();
        $lot->numero = LotCarte::count()> 0 ? intval(LotCarte::count() . "" . random_int(10000, 99999)) : intval("1" . random_int(10000, 99999));
        $lot->membre()->associate($membre);
        $lot->save();
        $lot->cartes()->saveMany($cartes);
        return $lot;
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
