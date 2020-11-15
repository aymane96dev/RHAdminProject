<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contrat extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function employe()
    {
        return $this->belongsTo('App\Employe');
    }

    /* public function user()
    {
        return $this->hasOneThrough('App\User','App\Employe');
    } */
}
