<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
  protected $table = 'medicine_stock';
  public $timestamps = false;

  public function medicament()
  {
    return $this->hasOne('App\Medicament', 'id', 'medicine_id');
     // return $this->belongsTo('App\Medicament');
  }

  public function component()
  {
      return $this->hasOne('App\Component', 'id', 'component_id');
      //return $this->belongsTo('App\Component');
  }

  public function form()
  {
      return $this->hasOne('App\Form', 'id', 'form_id');
      //return $this->belongsTo('App\Form');
  }




}