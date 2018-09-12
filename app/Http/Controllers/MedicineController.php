<?php

namespace App\Http\Controllers;

use App\Medicament;
use App\Component;
use App\Stock;
use App\Form;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function showExpired()
    {
        $data = [];
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
        $data = [];
        $stock_id = [];
        if (request()->has('search')) {
            $text = $request->input('search');
            $names = Medicament::where('name', 'like', '%' . $text . '%')->get();
            foreach ($names as $name) {
                array_push($stock_id, $name->stock->id);
            }
            $components = Component::where('name', 'like', '%' . $text . '%')->get();
            foreach ($components as $name) {
                array_push($stock_id, $name->stock->id);
            }
            foreach ($stock_id as $name) {
                $stock = Stock::find($name);
                array_push($data, array(
                    'name' => $stock->medicament->name,
                    'component' => $stock->component->name,
                    'form' => $stock->form->name,
                    'expiration' => $stock->expiration_date,
                    'comment' => $stock->comment
                ));
            }
            return view('main', ['data' => $data]);
        }
    }

 /*   public function test()
    {
        $filename = 'http://tabletka.by/autocomplete.php?q=%D0%B0%D0%BD%D0%B0';
        $page = file_get_contents($filename);
//        echo $page;
        echo '<br>';
        $data = explode("\n", $page);
        foreach ($data as $str){
            echo  $str;
            echo '<br>';
        }
        //echo count($data);
    }*/

    public function nameList()
    {
        $filter = $_GET['term'];
        $filename = 'http://tabletka.by/autocomplete.php?q=' . urlencode($filter);
        $page = file_get_contents($filename);
        $data = explode("\n", $page);
        $output = array();
        foreach ($data as $str) {
            $output[$str] = $str;
        }

        $output = json_encode($output);

        return $output;
    }

    public function formList(){
        $filter = $_GET['term'];
        //echo $filter;
        $filename = 'http://tabletka.by/result1.php?tlec=' . urlencode($filter);
        $page = file_get_contents($filename);
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($page);
        $doc->preserveWhiteSpace = false;
        $tables = $doc->getElementById('kotel');
        $rows = $tables->getElementsByTagName('tr');
        $name = $rows[1]->getElementsByTagName('td');
        //echo $name->item(1)->nodeValue . '<br>';
        //echo $name->item(4)->nodeValue . '<br>';
        $result = array();
        $result[0] =$name->item(4)->nodeValue;

        $i = 0;
        foreach ($rows as $row) {
            if ($i <> 0) {
                $cols = $row->getElementsByTagName('td');
                //$i = $i + 1;
                //echo $cols->item(2)->nodeValue . '<br>';
                $name = $cols->item(2)->nodeValue;
                $result[$i] = $name;
            }
            $i = $i + 1;
        }
        //print_r($result);

        $result = json_encode($result);

        return $result;
    }

 /*   public function medicineList(){
        //$results = array('1' => 'Москва', '2' => 'Минск', '3' => 'Брест', '4' => 'Витебск');
        $results = array('aaaa', 'bbbb', 'cccc', 'dddd');
        $filter = $_GET['term'];
        $output = array();
        //if (request()->has('term')) {
            foreach ($results as $result){
                if (substr_count($result, $filter) > 0)
                    $output[$result] = $result;
            }

        //}
        $output = json_encode($output);
        return $output;
    }

*/

    public function test2()
    {
        $filename = "http://tabletka.by/result1.php?tlec=%D0%BF%D0%B0%D1%80%D0%B0%D1%86%D0%B5%D1%82%D0%B0%D0%BC%D0%BE%D0%BB";
        $page = file_get_contents($filename);
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($page);
        $doc->preserveWhiteSpace = false;
        $tables = $doc->getElementById('kotel');
        $rows = $tables->getElementsByTagName('tr');
        $name = $rows[1]->getElementsByTagName('td');
        //echo $name->item(1)->nodeValue . '<br>';
        echo $name->item(4)->nodeValue . '<br>';
        $i = 0;
        foreach ($rows as $row) {
            if ($i <> 0) {
                $cols = $row->getElementsByTagName('td');
               // echo $cols->item(2)->nodeValue . '<br>';
                echo '<br>';
            }
            $i = 1;
        }
    }
}
