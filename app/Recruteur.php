<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruteur extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function candidats()
    {
        return $this->hasMany('App\Candidat');
    }

    public function entretiens()
    {
        return $this->hasMany('App\Entretien');
    }

    public function employes()
    {
        return $this->belongsToMany('App\Employe');
    }

    public function user()
    {
        return $this->hasOneThrough('App\User','App\Employe');
    }
}
