@extends('layouts.app')
@section('content')
<main>
    <section class="section-5 py-3 pt-4 pb-2 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-text" href="{{ route('home') }}">Acceuil</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-text" href="{{ route('account.profile') }}">Mon compte</a>
                    </li>
                    <li class="breadcrumb-item">Modifiez le mot de passe</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-11 bg-light py-4">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('account.sidebar')
                </div>
                <div class="col-md-9">
                    @if(Session::has('success'))
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Succés!</strong> {{ Session::get('success') }}.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    @if(Session::has('error'))
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ Session::get('error') }}.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    <form method="POST" name="changePasswordForm" id="changePasswordForm">
                        <div class="card rounded-1">
                            <div class="card-header bg-primary rounded-0">
                                <h2 class="h5 mb-0 pt-2 text-white pb-2">Change Password</h2>
                            </div>
                            <div class="card-body p-4 rounded-0">
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="name">Old Password</label>
                                        <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name">New Password</label>
                                        <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Old Password" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="d-flex">
                                        <button type="submit" name="submit" id="submit" class="btn btn-default rounded-1">
                                            Modifiez
                                            <i class="fa fa-upload text-white"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
@section('customJs')
    <script>
        $('#changePasswordForm').submit(function(e){
            e.preventDefault();
            $("#submit").prop('disabled',true);

            $.ajax({
                url: '{{ route("account.changePassword") }}',
                type: 'POST',
                data: $(this).serializeArray(),
                dataType: 'JSON',
                success: function(response){
                    $("#submit").prop('disabled',false);
                    if(response.status == true){

                        window.location.href="{{ route('account.showChangePassword') }}";

                        $('#old_password').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html('');

                        $('#new_password').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html('');

                        $('#confirm_password').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html('');

                    } else {
                        var errors = response.errors;

                        // OLD_PASSWORD
                        if (errors.old_password) {
                            $('#old_password').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors.old_password);
                        } else {
                            $('#old_password').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html('');
                        }

                        // NEW_PASSWORD
                        if (errors.new_password) {
                            $('#new_password').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors.new_password);
                        } else {
                            $('#new_password').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html('');
                        }

                        // CONFIRM_PASSWORD
                        if (errors.confirm_password) {
                            $('#confirm_password').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors.confirm_password);
                        } else {
                            $('#confirm_password').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html('');
                        }
                    }
                }
            });
        });
    </script>
@endsection
