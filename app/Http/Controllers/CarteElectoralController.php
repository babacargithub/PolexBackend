<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarteElectoralController extends Controller
{
    //
    public function index()
    {
       return \DB::select('select * from donnees_electorales');
    }
}
