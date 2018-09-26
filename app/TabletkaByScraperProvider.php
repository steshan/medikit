<?php

namespace App;


class TabletkaByScraperProvider
{
    private $cache = array();

    public function autocomplete($name) {
        $filename = 'http://tabletka.by/autocomplete.php?q=' . urlencode($name);
        $page = file_get_contents($filename);
        $data = explode("\n", $page);
        return $data;
    }

    public function getForm($name) {
        $result = array();
        $filename = 'http://tabletka.by/result1.php?tlec=' . urlencode($name);
        if (!array_key_exists($name, $this->cache)) {
            $this->cache[$name] = file_get_contents($filename);
        }
        $page = $this->cache[$name];
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($page);
        $doc->preserveWhiteSpace = false;
        $tables = $doc->getElementById('kotel');
        $rows = $tables->getElementsByTagName('tr');
        $subject = $rows[0]->nodeValue;
        if (mb_strstr($subject, "Макс")) {
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
        $filename = 'http://tabletka.by/result1.php?tlec=' . urlencode($name);
        if (!array_key_exists($name, $this->cache)) {
            $this->cache[$name] = file_get_contents($filename);
        }
        $page = $this->cache[$name];
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($page);
        $doc->preserveWhiteSpace = false;
        $tables = $doc->getElementById('kotel');
        $rows = $tables->getElementsByTagName('tr');
        $name = $rows[1]->getElementsByTagName('td');
        $subject = $rows[0]->nodeValue;
        if (mb_strstr($subject, "Макc")) {
            $result = $name->item(4)->nodeValue;
        } else {
            $result = $name->item(2)->nodeValue;
        }
        return $result;
    }
}