<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidat extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function entretien()
    {
        return $this->hasOne('App\Entretien');
    }

    public function recruteur()
    {
        return $this->belongsTo('App\Recruteur');
    }
}
