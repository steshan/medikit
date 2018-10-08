<?php

namespace App\Http\Controllers;

use App\Medicine;
use Illuminate\Http\Request;


class MedicineController extends Controller
{
    public function createMedicine()
    {
        $stock = new Medicine();
        if (request()->filled('auto_name')) {
            $stock->name = request('auto_name');
        } else {
            return redirect('/medicine/create')->with('status', 'Medicine name is not selected');
        }
        if (request()->filled('component')) {
            $stock->component = request('component');
        } else {
            return redirect('/medicine/create')->with('status', 'Medicine component is not selected');
        }
        if (request()->filled('form')) {
            $stock->form = request('form');
        } else {
            return redirect('/medicine/create')->with('status', 'Medicine form is not supplied');
        }
        if (request()->filled('expiration_date')) {
            $stock->expiration_date = request('expiration_date');
        } else {
            return redirect('/medicine/create')->with('status', 'Expiration date is not supplied');
        }
        if (request()->filled('comment')) {
            $stock->comment = request('comment');
        }
        $stock->save();
        return redirect('/')->with('status', 'Medicine saved');
    }

    public function createMedicineView()
    {
        $edit = \DataEdit::source(new Medicine());
        // TODO: Why do we need to set options?
        $edit->add('name', 'Название', 'autocomplete')->options(array(''))->remote('', 'names', "/data/names")->limit(15)->onchange('updateMedicineForm()');
        $edit->add('form', 'Форма выпуска', 'select')->options(array('не задана'));
        $edit->add('component', 'Действующее вещество', 'text');
        $edit->add('expiration_date', 'Срок годности', 'date')->format('Y-m-d', 'ru');
        $edit->add('comment', 'Комментарий', 'textarea');
        $edit->link('/', "На главную", "TR");
        return $edit->view('edit', compact('edit'));
    }

    public function updateMedicineView()
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

    public function deleteMedicine()
    {
        if (request()->has('do_delete')) {
            Medicine::where('id', request('do_delete'))->delete();
            return redirect('/')->with('status', 'Deleted');
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
        return redirect('/')->with('status', 'Saved');
    }
}