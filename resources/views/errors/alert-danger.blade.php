@if (session('status-danger') || $errors->any() )
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <div class="alert-header ml-2 mb-2">
        <i class="fas fa-exclamation-triangle "></i> &nbsp;
        <strong class="mr-auto">Vos informations n'ont pas été modifiées</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @if (session('status-danger'))<div>{{ session('status-danger') }}</div>@endif
    @if ($errors->any())
        <ul class="list-group">
            @foreach ($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">{{ $error }}</li>
            @endforeach
        </ul>
    @endif   
    </div>
    @endif