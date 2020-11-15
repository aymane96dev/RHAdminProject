@extends('layouts.app')

@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
        </div>
    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row justify-content-center" id="app">
        <div class="col-xl-4 mb-5 mb-xl-0 text-white" >
            <div class="card ">
                <div class="card-body text-dark">
                  <h5 class="card-title text-xl">Liste des actions</h5>
                  <p class="card-text">Cette liste montre chaque couleur et leur pointage correspondant dans le calendrier.</p>
                </div>
                <ul class="list-group">
                  <li class="list-group-item text-dark font-weight-bold"><i class="fas fa-square fa-lg text-custom-purple"></i> &nbsp; Pause déjeuner</li>
                  <li class="list-group-item text-dark font-weight-bold"><i class="fas fa-square fa-lg text-custom-grey"></i> &nbsp; Pause café</li>
                  <li class="list-group-item text-dark font-weight-bold"><i class="fas fa-square fa-lg text-primary"></i> &nbsp; Plusieurs pointages</li>
                  <li class="list-group-item text-dark font-weight-bold"><i class="fas fa-square fa-lg text-warning"></i> &nbsp; Autres</li>
                </ul>
              </div>
        </div>
        <div class="col-xl-8 mb-5 mb-xl-0 text-white">
            <pointage-component></pointage-component>
        </div>
    </div>
</div>  
@endsection