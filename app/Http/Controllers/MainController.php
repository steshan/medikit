<?php

namespace App\Http\Controllers;

use App\Stock;

class MainController extends Controller
{
    public function __invoke()
    {

        $stock = new Stock();
       /* $filter = \DataGrid::source($stock::with('medicament', 'component', 'form'));
        $filter->add('{{ $medicament->name }}','Name', 'text');
        $filter->add('{{ $form->name }}','Forms','tags');
        //$filter->add('expiration_date','expiration date','daterange')->format('m/d/Y', 'en');
        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();
*/

        $grid = \DataGrid::source($stock::with('medicament', 'component', 'form'));

  //      $grid = \DataGrid::source($filter);
  //      $grid->add('id', 'ID', true);
        $grid->add('{{ $medicament->name }}', 'Название лекарства', true);
        $grid->add('expiration_date|strtotime|date[d/m/Y]', 'Срок годности', true);
        $grid->add('comment', 'Комментарий');
        $grid->add('{{ $form->name }}', 'Форма выпуска');
        $grid->add('{{ $component->name }}', 'Действующее вещество');
        $grid->edit('/update/', 'Edit','modify');
        $grid->link('/add',"Добавить лекарство", "TR");

        $grid->paginate(10);


        //return view('rapyd::demo.grid', compact('grid'));
        return  view('main', compact( 'grid'));
    }
}
