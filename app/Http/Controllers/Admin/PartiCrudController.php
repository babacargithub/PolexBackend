<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PartiRequest;
use App\Models\Parti;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\This;
use Prologue\Alerts\Facades\Alert;

/**
 * Class PartiCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PartiCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Parti::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/parti');
        CRUD::setEntityNameStrings('parti', 'partis');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('nom');
        CRUD::column('code');
        CRUD::column('has_debt');
        CRUD::column('formule_id');
        CRUD::column('created_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PartiRequest::class);

        CRUD::field('nom');
        CRUD::field('code');
        $this->crud->addField([
            // Select
            'label'     => "Formule",
            'type'      => 'select',
            'name'      => 'formule_id', // the db column for the foreign key

            // optional
            // 'entity' should point to the method that defines the relationship in your Model
            // defining entity will make Backpack guess 'model' and 'attribute'
            'entity'    => 'formule',

            // optional - manually specify the related model and attribute
            'attribute' => 'nom', // foreign key attribute that is shown to user

            // optional - force the related options to be a custom query, instead of all();
            'options'   => (function ($query) {
                return $query->orderBy('prix', 'ASC')->get();
            }), //  you can use this to filter the results show in the select
        ]);
        $this->crud->addField([
            'name'=>"end_point",
            'label'     => "Url du serveur",
            'text'      => 'select',]);
        CRUD::field('has_debt');



        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
    public function store(PartiRequest $request)
    {
        $parti = new Parti($this->crud->getStrippedSaveRequest($request));
        $userAccount = new User();

        $userAccount->name = $parti->nom;
        $userAccount->email = str_replace(' ','_',strtolower($parti->nom)).'@polex.tech';
        $userAccount->password = Hash::make("0000");
        $userAccount->assignRole(["owner","writer"]);
        $userAccount->save();
        $parti->user()->associate($userAccount);
        $parti->save();
        // show a success message
        Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($userAccount->getKey());
    }
}
