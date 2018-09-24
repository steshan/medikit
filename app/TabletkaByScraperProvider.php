<?php

namespace App;


class TabletkaByScraperProvider
{

    public function autocomplete($name){
        $result = array();
        $filename = 'http://tabletka.by/autocomplete.php?q=' . urlencode($name);
        $page = file_get_contents($filename);
        $data = explode("\n", $page);
        foreach ($data as $str) {
            $result[$str] = $str;
        }
        return $result;
    }

    public function getForm($name){
        $result = array();
        $filename = 'http://tabletka.by/result1.php?tlec=' . urlencode($name);
        $page = file_get_contents($filename);
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($page);
        $doc->preserveWhiteSpace = false;
        $tables = $doc->getElementById('kotel');
        $rows = $tables->getElementsByTagName('tr');
        $name = $rows[1]->getElementsByTagName('td');
        $subject = $rows[0]->nodeValue;
        if (preg_match("*Макс*", $subject)) {
            $i = 0;
            foreach ($rows as $row) {
                if ($i <> 0) {
                    $cols = $row->getElementsByTagName('td');
                    $name = $cols->item(2)->nodeValue;
                    $result[$i] = $name;
                }
                $i = $i + 1;
            }
        } else {
            $i = 0;
            foreach ($rows as $row) {
                if ($i <> 0) {
                    $cols = $row->getElementsByTagName('td');
                    $name = $cols->item(1)->nodeValue;
                    $result[$i] = $name;
                }
                $i = $i + 1;
            }
        }
        return $result;
    }

    public function getComponent($name){
        $result = '';
        $filename = 'http://tabletka.by/result1.php?tlec=' . urlencode($name);
        $page = file_get_contents($filename);
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($page);
        $doc->preserveWhiteSpace = false;
        $tables = $doc->getElementById('kotel');
        $rows = $tables->getElementsByTagName('tr');
        $name = $rows[1]->getElementsByTagName('td');
        $subject = $rows[0]->nodeValue;
        if (preg_match("*Макс*", $subject)) {
            $result = $name->item(4)->nodeValue;
        } else {
            $result = $name->item(2)->nodeValue;
        }
        return $result;
    }
}