<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RestaurantRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RestaurantCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RestaurantCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Restaurant::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/restaurant');
        CRUD::setEntityNameStrings('restaurant', 'restaurants');
        
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // columns
        CRUD::addColumn(
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
            CRUD::addColumn(
                [
                'label'=>'nom',
                'type' => 'string',
                'name' => 'nom',
                
                ]
                );
                CRUD::addColumn(
                    [
                    'label'=>'Adresse',
                    'type' => 'string',
                    'name' => 'adresse',
                    
                    ]
                    );
                    CRUD::addColumn(
                        [
                        'label'=>'Propi??taire',
                        'type' => 'string',
                        'name' => 'proprietaire',
                        
                        ]
                        );
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
        CRUD::setValidation(RestaurantRequest::class);
        
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

        $this->crud->addField([  // Select2
            'label'     => "Proprietaire",
            'type'      => 'select2',
            'name'      => 'user_id', // the db column for the foreign key
         
            // optional
            'entity'    => 'User', // the method that defines the relationship in your Model
            'model'     => "App\Models\User", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'default'   => 5, // set the default value of the select2
         
             // also optional
            'options'   => (function ($query) {
                 return $query->orderBy('name', 'ASC')->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
         ],);
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
}
