<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;

class DepenseController extends Controller
{
    //
    public function index(){
        return Depense::all();
    }
    public function store(Request $request){
        return Depense::create($request->validate([
            "libelle"=>"required",
            "montant"=>"required|numeric",
            "date_depense"=>"required"
        ]));
    }
    public function show(Depense $depense){
        return $depense;
    }
    public function update(Request $request, Depense $depense){
        $depense->update($request->all());
        return $depense;
    }
    public function delete(Depense $depense){
        $depense->delete();
        return 204;
    }

}
