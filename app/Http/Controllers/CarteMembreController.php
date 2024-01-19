<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarteMembreRequest;
use App\Http\Requests\UpdateCarteMembreRequest;
use App\Models\CarteMembre;
use App\Models\LotCarte;
use App\Models\Membre;
use App\Models\TypeCarteMembre;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
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
     * @return Membre
     * @throws Exception
     */
    public function attribuerUneCarteAUnMembre(Request $request, Membre $membre, CarteMembre $numeroCarte )
    {

        if ($numeroCarte->membre_id !== null) {
            abort(422,"Cette carte est déjà attribuée à un membre");
        }
        if ($numeroCarte->vendu_le !== null) {
            abort(422,"Cette carte est déjà vendue");
        }
        $membre->load("carte");
        if ($membre->carte !== null) {
            abort(422,"Ce membre a déjà une carte");
        }
        $numeroCarte->membre()->associate($membre);
        $numeroCarte->vendu_le = now();
        $numeroCarte->save();

        return $membre;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCarteMembreRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function creerLotCarte(Request $request)
    {
        $data = $request->validate([
            "nombre" => "required|integer|min:1",
            "type_carte_membre_id" => "required|integer|exists:type_carte_membres,id",
        ]);
        $nombre_a_genere = $data["nombre"];
        if (CarteMembre::count() > 0) {
            $numero_debut_serie = CarteMembre::orderBy("numero","desc")->first()->numero;
        } else {
            $numero_debut_serie = 100000;
        }
        while ($nombre_a_genere > 0) {
            $nombre_a_genere--;
            $carte = new CarteMembre();
           $carte->numero = $numero_debut_serie + 1;
           $carte->created_at = now();
           $numero_debut_serie ++;
            $carte->type_carte_membre_id = $data["type_carte_membre_id"];
            $carte->save();
        }

        return response()->json([$data["nombre"]. " cartes ont été générées avec succès !"]);
    }/**
     * Store a newly created resource in storage.
     *
     * @param StoreCarteMembreRequest $request
     * @return LotCarte
     * @throws Exception
 * @noinspection UnknownColumnInspection
 */
    public function attribuerLotCarte(Request $request, Membre $membre)
    {
        $data = $request->validate([
            "type_carte_membre_id" => "required|integer|exists:type_carte_membres,id",
            "type_lot"=>"required|string|in:serie,vrac"
        ]);
        $type_lot = $data["type_lot"];
        $lot = new LotCarte();
        $lot->type_lot = $type_lot;
        $lot->numero = LotCarte::count()> 0 ? intval(LotCarte::count() . "" . random_int(10000, 99999)) : intval("1" . random_int(10000, 99999));
        $lot->membre()->associate($membre);

        if ($type_lot == "serie"){
            $dataSecond = $request->validate([
                "debut_serie" => "required|integer|min:1",
                "fin_serie" => "required|integer|min:1",

            ]);
            $cartes = CarteMembre::whereNull("lot_carte_id")
                ->whereTypeCarteMembreId($data["type_carte_membre_id"])
                ->where("numero",">=", $dataSecond["debut_serie"])
                ->where("numero","<=", $dataSecond["fin_serie"])
                ->get();
            $request->validate(["numero"=>

                    function ($attribute, $value, $fail) use ($cartes) {
                    if ($cartes->count()  == 0) {
                        $fail("Le nombre de carte disponible pour cette serie est de " . $cartes->count());
                    }
                }]);

            $lot->save();
            $lot->cartes()->saveMany($cartes);

        }
        else if ($type_lot == "vrac"){
            $dataVrac = $request->validate([
            "nombre" => [  "required","integer","min:1"]

        ]);
            $cartes = CarteMembre::whereLotCarteId(null)
                ->whereTypeCarteMembreId($data["type_carte_membre_id"])
                ->limit($dataVrac["nombre"])
                ->get();

            $request->validate([
                "nombre" => [  "required","integer","min:1",
                    function ($attribute, $value, $fail) use ($cartes) {
                        if ($cartes->count() < $value) {
                            $fail("Le nombre de carte disponible est de " . $cartes->count());
                        }
                    },
                ]

            ]);
            $lot->save();

        }


        return $lot;
    }
    public function listTypeCartes()
    {
       return TypeCarteMembre::all();
    }
    public function listDesLotsDeCarte()
    {
        $lots = LotCarte::all()->map(function (LotCarte $lot) {
            return [
                'id' => $lot->id,
                'numero' => $lot->numero,
                'type_lot' => $lot->type_lot,
                'nombre_carte' => $lot->type_lot =="serie" ? $lot->cartes()->count() : intval($lot->nombre),
                'nombre_restant' => $lot->type_lot =="serie" ? $lot->cartes()->whereNull("membre_id")->count() : 'Inconnu',
                'type_carte_membre' => $lot->type_carte_membre->nom ?? "Non défini",
                'membre' => $lot->membre->nom_complet,
                'created_at' => $lot->created_at->format("d/m/Y H:i:s"),
                // Add or customize more properties as needed
            ];
        });
        return $lots;
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
