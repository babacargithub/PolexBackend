<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('electeur', 'ElecteurCrudController');
    Route::crud('formule', 'FormuleCrudController');
    Route::crud('parti', 'PartiCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('params', 'ParamsCrudController');
    Route::crud('type-membre', 'TypeMembreCrudController');
    Route::crud('structure', 'StructureCrudController');
    Route::crud('type-carte-membre', 'TypeCarteMembreCrudController');
    Route::crud('candidat', 'CandidatCrudController');
    Route::crud('commune', 'CommuneCrudController');
    Route::crud('centre', 'CentreCrudController');
    Route::crud('bureau', 'BureauCrudController');
}); // this should be the absolute last line of this file