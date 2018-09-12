<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
  protected $table = 'medicine_medicament';
  public $timestamps = false;

    public function stock()
  {
    return $this->belongsTo('App\Stock', 'id', 'medicine_id');

  }


}