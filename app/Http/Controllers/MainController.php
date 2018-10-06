<?php

namespace App\Http\Controllers;

use App\Medicine;
use Illuminate\Http\Request;
use App\TabletkaByScraperProvider;

class MainController extends Controller
{
    private $provider;

    public function __construct()
    {
        $this->provider = new TabletkaByScraperProvider();
    }

    public function __invoke()
    {
        $filter = \DataFilter::source(new Medicine());
        $filter->add('name','Название лекарства', 'text');
        $filter->submit('поиск');
        $filter->reset('очистить');
        $filter->build();

        $grid = \DataGrid::source($filter);
        $grid->add('name', 'Название лекарства', true);
        $grid->add('expiration_date|strtotime|date[Y-m-d]', 'Срок годности', true);
        $grid->add('comment', 'Комментарий');
        $grid->add('form', 'Форма выпуска');
        $grid->add('component', 'Действующее вещество');
        $grid->edit('/update/', 'Edit','modify|delete');
        $grid->link('/add', "Добавить лекарство", "TR");

        $grid->row(function ($row) {
            if (strtotime($row->cell('expiration_date')->value) < time()) {
                $row->style("background-color:#f2dede");
            }
        });

        $grid->paginate(10);

        return  view('main', compact( 'filter', 'grid'));
    }

    public function addMedicine()
    {
        $stock = new Medicine();
        if (request()->has('auto_name')) {
             $stock->name = request('auto_name');
        } else {
            return redirect('add')->with('status', 'Medicine name is not selected');
        }
        if (request()->has('component')) {
            $stock->component = request('component');
        } else {
            return redirect('add')->with('status', 'Medicine component is not selected');
        }
        if (request()->has('form')) {
           $stock->form = request('form');
        } else {
            return redirect('add')->with('status', 'Medicine form is not supplied');
        }
        if (request()->has('expiration_date')) {
            $stock->expiration_date = request('expiration_date');
        } else {
            return redirect('add')->with('status', 'Expiration date is not supplied');
        }
        if (request()->has('comment')) {
            $stock->comment = request('comment');
        }
        $stock->save();
        return redirect('')->with('status', 'Medicine saved');
    }

    public function addForm()
    {
        $edit = \DataEdit::source(new Medicine());
        $edit->add('name', 'Название', 'autocomplete')->remote(null, 'names', "/namelist")->onchange('updateMedicineForm()');
        $edit->add('form', 'Форма выпуска', 'select')->options(array('не задана'));
        $edit->add('component', 'Действующее вещество', 'text');
        $edit->add('expiration_date', 'Срок годности', 'date')->format('Y-m-d', 'ru');
        $edit->add('comment', 'Комментарий', 'textarea');
        $edit->link('/', "На главную", "TR");
        return $edit->view('edit', compact('edit'));
    }

    public function updateForm()
    {
        $edit = \DataEdit::source(new Medicine());
        $edit->back('update|do_delete', '/');
        $edit->add('name', 'Название', 'text')->mode('readonly');
        $edit->add('form', 'Форма выпуска', 'text')->mode('readonly');
        $edit->add('component', 'Действующее вещество', 'text')->mode('readonly');
        $edit->add('expiration_date', 'Срок годности', 'date')->format('Y-m-d', 'ru')->mode('readonly');
        $edit->add('comment', 'Комментарий', 'textarea');
        return $edit->view('edit', compact('edit'));
    }

    public function delete()
    {
        if (request()->has('do_delete')) {
            Medicine::where('id', request('do_delete'))->delete();
            return redirect('')->with('status', 'Deleted');
        }
    }

    public function updateMedicine(Request $request)
    {
        if ($request->has('update')) {
            $stock = Medicine::find($request->input('update'));
        }
        if ($request->has('comment')) {
            $stock->comment = $request->input('comment');
        } else {
            $stock->comment = '';
        }
        $stock->save();
        return redirect('')->with('status', 'Saved');
    }

    public function nameList(Request $request)
    {
        $result = array();
        if ($request->has('q')) {
            $names =  $this->provider->autocomplete($request->input('q'));
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
