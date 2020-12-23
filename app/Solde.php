<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solde extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function employe()
    {
       return $this->belongsTo('App\Employe'); 
    }
}
