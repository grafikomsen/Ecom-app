@extends('layouts.app')
@section('content')

    <section class="section-5 py-3 pt-4 pb-2 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-text" href="{{ route('home') }}">Acceuil</a>
                    </li>
                    <li class="breadcrumb-item">Mon compte</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-11 bg-light py-4">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('account.sidebar')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Informations personnelles</h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name">Nom</label>
                                    <input type="text" name="name" id="name" placeholder="Entrez votre nom" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" placeholder="Entrez votre e-mail" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="phone">Téléphone</label>
                                    <input type="text" name="phone" id="phone" placeholder="Entrez votre téléphone" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="phone">Adresse</label>
                                    <textarea name="address" id="address" class="form-control" cols="30" rows="5" placeholder="Entrez votre adresse"></textarea>
                                </div>

                                <div class="d-flex">
                                    <button class="btn btn-dark">Mise à jour</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
