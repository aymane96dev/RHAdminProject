<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Equipe' => 'App\Policies\EquipePolicy',
        'App\Demande_conge' => 'App\Policies\DemandePolicy',
        'App\Conge' => 'App\Policies\CongePolicy',
        'App\Materiel' => 'App\Policies\MaterielPolicy',
        'App\Projet' => 'App\Policies\ProjetPolicy',
        'App\Solde' => 'App\Policies\SoldePolicy',
        'App\Contrat' => 'App\Policies\ContratPolicy',
        'App\Candidat' => 'App\Policies\CandidatPolicy',
        'App\Entretien' => 'App\Policies\EntretienPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
