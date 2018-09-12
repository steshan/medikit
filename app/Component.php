<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $table = 'medicine_component';
    public $timestamps = false;

    public function stock()
    {
        return $this->belongsTo('App\Stock', 'id', 'component_id');

    }


}