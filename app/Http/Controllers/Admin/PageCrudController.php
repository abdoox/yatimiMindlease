<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\NewsRequest as StoreRequest;
use App\Http\Requests\NewsRequest as UpdateRequest;

class PageCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Page');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/page');
        $this->crud->setEntityNameStrings('pages', 'page');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
		
        $this->crud->setFromDb();

        $this->crud->setColumns([
			[ 'name' => 'title', 'label' => "Title" ],     
            [ 'name' => 'slug', 'label' => "Slug" ]
		]);
		
		$this->crud->addField([
            'name' => 'title',
            'label' => "Title"
        ]);
		$this->crud->addField([
            'name' => 'slug',
            'label' => "Slug"
        ]);
        $this->crud->addField([
            'name' => 'content',
            'label' => "Contenu",
            'type' => "wysiwyg"
        ]);
        
		
    }
	
	
    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
		
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
		
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
