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
                        <li class="breadcrumb-item">Se connecter</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-10 bg-light">
            <div class="container">
                <div class="row py-4">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
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
                        <div class="card rounded-1 p-4">
                            <form action="{{ route('account.authenticate') }}" method="POST">
                                @csrf
                                <h6 class="modal-title text-center fw-bold text-uppercase py-2">Connectez-vous à votre compte</h6>

                                <div class="input-group rounded-1 mb-3">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" aria-describedby="basic-addon2" value="{{ old('email') }}">
                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-envelope"></i></span>
                                    @error('email')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="input-group rounded-1 mb-3">
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mot de passe" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-lock"></i></span>
                                    @error('password')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-default text-uppercase rounded-1 border-0">
                                    Connexion
                                    <i class="fa fa-sign-in text-white"></i>
                                </button>

                            </form>
                        </div>
                        <div class="text-center small pt-4">
                            Je n'ai pas de compte? <a class="active" href="{{ route('account.register') }}">S'inscription</a>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
        </section>
    </main>

@endsection
