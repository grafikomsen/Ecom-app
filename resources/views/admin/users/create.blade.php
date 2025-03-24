@extends('admin.layouts.app')
@section('main')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Créer</h1>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.subcategorie') }}" class="btn btn-primary border-0 rounded-1">Retour</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form name="userForm"  id="userForm">
                <div class="card rounded-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Nom</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Nom">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="email">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Téléphone</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Téléphone">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Mot de passe</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="email">Status</label>
                                    <select name="status" id="status" class="form-control rounded-1">
                                        <option value="1">Active</option>
                                        <option value="0">Désactivé</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary rounded-1 border-0">Sauvegardez</button>
                    <a href="{{ route('admin.users') }}" class="btn btn-danger rounded-1 float-end ml-3">Annulez</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        $('#userForm').submit(function (event) {
            event.preventDefault();
            let element = $(this);
            $("button[type=submit]").prop('desabled', true);

            $.ajax({
                url: '{{ route("admin.users.store") }}',
                type: 'POST',
                data: element.serializeArray(),
                dataType: 'JSON',
                success: function (response) {
                    $("button[type=submit]").prop('desabled', false);

                    if (response['status'] == true) {

                        window.location.href="{{ route('admin.users') }}";

                        $('#name').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html('');

                        $('#email').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html('');

                        $('#phone').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html('');

                        $('#password').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html('');

                    } else {

                        let errors = response['errors'];
                        // NAME
                        if (errors['name']) {
                            $('#name').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['name']);
                        } else {
                            $('#name').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html('');
                        }

                        // EMAIL
                        if (errors['email']) {
                            $('#email').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['email']);
                        } else {
                            $('#email').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html('');
                        }

                        // PHONE
                        if (errors['phone']) {
                            $('#phone').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['phone']);
                        } else {
                            $('#phone').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html('');
                        }

                        // PASSWORD
                        if (errors['password']) {
                            $('#password').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['password']);
                        } else {
                            $('#password').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html('');
                        }
                    }

                }, error: function (jqXHR, exception) {
                    console.log("Something went wrong");
                }
            });
        });
    </script>
@endsection
