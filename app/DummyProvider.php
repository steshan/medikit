<?php

namespace App;

class DummyProvider
{
    private $data = <<<EOD
{
	"анальгин": {
		"component": "Метамизол натрия",
		"forms": [
			"р-р инъекц 50% 2мл N10",
			"таб 500мг N10",
			"таб 500мг N20"
		]
	},
	"анавикс": {
		"component": "Амброксол",
		"forms": [
			"сироп 15мг/5мл 120мл N1",
			"сироп 30мг/5мл 120мл N1"
		]
	}
}
EOD;

    private $medicine;

    function __construct() {
        $this->medicine = json_decode($this->data, true);
    }

    public function autocomplete($name){
        $result = array();
        foreach ($this->medicine as $item => $value){
            if (strstr($item, $name)) {
                array_push($result, $item);
            }
        }
        return $result;
    }

    public function getForm($name){
        $result = array();
        if (array_key_exists($name, $this->medicine)){
            $result = $this->medicine[$name]['forms'];
        }
        return $result;
    }

    public function getComponent($name){
        $result = '';
        if (array_key_exists($name, $this->medicine)){
            $result = $this->medicine[$name]['component'];
        }
        return $result;
    }
}