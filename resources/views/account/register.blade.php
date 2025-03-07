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
                        <li class="breadcrumb-item">Inscription</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-10 bg-light">
            <div class="container">
                <div class="row py-4">
                    <div class="col-12 col-md-4"></div>
                    <div class="col-12 col-md-4">
                        <div class="card rounded-1 p-4">
                            <form action="" method="POST" name="registrationForm" id="registrationForm">
                                <h4 class="modal-title">Register Now</h4>
                                <div class="form-group pt-3">
                                    <input type="text" class="form-control" placeholder="Nom complet" id="name" name="name">
                                    <p></p>
                                </div>
                                <div class="form-group pt-3">
                                    <input type="email" class="form-control" placeholder="Email" id="email" name="email">
                                    <p></p>
                                </div>
                                <div class="form-group pt-3">
                                    <input type="text" class="form-control" placeholder="Numéro Tél" id="phone" name="phone">
                                    <p></p>
                                </div>
                                <div class="form-group pt-3">
                                    <input type="password" class="form-control" placeholder="Mot de passe" id="password" name="password">
                                    <p></p>
                                </div>
                                <div class="form-group pt-3">
                                    <input type="password" class="form-control" placeholder="Confirmation du mot de passe" id="password_confirmation" name="password_confirmation">
                                    <p></p>
                                </div>
                                <div class="form-group small my-2">
                                    <a href="#" class="forgot-link">Forgot Password?</a>
                                </div>
                                <button type="submit" class="btn btn-default">Inscription</button>
                            </form>
                            <div class="text-center small pt-2">Already have an account? <a href="{{ route('login') }}">Login Now</a></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4"></div>
                </div>
            </div>
        </section>
    </main>

@endsection

@section('customJs')

    <script>

        $("#registrationForm").submit(function(e){
            e.preventDefault();

            $.ajax({
                url: '{{ route("processRegister") }}',
                type: 'POST',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){

                    let errors = response.errors;

                    if(response.status == false){

                        if(errors.name){
                            $('#name').siblings('p').addClass('invalid-feedback').html(errors.name);
                            $('#name').addClass('is-invalid');
                        } else {
                            $('#name').siblings('p').addClass('invalid-feedback').html('');
                            $('#name').addClass('is-invalid');
                        }

                        if(errors.email){
                            $('#email').siblings('p').addClass('invalid-feedback').html(errors.email);
                            $('#email').addClass('is-invalid');
                        } else {
                            $('#email').siblings('p').addClass('invalid-feedback').html('');
                            $('#email').addClass('is-invalid');
                        }

                        if(errors.password){
                            $('#password').siblings('p').addClass('invalid-feedback').html(errors.password);
                            $('#password').addClass('is-invalid');
                        } else {
                            $('#password').siblings('p').addClass('invalid-feedback').html('');
                            $('#password').addClass('is-invalid');
                        }

                    } else {

                        $('#name').siblings('p').addClass('invalid-feedback').html('');
                        $('#name').addClass('is-invalid');

                        $('#email').siblings('p').addClass('invalid-feedback').html('');
                        $('#email').addClass('is-invalid');

                        $('#password').siblings('p').addClass('invalid-feedback').html('');
                        $('#password').addClass('is-invalid');

                        window.location.href="{{ route('login') }}";

                    }
                },
                error: function(JQXHR, execption){
                    console.log('Something went wrong');
                }
            });
        });


    </script>

@endsection
