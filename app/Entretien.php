<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entretien extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function candidat()
    {
        return $this->belongsTo('App\Candidat');
    }
}
