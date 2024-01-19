<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRepresBureauRequest;
use App\Http\Requests\UpdateRepresBureauRequest;
use App\Models\Bureau;
use App\Models\Centre;
use App\Models\RepresBureau;
use Illuminate\Http\JsonResponse;

class RepresBureauController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        //
        $nombreCentre = Centre::count();
        $nombreBureau = Bureau::count();
        $nombreRepresentant = RepresBureau::count();
       return [
           "bureau"=>[
               "nombre_bureau"=>$nombreBureau,
                "nombre_represente"=>Bureau::whereHas("representant")->count(),
               "nombre_non_represente"=>Bureau::whereDoesntHave("representant")->count(),
               "taux_represente"=>round(Bureau::whereHas("representant")->count()*100/Bureau::count(),2),
           ],
              "centre"=>[
                "nombre_centre"=> $nombreCentre,
                "nombre_represente"=> Centre::whereHas("representant")->count(),
                "nombre_non_represente"=>Centre::whereDoesntHave("representant")->count(),
                "taux_represente"=>round(Centre::whereHas("representant")->count()*100/Centre::count(),2),
              ],
            "representant"=>[
                "nombre_representant"=> $nombreRepresentant,
                "nombre_representant_centre"=>RepresBureau::where('lieu_vote_type',Centre::class)->count(),
                "nombre_representant_bureau"=>RepresBureau::where('lieu_vote_type',Bureau::class)->count(),
                "representants"=>RepresBureau::with('lieuVote')->get(),
            ],

       ];
    }
    public function listRepres()
    {
        //
        return RepresBureau::with('bureau')->with('centre')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRepresBureauRequest $request
     * @return JsonResponse
     */
    public function store(StoreRepresBureauRequest $request)
    {
        //
        $data = $request->validated();
        $represBureau = new RepresBureau($data);
        $represBureau->lieu_vote_type = $request->input('type_representant') == 'centre' ? Centre::class : ($request->input('type_representant')== 'bureau' ?Bureau::class: abort(422, "Le type de representant n'est pas valide"));
       $represBureau->save();
        return response()->json($represBureau, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param RepresBureau $represBureau
     * @return RepresBureau
     */
    public function show(RepresBureau $represBureau)
    {
       return  $represBureau;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRepresBureauRequest $request
     * @param RepresBureau $represBureau
     * @return JsonResponse
     */
    public function update(UpdateRepresBureauRequest $request, RepresBureau $represBureau)
    {
        //
        $data = $request->validated();
        $represBureau->update($data);
        return response()->json($represBureau);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RepresBureau $represBureau
     * @return JsonResponse
     */
    public function destroy(RepresBureau $represBureau)
    {
        //
        $represBureau->delete();
        return response()->json(null, 204);
    }
}
