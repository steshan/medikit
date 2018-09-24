<?php

namespace App\Http\Controllers;

use App\Medicament;
use App\Component;
use App\Stock;
use App\Form;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\TabletkaByScraperProvider;

class MedicineController extends Controller
{
    private $provider;

    public function __construct()
    {
        $this->provider = new TabletkaByScraperProvider();
    }

    public function showExpired()
    {
        $data = array();
        $today = date("Y-m-d");
        $stock = Stock::where('expiration_date', '<', $today)->get();
        foreach ($stock as $entry) {
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

    public function addForm()
    {
        return view('add');
    }

    public function addMedicine()
    {
        $stock = new Stock;
        if (request()->has('medicine_name')) {
            $name = new Medicament;
            $names = Medicament::where('name', '=', request('medicine_name'))->get();
            if (count($names) == 0) {
                $name->name = request('medicine_name');
                $name->save();
                $stock->medicine_id = $name->id;
            } else {
                foreach ($names as $name) {
                    $stock->medicine_id = $name->id;
                }
            }
        } else {
            echo 'input name';
            exit();
        }
        if (request()->has('medicine_component')) {
            $component = new Component;
            $components = Component::where('name', '=', request('medicine_component'))->get();
            if (count($components) == 0) {
                $component->name = request('medicine_component');
                $component->save();
                $stock->component_id = $component->id;
            } else {
                foreach ($components as $component) {
                    $stock->component_id = $component->id;
                }
            }
        } else {
            echo 'input component';
            exit();
        }
        if (request()->has('medicine_form')) {
            $form = new Form;
            $forms = Form::where('name', '=', request('medicine_form'))->get();
            if (count($forms) == 0) {
                $form->name = request('medicine_form');
                $form->save();
                $stock->form_id = $form->id;
            } else {
                foreach ($forms as $form) {
                    $stock->form_id = $form->id;
                }
            }
        } else {
            echo 'input form';
            exit();
        }
        if (request()->has('medicine_date')) {
            $stock->expiration_date = request('medicine_date');
        } else {
            echo 'input date';
            exit();
        }
        if (request()->has('medicine_comment')) {
            $stock->comment = request('medicine_comment');
        }
        $stock->save();
    }

    public function searchMedicine(Request $request)
    {
        $data = array();
        if (request()->has('search')) {
            $text = $request->input('search');
            foreach (Stock::all() as $entry) {
                if (stristr($entry->medicament->name, $text) or stristr($entry->component->name, $text)) {
                    array_push($data, array(
                        'name' => $entry->medicament->name,
                        'component' => $entry->component->name,
                        'form' => $entry->form->name,
                        'expiration' => $entry->expiration_date,
                        'comment' => $entry->comment
                    ));
                }
            }
        }
        return view('main', ['data' => $data]);
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
