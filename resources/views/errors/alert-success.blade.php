@if (session('status-success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
<div class="alert-header ml-2 mb-2">
    <i class="fas fa-check-circle"></i> &nbsp;
    <strong class="mr-auto">Succès</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div >{{ session('status-success') }}</div>
</div>
@endif