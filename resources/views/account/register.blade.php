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
                            <form method="POST" name="registrationForm" id="registrationForm">
                                <h4 class="modal-title text-center fw-bold text-uppercase py-2">Créez votre compte</h4>

                                <div class="input-group rounded-1 mb-3">
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nom complet" aria-describedby="basic-addon2" value="{{ old('name') }}">
                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-user"></i></span>
                                    @error('name')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="input-group rounded-1 mb-3">
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" aria-describedby="basic-addon2" value="{{ old('email') }}">
                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-envelope"></i></span>
                                    @error('email')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="input-group rounded-1 mb-3">
                                    <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Téléphone" aria-describedby="basic-addon2" value="{{ old('phone') }}">
                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-phone"></i></span>
                                    @error('phone')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="input-group rounded-1 mb-3">
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mot de passe" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-lock"></i></span>
                                    @error('password')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="input-group rounded-1 mb-3">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password') is-invalid @enderror" placeholder="Cnofirmation du mot de passe" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-lock"></i></span>
                                    @error('password')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-default text-uppercase rounded-1 border-1">
                                    Enregister
                                    <i class="fa fa-sign-in text-white"></i>
                                </button>
                            </form>
                        </div>
                        <div class="text-center small pt-4">Vous avez déjà un compte?
                            <a class="active" href="{{ route('account.login') }}">Connectez-vous</a>
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

            $("button[type='submit']").prop('disabled',true);

            $.ajax({
                url: '{{ route("account.processRegister") }}',
                type: 'POST',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){
                    $("button[type='submit']").prop('disabled',false);
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

                        window.location.href="{{ route('account.login') }}";

                    }
                },
                error: function(JQXHR, execption){
                    console.log('Something went wrong');
                }
            });
        });

    </script>

@endsection
