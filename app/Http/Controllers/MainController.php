<?php

namespace App\Http\Controllers;

use App\Medicine;


class MainController extends Controller
{
    public function __invoke()
    {
        $filter = \DataFilter::source(new Medicine());
        $filter->add('name','Название лекарства', 'text');
        $filter->submit('поиск');
        $filter->reset('очистить');
        $filter->build();

        $grid = \DataGrid::source($filter);
        $grid->add('name', 'Наименование', true);
        $grid->add('expiration_date|strtotime|date[Y-m-d]', 'Срок годности', true);
        $grid->add('comment', 'Комментарий');
        $grid->add('form', 'Форма');
        //$grid->add('component', 'Действующее вещество');
        $grid->edit('/medicine', 'Edit','show|modify|delete');
        $grid->link('/medicine/create', "Добавить лекарство", "TR");

        $grid->row(function ($row) {
            if (strtotime($row->cell('expiration_date')->value) < time()) {
                $row->style("background-color:#f2dede");
            } elseif (strtotime($row->cell('expiration_date')->value) < time() + (30 * 24 * 60 * 60)) {
                $row->style("background-color:#efed7d");
            }
        });

        $grid->paginate(10);

        return  view('main', compact( 'filter', 'grid'));
    }
}
