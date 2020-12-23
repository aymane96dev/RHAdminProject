<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand navbar-expand-lg " href="{{ route('home') }}" >
            <strong class="text-dark font-weight-900"> RC<span class="red-logo">2</span>K</strong> <small class="red-logo"> Ingénierie</small>
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('assets/img/user.png') }}"> <!-- /img/theme/team-1-800x800.jpg -->
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Bienvenue !') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('Mon profil') }}</span>
                    </a>
                    <a href="{{ route('user.index') }}" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Paramètres') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Se Déconnecter') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a class="navbar-brand navbar-expand-lg " href="{{ route('home') }}" >
                            <strong class="text-dark font-weight-900"> RC<span class="red-logo">2</span>K</strong> <small class="red-logo"> Ingénierie</small>
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#navbar-users" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-users">
                        <i class="fas fa-cogs" style="color: #f4645f;"></i>
                        <span class="nav-link-text text-sm" >Gestion des utilisateurs</span>
                    </a>

                    <div class="collapse @if(Route::is('profile.edit') || Route::is('user.index')) show @endif" id="navbar-users">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item @if(Route::is('profile.edit')) bg-danger @endif">
                                <a class="nav-link" href="{{ route('profile.edit') }}">
                                    <i class="ni ni-circle-08 text-pink @if(Route::is('profile.edit')) text-white @endif"></i>
                                    <span class="@if(Route::is('profile.edit')) text-white @endif">Votre profil</span>
                                </a>
                            </li>
                            @if(Auth::user()->role === 'administrateur')
                            <li class="nav-item @if(Route::is('user.index')) bg-danger @endif">
                                <a class="nav-link " href="{{ route('user.index') }}">
                                    <i class="ni ni-single-02 text-green @if(Route::is('user.index')) text-white @endif"></i>
                                    <span class="@if(Route::is('user.index')) text-white @endif">Utilisateur</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>

                <li class="nav-item @if(Route::is('employe')) bg-danger @endif">
                    <a class="nav-link" href="{{ route('employe') }}">
                        <i class="fas fa-user-cog text-dark @if(Route::is('employe')) text-white @endif"></i> 
                        <span class="@if(Route::is('employe')) text-white @endif">Gestion des employés</span>
                    </a>
                </li>

                @if(Auth::user()->role === 'chef_projet' || Auth::user()->role === 'administrateur')
                <li class="nav-item @if(Route::is('equipe')) bg-danger @endif">
                    <a class="nav-link" href="{{ route('equipe') }}">
                        <i class="fas fa-users text-primary @if(Route::is('equipe')) text-white @endif"></i> 
                        <span class="@if(Route::is('equipe')) text-white @endif">Gestion des équipes</span>
                    </a>
                </li>
                @endif

                <li class="nav-item  @if(Route::is('competence')) bg-danger @endif">
                    <a class="nav-link" href="{{ route('competence') }}">
                        <i class="fas fa-toolbox text-success @if(Route::is('competence')) text-white @endif"></i>
                        <span class="@if(Route::is('competence')) text-white @endif">Gestion des compétences</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#navbar-pauses" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-pauses">
                        <i class="fas fa-cogs" style="color: #e60380;"></i>
                        <span class="nav-link-text text-sm" >Gestion des pauses</span>
                    </a>

                    <div class="collapse @if(Route::is('pointage') || Route::is('history')) show @endif" id="navbar-pauses">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item @if(Route::is('pointage')) bg-danger @endif">
                                <a class="nav-link " href="{{ route('pointage') }}">
                                    <i class="fas fa-hand-pointer text-blue @if(Route::is('pointage')) text-white @endif"></i>
                                    <span class="@if(Route::is('pointage')) text-white @endif">Pointage des pauses</span>
                                </a>
                            </li>
                            <li class="nav-item @if(Route::is('history')) bg-danger @endif">
                                <a class="nav-link @if(Route::is('history')) text-white @endif" href="{{ route('history') }}">
                                    <i class="fas fa-history text-info @if(Route::is('history')) text-white @endif"></i>
                                    <span class="@if(Route::is('history')) text-white @endif"> L'historique des pauses</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#navbar-conge" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fas fa-cogs" style="color: #ff9306;"></i>
                        <span class="nav-link-text text-sm" >Gestion des congés</span>
                    </a>

                    <div class="collapse @if(Route::is('conge') || Route::is('demande') || Route::is('valdemande')
                        || Route::is('calendrier') || Route::is('countconges')) show @endif" id="navbar-conge">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item @if(Route::is('conge')) bg-danger @endif">
                                <a class="nav-link" href="{{ route('conge') }}">
                                    <i class="fas fa-align-justify text-warning @if(Route::is('conge')) text-white @endif"></i>
                                    <span class="@if(Route::is('conge')) text-white @endif">Les congés</span>
                                </a>
                            </li>
                            <li class="nav-item @if(Route::is('demande')) bg-danger @endif">
                                <a class="nav-link" href="{{ route('demande') }}">
                                    <i class="far fa-calendar text-primary @if(Route::is('demande')) text-white @endif"></i>
                                    <span class="@if(Route::is('demande')) text-white @endif">Les demandes de congé</span>
                                </a>
                            </li>
                            <li class="nav-item @if(Route::is('calendrier')) bg-danger @endif">
                                <a class="nav-link " href="{{ route('calendrier') }}">
                                    <i class="fas fa-align-justify text-purple @if(Route::is('calendrier')) text-white @endif"></i>
                                    <span class="@if(Route::is('calendrier')) text-white @endif">Calendrier</span>
                                </a>
                            </li> 
                            @if(Auth::user()->role === 'chef_projet' || Auth::user()->role === 'administrateur')
                            <li class="nav-item @if(Route::is('valdemande')) bg-danger @endif">
                                <a class="nav-link " href="{{ route('valdemande') }}">
                                    <i class="fas fa-align-justify text-purple @if(Route::is('valdemande')) text-white @endif"></i>
                                    <span class="@if(Route::is('valdemande')) text-white @endif">Validation des demandes de congé</span>
                                </a>
                            </li>
                            <li class="nav-item @if(Route::is('countconges')) bg-danger @endif">
                                <a class="nav-link" href="{{ route('countconges') }}">
                                    <i class="fas fa-align-justify text-warning @if(Route::is('countconges')) text-white @endif"></i>
                                    <span class="@if(Route::is('countconges')) text-white @endif">Compter le total des congés</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @if(Auth::user()->role === 'chef_projet' || Auth::user()->role === 'administrateur')
                <li class="nav-item">
                    <a class="nav-link" href="#navbar-ressources" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-ressources">
                        <i class="fas fa-cogs" style="color: #e6034f;"></i>
                        <span class="nav-link-text text-sm" >Gestion des ressources</span>
                    </a>

                    <div class="collapse @if(Route::is('projet') || Route::is('materiel')) show @endif" id="navbar-ressources">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item @if(Route::is('projet')) bg-danger @endif">
                                <a class="nav-link" href="{{ route('projet') }}">
                                    <i class="fas fa-briefcase text-green @if(Route::is('projet')) text-white @endif"></i>
                                    <span class="@if(Route::is('projet')) text-white @endif">Les projets</span>
                                </a>
                            </li>
                            <li class="nav-item @if(Route::is('materiel')) bg-danger @endif">
                                <a class="nav-link @if(Route::is('materiel')) text-white @endif" href="{{ route('materiel') }}">
                                    <i class="fas fa-wrench text-warning @if(Route::is('materiel')) text-white @endif"></i>
                                    <span class="@if(Route::is('materiel')) text-white @endif">Les matériaux</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                @if(Auth::user()->role === 'administrateur')
                <li class="nav-item">
                    <a class="nav-link" href="#navbar-finance" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-recrute">
                        <i class="fas fa-cogs" style="color: #f4645f;"></i>
                        <span class="nav-link-text text-sm" >Gestion du financement</span>
                    </a>
                    <div class="collapse @if(Route::is('solde') || Route::is('contrat')) show @endif" id="navbar-finance">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item @if(Route::is('solde')) bg-danger @endif">
                                <a class="nav-link @if(Route::is('solde')) text-white @endif" href="{{ route('solde') }}">
                                    <i class="fas fa-align-justify text-warning @if(Route::is('solde')) text-white @endif"></i>
                                    <span class="@if(Route::is('solde')) text-white @endif">Les soldes</span>
                                </a>
                            </li>
                            <li class="nav-item @if(Route::is('contrat')) bg-danger @endif">
                                <a class="nav-link @if(Route::is('contrat')) text-white @endif" href="{{ route('contrat') }}">
                                    <i class="fas fa-align-justify text-green @if(Route::is('contrat')) text-white @endif"></i>
                                    <span class="@if(Route::is('contrat')) text-white @endif">Les contrats</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#navbar-recrute" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-recrute">
                        <i class="fas fa-cogs" style="color: #f4645f;"></i>
                        <span class="nav-link-text text-sm" >Gestion de recrutement</span>
                    </a>

                    <div class="collapse @if(Route::is('candidat') || Route::is('entretien') || Route::is('calentretien')) show @endif" id="navbar-recrute">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item @if(Route::is('candidat')) bg-danger @endif">
                                <a class="nav-link @if(Route::is('candidat')) text-white @endif" href="{{ route('candidat') }}">
                                    <i class="fas fa-align-justify text-warning @if(Route::is('candidat')) text-white @endif"></i>
                                    <span class="@if(Route::is('candidat')) text-white @endif">Les candidats</span>
                                </a>
                            </li>
                            <li class="nav-item @if(Route::is('entretien')) bg-danger @endif">
                                <a class="nav-link @if(Route::is('entretien')) text-white @endif" href="{{ route('entretien') }}">
                                    <i class="fas fa-align-justify text-green @if(Route::is('entretien')) text-white @endif"></i>
                                    <span class="@if(Route::is('entretien')) text-white @endif">Les entretiens</span>
                                </a>
                            </li>
                            <li class="nav-item @if(Route::is('calentretien')) bg-danger @endif">
                                <a class="nav-link @if(Route::is('calentretien')) text-white @endif" href="{{ route('calentretien') }}">
                                    <i class="far fa-calendar text-primary @if(Route::is('calentretien')) text-white @endif"></i>
                                    <span class="@if(Route::is('calentretien')) text-white @endif">Calendrier des entretiens</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>