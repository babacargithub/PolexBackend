<?php

namespace App\Http\Controllers;

use App\Models\Communique;
use Illuminate\Http\Request;

class CommuniqueController extends Controller
{
    //
    public function index(){
        return Communique::all();
    }
    public function store(Request $request){
        return Communique::create($request->validate([
            "titre"=>"required",
            "contenu"=>"required",
            'publie'=>'required'
        ]));
    }
    public function show(Communique $communique){
        return $communique;
    }
    public function update(Request $request, Communique $communique){
        $communique->update($request->all());
        return $communique;
    }
    public function delete(Communique $communique){
        $communique->delete();
        return response()->noContent();
    }
}
