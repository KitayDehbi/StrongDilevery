<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PlatRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PlatCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlatCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Plat::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/plat');
        CRUD::setEntityNameStrings('plat', 'plats');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {CRUD::addColumn(
        [
        'label'=>'image',
        'type' => 'image',
        'name' => 'image',
        'prefix' => '',
        'height' => '80px',
        'width' => '80px',
        'disk' => 'public'
        ]
        );
        $this->crud->addColumn([
            'name' => 'nom',
            'label' => 'Nom',
            'type' => 'text',
        ]);
        $this->crud->addColumn([
            'name' => 'restaurant.nom',
            'label' => 'Restaurant',
            'type' => 'text',
        ]);
        $this->crud->addColumn([
            'name' => 'prix',
            'label' => 'Prix',
            'type' => 'text',
        ]);
        //CRUD::setFromDb(); // columns

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
        CRUD::setValidation(PlatRequest::class);
        $this->crud->addField([
            'label' => "Image",
            'name' => "image",
            'type' => 'image',
            'upload' => true,
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
             'disk'      => 'public', // in case you need to show images from a different disk
             //'prefix'    => 'public/images/resto_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);
        $this->crud->addField([
            'label' => "Restaurant",
            'type' => 'select2',
            'name' => 'restaurant_id',
            'entity' => 'restaurant',
            'attribute' => 'nom',
            'model' => "App\Models\Restaurant"
        ]);
        CRUD::setFromDb(); // fields

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

    protected function setupShowOperation(){
        CRUD::addColumn(
            [
            'label'=>'image',
            'type' => 'image',
            'name' => 'image',
            'prefix' => '',
            'height' => '80px',
            'width' => '80px',
            'disk' => 'public'
            ]);
        
        CRUD::setFromDb();
    }
}
