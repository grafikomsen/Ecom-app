@extends('layouts.app')
@section('content')

    <section class="section-5 py-3 pt-4 pb-2 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-text" href="{{ route('home') }}"><i class="fa fa-home" aria-hidden="true"></i> Acceuil</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-text" href="{{ route('shop') }}">Boutique</a>
                    </li>
                    <li class="breadcrumb-item">Validation de la commande</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="col-md-12 text-center py-5">
            @if(Session::has('success'))
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Succés!</strong> {{ Session::get('success') }}.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            <h1>Merci!</h1>
            <p>Commande ID: {{ $id }}</p>
        </div>
    </section>

@endsection
