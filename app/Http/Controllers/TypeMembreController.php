<?php

namespace App\Http\Controllers;

use App\Models\Organigramme;
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
        $typeMembre = TypeMembre::create($request->all());
        $typeMembre->organigramme()->create([
            "type_organigramme"=>"politique",
            "position"=> Organigramme::max('position')+1
        ]);
        return $typeMembre;


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

    public function organigramme()
    {
        return  \DB::select('SELECT org.id, tm.nom as name, org.position FROM organigrammes org
    INNER JOIN polex_crm.type_membres as tm ON tm.id = org.type_membre_id
                                    WHERE type_organigramme LIKE "politique"
                                    ORDER BY position');

    }
    public function organigrammeUpdate(Request $request)
    {
        $data = $request->validate([
            "organigrammes.*.id"=>"required|exists:organigrammes,id",
            "organigrammes.*.position"=>"required|numeric",
        ]);
        foreach ($data['organigrammes'] as $organigramme){
            Organigramme::find($organigramme['id'])->update(["position"=>$organigramme['position']]);
        }
        return $data['organigrammes'];


    }
}
