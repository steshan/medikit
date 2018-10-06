<?php

namespace App\Http\Controllers;

use App\Providers\TabletkaByScraperProvider;
use Illuminate\Http\Request;

class DataController extends Controller
{
    private $provider;

    public function __construct()
    {
        $this->provider = new TabletkaByScraperProvider();
    }

    public function nameList(Request $request)
    {
        $result = array();
        if ($request->has('q')) {
            $names = $this->provider->autocomplete($request->input('q'));
            foreach ($names as $name) {
                array_push($result, array('name' => $name));
            }
        }
        return json_encode($result);
    }

    public function formList(Request $request)
    {
        $result = array();
        if ($request->has('q')) {
            $result = $this->provider->getForm($request->input('q'));
        }
        return json_encode($result);
    }

    public function getComponent(Request $request)
    {
        $result = array();
        if ($request->has('q')) {
            $result = $this->provider->getComponent($request->input('q'));
        }
        return json_encode($result);
    }
}