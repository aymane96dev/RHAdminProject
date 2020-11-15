<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Demande_conge extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function conge()
    {
        return $this->belongsTo('App\Conge');
    }

    public function employe()
    {
        return $this->belongsTo('App\Employe');
    }

    /* public function user()
    {
        return $this->hasOneThrough('App\User','App\Employe');
    } */
}