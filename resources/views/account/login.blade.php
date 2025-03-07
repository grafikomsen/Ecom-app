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
                        <div class="card rounded-1 p-4">
                            <form action="" method="POST">
                                <h4 class="modal-title">Login to Your Account</h4>
                                <div class="form-group pt-3">
                                    <input type="text" class="form-control" placeholder="Email" required="required">
                                </div>
                                <div class="form-group pt-3">
                                    <input type="password" class="form-control" placeholder="Mot de passe" required="required">
                                </div>
                                <div class="form-group small my-2">
                                    <a href="#" class="forgot-link">Forgot Password?</a>
                                </div>
                                <button type="submit" class="btn btn-default">Se connecter</button>
                            </form>
                            <div class="text-center small pt-2">
                                Don't have an account? <a href="{{ route('register') }}">S'inscription</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
        </section>
    </main>

@endsection
