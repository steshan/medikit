<?php

namespace App\Http\Controllers;

use App\Medicine;

class MainController extends Controller
{
    public function __invoke()
    {
        $grid = \DataGrid::source(new Medicine());
        $grid->add('name', 'Название лекарства', true);
        $grid->add('expiration_date|strtotime|date[d/m/Y]', 'Срок годности', true);
        $grid->add('comment', 'Комментарий');
        $grid->add('form', 'Форма выпуска');
        $grid->add('component', 'Действующее вещество');
        $grid->edit('/update/', 'Edit','modify|delete');
        $grid->link('/add',"Добавить лекарство", "TR");

        $grid->paginate(10);

        return  view('main', compact( 'grid'));
    }
}
