<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employe extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function recruteurs()
    {
        return $this->belongsToMany('App\Recruteur');
    }

    public function contrat()
    {
        return $this->hasOne('App\Contrat');
    }

    public function pointages()
    {
        return $this->hasMany('App\Pointage');
    }

    public function equipe()
    {
        return $this->belongsTo('App\Equipe');
    }

    public function formations()
    {
        return $this->belongsToMany('App\Formation');
    }

    /* public function user()
    {
        return $this->belongsTo('App\User');
    } */

    public function competences()
    {
        return $this->belongsToMany('App\Competence');
    }

    public function conges()
    {
        return $this->hasMany('App\Conge');
    }

    public function materiels()
    {
        return $this->hasMany('App\Materiel');
    }

    public function demandes_conge()
    {
        return $this->hasMany('App\Demande_conge');
    }

    public function soldes()
    {
        return $this->hasMany('App\Solde');
    }
}
