<?php

namespace App\Http\Controllers;

use App\TabletkaByScraperProvider;
use Illuminate\Http\Request;

class MedicineControllerTest extends Controller
{
    private $provider;

    public function __construct()
    {
        $this->provider = new TabletkaByScraperProvider();
    }

    public function nameList(Request $request)
    {
        $result = array();
        if ($request->has('term')) {
            $filter = $request->input('term');
            $result = $this->provider->autocomplete($filter);
        }
        return json_encode($result);
    }

    public function formList(Request $request)
    {
        $result = array();
        if ($request->has('term')) {
            $filter = $request->input('term');
            $result = array($this->provider->getComponent($filter));
            $result = array_merge($result, $this->provider->getForm($filter));
        }
        return json_encode($result);
    }
}