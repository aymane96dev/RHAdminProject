<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipe extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function employes()
    {
        return $this->hasMany('App\Employe');
    }

    public function projets()
    {
        return $this->belongsToMany('App\Projet');
    }

    /* public function user()
    {
        return $this->hasOneThrough('App\User','App\Employe');
    } */
}
