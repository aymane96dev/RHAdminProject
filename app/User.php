<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table='utilisateurs';

  /*  public function employe()
    {
        return $this->hasOne('App\Employe');
    }

    public function competences()
    {
        return $this->hasManyThrough('App\Competence','App\Employe');
    }

    public function materiels()
    {
        return $this->hasManyThrough('App\Materiel','App\Employe');
    }

    public function demandes_conge()
    {
        return $this->hasManyThrough('App\Demande_conge','App\Employe');
    }

    public function conges()
    {
        return $this->hasManyThrough('App\Conge','App\Employe');
    }

    public function pauses()
    {
        return $this->hasManyThrough('App\Pause','App\Employe');
    }

    public function formations()
    {
        return $this->hasManyThrough('App\Formation','App\Employe');
    }

    public function equipes()
    {
        return $this->hasOneThrough('App\Equipe','App\Employe');
    }

    public function contrats()
    {
        return $this->hasOneThrough('App\Contrat','App\Employe');
    }

    public function pointages()
    {
        return $this->hasManyThrough('App\Pointage','App\Employe');
    }

    public function recruteurs()
    {
        return $this->hasManyThrough('App\Recruteur','App\Employe');
    } */

}
