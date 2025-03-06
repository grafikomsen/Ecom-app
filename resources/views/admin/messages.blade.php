@if (Session::has('error'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>ERROR!</strong> {{ Session::get('error') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Succés!</strong> {{ Session::get('success') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
