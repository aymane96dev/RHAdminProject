<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Competence extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function employes()
    {
        return $this->belongsToMany('App\Employe');
    }

  /*  public function users()
    {
        return $this->hasManyThrough('App\User','App\Employe');
    } */
}
