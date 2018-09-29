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
                'id' => $entry->id,
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
            return redirect('add')->with('status', 'Medicine name is not selected');
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
            return redirect('add')->with('status', 'Medicine component is not selected');
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
            return redirect('add')->with('status', 'Medicine form is not supplied');
        }
        if (request()->has('medicine_date')) {
            $stock->expiration_date = request('medicine_date');
        } else {
            return redirect('add')->with('status', 'Expiration date is not supplied');
        }
        if (request()->has('medicine_comment')) {
            $stock->comment = request('medicine_comment');
        }
        $stock->save();
        return redirect('')->with('status', 'Medicine saved');
    }

    public function searchMedicine(Request $request)
    {
        $data = array();
        if (request()->has('search')) {
            $text = $request->input('search');
            foreach (Stock::all() as $entry) {
                if (mb_stristr($entry->medicament->name, $text) or mb_stristr($entry->component->name, $text)) {
                    array_push($data, array(
                        'id' => $entry->id,
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
            $result = $this->provider->getForm($filter);
        }
        return json_encode($result);
    }

    public function getComponent(Request $request)
    {
        if ($request->has('term')) {
            $filter = $request->input('term');
            return json_encode($this->provider->getComponent($filter));
        }
    }

    public function delete($id)
    {
        Stock::where('id', $id)->delete();
        return redirect('')->with('status', 'Deleted');
    }

    public function updateForm($id)
    {
        $data = Stock::where('id', $id)->first();
        $result = array(
	            'id' => $data->id,
                'name' => $data->medicament->name,
                'component' => $data->component->name,
                'form' => $data->form->name,
                'expiration' => $data->expiration_date,
                'comment' => $data->comment
            );
        return view('update', ['data' => $result]);
    }

    public function updateMedicine(Request $request, $id)
    {
        $stock = Stock::find($id);
        if ($request->has('comment')) {
            $stock->comment = $request->input('comment');
        } else {
            $stock->comment = '';
        }
        $stock->save();
        return redirect('')->with('status', 'Saved');
    }
}
