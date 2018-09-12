<?php

namespace App\Http\Controllers;

use \App\Stock;

class MainController extends Controller
{
	public function __invoke()
	{
        $data = [];
	    foreach (Stock::all() as $entry) {
	        array_push($data, array(
                'name' => $entry->medicament->name,
                'component' => $entry->component->name,
                'form' => $entry->form->name,
                'expiration' => $entry->expiration_date,
                'comment' => $entry->comment
            ));
        }
		return view('main', ['data' => $data]);
	}
}
