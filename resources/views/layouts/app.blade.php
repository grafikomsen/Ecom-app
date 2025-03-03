<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Document</title>
        <link rel="stylesheet" href="{{ asset('assets-front/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets-front/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets-front/css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('assets-front/css/ion.rangeSlider.min.css') }}">
    </head>

    <body>
        <header class="header shadow-sm sticky-top">
            <div class="top-nav">
                <div class="container d-flex flex-wrap">
                    <ul class="nav me-auto">
                        <li class="nav-item"><a href="#" class="nav-link text-white px-2">Features</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white px-2">Pricing</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white px-2">FAQs</a></li>
                        <li class="nav-item"><a href="#" class="nav-link text-white px-2">About</a></li>
                    </ul>
                    <ul class="nav">
                        <li class="nav-item dropdown p-0">
                            <a class="nav-link text-white dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                LANGUE
                            </a>
                            <ul class="dropdown-menu rounded-1">
                              <li><a class="dropdown-item text-uppercase" href="#">Français</a></li>
                              <li><a class="dropdown-item text-uppercase" href="#">Anglais</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown p-0">
                            <a class="nav-link text-white dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                USD
                            </a>
                            <ul class="dropdown-menu rounded-1">
                              <li><a class="dropdown-item text-uppercase" href="#">CFA</a></li>
                              <li><a class="dropdown-item text-uppercase" href="#">EURO</a></li>
                              <li><a class="dropdown-item text-uppercase" href="#">DOLLAR</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link text-white">Se connecter</a></li>
                    </ul>
                </div>
            </div>
            <nav class="navbar navbar-expand-lg bg-light">
                <div class="container d-flex flex-wrap justify-content-center">
                    <a class="navbar-brand d-flex justify-content-between align-items-center order-lg-0" href="{{ route('home') }}">
                        <img class="logo" src="{{ asset('assets-front/images/shopping-bag-icon.png') }}" alt="">
                        <span class="text-uppercase ms-2">ATTIRE</span>
                    </a>

                    <div class="order-lg-2 d-flex align-items-center">
                        {{-- <form class="" role="search">
                            <input type="search" class="form-control rounded-5 shadow-sm" placeholder="Chercher ici...">
                        </form> --}}
                        <a href="" class="position-relative px-2">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="position-absolute shadow-sm top-0 start-50 translate-middle badge rounded-circle bg-primary">2</span>
                        </a>
                    </div>

                    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon text-dark"></span>
                    </button>

                    <div class="collapse navbar-collapse  order-lg-1" id="navbarSupportedContent">
                        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link fw-semibold text-uppercase text-center active" aria-current="page" href="{{ route('home') }}">Accueil</a>
                            </li>
                            @if(getCategories()->isNotEmpty())
                                @foreach (getCategories() as $category)
                                    <li class="nav-item dropdown text-uppercase text-center">
                                        <a class="nav-link fw-semibold dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ $category->name }}
                                        </a>
                                        @if($category->sub_categories->isNotEmpty())
                                            <ul class="dropdown-menu rounded-1">
                                                @foreach ($category->sub_categories as $subCategory)
                                                    <li><a class="dropdown-item" href="{{ route('shop',[$category->slug,$subCategory->slug]) }}">{{ $subCategory->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                            {{-- <li class="nav-item">
                                <a class="nav-link fw-semibold text-uppercase text-center" aria-current="page" href="#">blogs</a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link fw-semibold text-uppercase text-center" aria-current="page" href="#">contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="footer py-5">
            <div class="container">
                <div class="row py-2">
                    <div class="col-6 col-md-2 mb-3">
                        <h5 class="text-white fw-bolder">HOMMES</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Home</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Features</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Pricing</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">FAQs</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">About</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-md-2 mb-3">
                        <h5 class="text-white fw-bolder">FEMMES</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Home</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Features</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">Pricing</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">FAQs</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-white">About</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-md-2 mb-3">
                        <h5 class="text-white fw-bolder">ENFANTS</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="#" class="nav-link text-white p-0">Home</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link text-white p-0">Features</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link text-white p-0">Pricing</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link text-white p-0">FAQs</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link text-white p-0">About</a></li>
                        </ul>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h5 class="text-white text-uppercase fw-bolder mb-3">Contactez - nous</h5>
                        <div class="d-flex justify-content-start align-items-start my-2">
                            <span class="me-3">
                                <i class="fas fa-map-marked-alt text-white"></i>
                            </span>
                            <span class="fw-light text-white">
                                Albert Street, New York, AS 756, United States of America
                            </span>
                        </div>
                        <div class="d-flex justify-content-start align-items-start my-2">
                            <span class="me-3">
                                <i class="fas fa-envelope text-white"></i>
                            </span>
                            <span class="fw-light text-white">
                                attire.support@gmail.com
                            </span>
                        </div>
                        <div class="d-flex justify-content-start align-items-start my-2">
                            <span class="me-3">
                                <i class="fas fa-phone text-white"></i>
                            </span>
                            <span class="fw-light text-white">
                                +9786 6776 236
                            </span>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column flex-sm-row justify-content-between pt-3 border-top">
                    <p class="text-white">&copy; 2022 Company, Inc. All rights reserved.</p>
                    <ul class="list-unstyled d-flex">
                        <li class="ms-3"><a class="nav-link" href="#"><i class="fas fa-twitter text-white"></i></a></li>
                        <li class="ms-3"><a class="nav-link" href="#"><i class="fas fa-instagram-square text-white"></i></a></li>
                        <li class="ms-3"><a class="nav-link" href="#"><i class="fas fa-facebook text-white"></i></svg></a></li>
                    </ul>
                </div>
                </footer>
            </div>
        </footer>
        <script src="{{ asset('assets-front/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets-front/bootstrap/js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('assets-front/js/main.js') }}"></script>
        <script src="{{ asset('assets-front/js/ion.rangeSlider.min.js') }}"></script>
        @yield('customJs')
    </body>
</html>
