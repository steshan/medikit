<?php

namespace App\Http\Controllers;

use App\Medicine;
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
        $stock = Medicine::where('expiration_date', '<', $today)->get();
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
        $stock = new Medicine();
        if (request()->has('medicine_name')) {
             $stock->name = request('medicine_name');
        } else {
            return redirect('add')->with('status', 'Medicine name is not selected');
        }
        if (request()->has('medicine_component')) {
            $stock->component = request('medicine_component');
        } else {
            return redirect('add')->with('status', 'Medicine component is not selected');
        }
        if (request()->has('medicine_form')) {
           $stock->form = request('medicine_form');
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
            foreach (Medicine::all() as $entry) {
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
        Medicine::where('id', $id)->delete();
        return redirect('')->with('status', 'Deleted');
    }

    public function updateFormOld(Request $request)
    {
        if ($request->has('modify')) {
        $data = Medicine::where('id', $request->input('modify'))->first();
        }
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

    public function updateMedicine(Request $request)
    {
        if ($request->has('modify')) {
        $stock = Medicine::find($request->input('modify'));
        }
        if ($request->has('comment')) {
            $stock->comment = $request->input('comment');
        } else {
            $stock->comment = '';
        }
        $stock->save();
        return redirect('')->with('status', 'Saved');
    }

    public function updateForm()
    {
        $edit = \DataEdit::source(new Medicine());

        $edit->add('name', 'Название:', 'text');
        $edit->add('form', 'Форма выпуска:', 'text');
        $edit->add('component', 'Действующее вещество:', 'text');
        $edit->add('expiration_date', 'Дата выпуска', 'date');
        $edit->add('comment', 'Комментарий:', 'textarea');

        return $edit->view('edit', compact('edit'));
    }
}
