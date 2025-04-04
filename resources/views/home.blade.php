@extends('layouts.app')
@section('content')

    <section class="Hero">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            </div>
            <div class="carousel-inner">

                @if($slides->isNotEmpty())
                    @foreach($slides as $slide)
                    <div class="carousel-item active">
                        <img class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="520" src="{{ asset('uploads/banners/'.$slide->image) }}" alt="{{ $slide->name }}">

                        <div class="carousel-caption d-none d-md-block">
                        <h5>{{ $slide->name }}</h5>
                        <p>{{ $slide->content }}</p>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"  data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"  data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section class="Categories py-4">
        <div class="container">
            <div class="title text-center mb-4">
                <h2 class="d-inline-block text-uppercase position-relative">Catégories</h2>
            </div>
            <div class="row">
                @if(getCategories()->isNotEmpty())
                    @foreach (getCategories() as $category)
                        <div class="col-12 col-md-3">
                            <a class="nav-link" href="{{ route('shop',$category->slug) }}">
                                <div class="card cat rounded-1 border-0 bg-light p-2 mb-4 text-center text-bg-white">
                                    @if($category->image != "")
                                        <img src="{{ asset('uploads/categories/'.$category->image) }}" class="card-img object-fit-cover" alt="{{ $category->name }}">
                                    @endif
                                    <div class="cat-title pt-2 rounded-1">
                                        <h5 class="card-title text-white">{{ $category->name }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <section class="Featured py-4 bg-light">
        <div class="container-xl">
            <div class="title text-center mb-2">
                <h2 class="d-inline-block text-uppercase position-relative">Nouvelles Collections</h2>
            </div>
            <div class="bd-example-snippet bd-code-snippet">
                <div class="bd-example">
                <nav class="product-carroussel">
                    <div class="nav nav-tabs mb-3 justify-content-center border-bottom-0" id="nav-tab" role="tablist">
                        <button class="nav-link btn btn-primary rounded-1 border-0 shadow-sm mx-2 my-2 py-2 px-5 text-uppercase active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Tous</button>
                        <button class="nav-link btn btn-primary rounded-1 border-0 shadow-sm mx-2 my-2 py-2 px-5 text-uppercase" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Vendus</button>
                        <button class="nav-link btn btn-primary rounded-1 border-0 shadow-sm mx-2 my-2 py-2 px-5 text-uppercase" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Nouveaux</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            @if($latestProducts->isNotEmpty())
                                @foreach ($latestProducts as $latestProduct)
                                @php
                                    $productImage = $latestProduct->product_images->first();
                                @endphp
                                    <div class="col-12 col-md-3 mb-4">
                                        <a class=" nav-link" href="{{ route('product',$latestProduct->slug) }}">
                                            <div class="card p-2 mb-4 rounded-0 shadow-sm border-0 position-relative">
                                                @if ($latestProduct->compare_price > 0)
                                                    <span class="badge bg-danger position-absolute m-1 rounded-1">PROMO: {{ number_format($latestProduct->compare_price, 0, '.', ' ') }} CFA</span>
                                                @endif

                                                <a href="javascript:void(0);" onclick="addToWishList({{ $latestProduct->id }})" class="position-absolute end-0 m-1">
                                                    <i class="far fa-heart"></i>
                                                </a>

                                                @if (!empty($productImage->image))
                                                    <img  class="w-100 h-100" src="{{ asset('uploads/product/'.$productImage->image) }}" alt="{{ $latestProduct->title }}">
                                                @else
                                                    <img  class="w-100 h-100" src="{{ asset('assets-front/images/c_polo-shirt.png') }}" alt="{{ $latestProduct->title }}">
                                                @endif

                                                <div class="d-flex justify-content-between">
                                                    <a class="nav-link" href="{{ route('product',$latestProduct->slug) }}">
                                                        <h6 class="py-1 text-uppercase text-start">{{ $latestProduct->title }}</h6>
                                                    </a>
                                                    <h6 class="py-1 text-uppercase text-start"></h6>
                                                </div>

                                                <div class="py-1 rating d-flex justify-content-start">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h6 class="fw-bold">{{ number_format($latestProduct->price, 0, '.', ' ') }} CFA</h6>
                                                    @if ($latestProduct->track_qty == 'Yes')
                                                        @if ($latestProduct->qty > 0)
                                                            <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2" onclick="addToCart({{ $latestProduct->id }});">
                                                                <i class="fa-solid text-white fa-cart-shopping"></i>
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2">
                                                                Indisponible
                                                            </a>
                                                        @endif
                                                    @else
                                                        <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2" onclick="addToCart({{ $latestProduct->id }});">
                                                            <i class="fa-solid text-white fa-cart-shopping"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="row">
                            @if($featuredProducts->isNotEmpty())
                                @foreach ($featuredProducts as $featuredProduct)
                                @php
                                    $productImage = $featuredProduct->product_images->first();
                                @endphp
                                <div class="col-12 col-md-3 mb-4">
                                    <a class=" nav-link" href="{{ route('product',$featuredProduct->slug) }}">
                                        <div class="card p-2 mb-4 rounded-0 shadow-sm border-0 position-relative">
                                            @if ($featuredProduct->compare_price > 0)
                                                <span class="badge bg-danger position-absolute m-1 rounded-1">PROMO: {{ number_format($featuredProduct->compare_price, 0, '.', ' ') }} CFA</span>
                                            @endif

                                            <a href="javascript:void(0);" onclick="addToWishList({{ $featuredProduct->id }})" class="position-absolute end-0 m-1">
                                                <i class="far fa-heart"></i>
                                            </a>

                                            @if (!empty($productImage->image))
                                                <img  class="w-100 h-100" src="{{ asset('uploads/product/'.$productImage->image) }}" alt="{{ $featuredProduct->title }}">
                                            @else
                                                <img  class="w-100 h-100" src="{{ asset('assets-front/images/c_polo-shirt.png') }}" alt="{{ $featuredProduct->title }}">
                                            @endif

                                            <div class="d-flex justify-content-between">
                                                <a class="nav-link" href="{{ route('product',$featuredProduct->slug) }}">
                                                    <h6 class="py-1 text-uppercase text-start">{{ $featuredProduct->title }}</h6>
                                                </a>
                                                <h6 class="py-1 text-uppercase text-start"></h6>
                                            </div>

                                            <div class="py-1 rating d-flex justify-content-start">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="fw-bold">{{ number_format($featuredProduct->price, 0, '.', ' ') }} CFA</h6>
                                                @if ($featuredProduct->track_qty == 'Yes')
                                                    @if ($featuredProduct->qty > 0)
                                                        <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2" onclick="addToCart({{ $featuredProduct->id }});">
                                                            <i class="fa-solid text-white fa-cart-shopping"></i>
                                                        </a>
                                                    @else
                                                        <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2">
                                                            Indisponible
                                                        </a>
                                                    @endif
                                                @else
                                                    <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2" onclick="addToCart({{ $featuredProduct->id }});">
                                                        <i class="fa-solid text-white fa-cart-shopping"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="row">
                            @if($olderProducts->isNotEmpty())
                                @foreach ($olderProducts as $olderProduct)
                                @php
                                    $productImage = $olderProduct->product_images->first();
                                @endphp
                                <div class="col-12 col-md-3 mb-4">
                                    <a class=" nav-link" href="{{ route('product',$olderProduct->slug) }}">
                                        <div class="card p-2 mb-4 rounded-0 shadow-sm border-0 position-relative">
                                            @if ($olderProduct->compare_price > 0)
                                                <span class="badge bg-danger position-absolute m-1 rounded-1">PROMO: {{ number_format($olderProduct->compare_price, 0, '.', ' ') }} CFA</span>
                                            @endif

                                            <a href="javascript:void(0);" onclick="addToWishList({{ $olderProduct->id }})" class="position-absolute end-0 m-1">
                                                <i class="far fa-heart"></i>
                                            </a>

                                            @if (!empty($productImage->image))
                                                <img  class="w-100 h-100" src="{{ asset('uploads/product/'.$productImage->image) }}" alt="{{ $olderProduct->title }}">
                                            @else
                                                <img  class="w-100 h-100" src="{{ asset('assets-front/images/c_polo-shirt.png') }}" alt="{{ $olderProduct->title }}">
                                            @endif

                                            <div class="d-flex justify-content-between">
                                                <a class="nav-link" href="{{ route('product',$olderProduct->slug) }}">
                                                    <h6 class="py-1 text-uppercase text-start">{{ $olderProduct->title }}</h6>
                                                </a>
                                                <h6 class="py-1 text-uppercase text-start"></h6>
                                            </div>

                                            <div class="py-1 rating d-flex justify-content-start">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="fw-bold">{{ number_format($olderProduct->price, 0, '.', ' ') }} CFA</h6>
                                                @if ($olderProduct->track_qty == 'Yes')
                                                    @if ($olderProduct->qty > 0)
                                                        <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2" onclick="addToCart({{ $olderProduct->id }});">
                                                            <i class="fa-solid text-white fa-cart-shopping"></i>
                                                        </a>
                                                    @else
                                                        <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2">
                                                            Indisponible
                                                        </a>
                                                    @endif
                                                @else
                                                    <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2" onclick="addToCart({{ $olderProduct->id }});">
                                                        <i class="fa-solid text-white fa-cart-shopping"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>

    {{--<section class="Specials py-5 bg-light">
        <div class="container-xl">
            <div class="title text-center mb-2">
                <h2 class="d-inline-block text-uppercase position-relative">Spécial collections</h2>
            </div>
            <div class="row">
                <div class="col-12 col-md-3">
                    <a class=" nav-link" href="">
                        <div class="card p-2 shadow-sm rounded-0 border-0 h-100 position-relative">
                            <span class="badge bg-danger position-absolute m-2 rounded-5">Faible stock</span>
                            <img src="{{ asset('assets-front/images/special_product_1.jpg') }}" alt="">
                            <h6 class="pt-2 text-center text-uppercase">gray shirt</h6>
                            <h6 class="text-center fw-bold">12.000 CFA</h6>
                            <div class="rating d-flex justify-content-center">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-3">
                    <a class=" nav-link" href="">
                        <div class="card p-2 shadow-sm rounded-0 border-0 h-100 position-relative">
                            <span class="badge bg-primary position-absolute m-2 rounded-5">Nouveau</span>
                            <img src="{{ asset('assets-front/images/special_product_2.jpg') }}" alt="">
                            <h6 class="pt-2 text-center text-uppercase">gray shirt</h6>
                            <h6 class="text-center fw-bold">12.000 CFA</h6>
                            <div class="rating d-flex justify-content-center">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-3">
                    <a class=" nav-link" href="">
                        <div class="card p-2 shadow-sm rounded-0 border-0 h-100 position-relative">
                            <span class="badge bg-primary position-absolute m-2 rounded-5">Vente</span>
                            <img src="{{ asset('assets-front/images/special_product_3.jpg') }}" alt="">
                            <h6 class="pt-2 text-center text-uppercase">gray shirt</h6>
                            <h6 class="text-center fw-bold">12.000 CFA</h6>
                            <div class="rating d-flex justify-content-center">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-3">
                    <a class=" nav-link" href="">
                        <div class="card p-2 shadow-sm rounded-0 border-0 h-100 position-relative">
                            <span class="badge bg-danger position-absolute m-2 rounded-5">Faible stock</span>
                            <img src="{{ asset('assets-front/images/special_product_1.jpg') }}" alt="">
                            <h6 class="pt-2 text-center text-uppercase">gray shirt</h6>
                            <h6 class="text-center fw-bold">12.000 CFA</h6>
                            <div class="rating d-flex justify-content-center">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="Banner-offer py-5 bg-light">
        <div class="carousel slide" data-bs-ride="carousel">
            <div class="container carousel-inner pt-5">
                <div class="text-center carousel-item active">
                    <h2 class="text-capitalize text-white">best collection</h2>
                    <h1 class="text-capitalize text-white">New arrivals</h1>
                    <a class="btn btn-primary rounded-1 border-0 shadow-sm py-2 px-5 text-uppercase" href="">shop now <i class="fas fa-shopping-cart"></i></a>
                </div>
                <div class="text-center carousel-item">
                    <h2 class="text-capitalize text-white">collection</h2>
                    <h1 class="text-capitalize text-white">New arrivals</h1>
                    <a class="btn btn-primary rounded-1 border-0 shadow-sm py-2 px-5 text-uppercase" href="">buy now <i class="fas fa-shopping-cart"></i></a>
                </div>
            </div>
        </div>
    </section>

    <section class="Populaires py-5 bg-light">
        <div class="container-xl">
            <div class="title text-center mb-4">
                <h2 class="d-inline-block text-uppercase position-relative">Produits populaires</h2>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <h3 class="d-inline-block text-uppercase fw-normal position-relative">Produits populaires</h3>
                    @if($oldProducts->isNotEmpty())
                        @foreach ($oldProducts as $oldProduct)
                        @php
                            $productImage = $oldProduct->product_images->first();
                        @endphp
                            <a class="nav-link" href="{{ route('product',$oldProduct->slug) }}">
                                <div class="card rounded-1 shadow-sm border-0 mb-4">
                                    <div class="row g-0">
                                        <div class="col-12 col-md-4">

                                            @if ($oldProduct->track_qty == 'Yes')
                                                @if ($oldProduct->qty > 0)
                                                    <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2 position-absolute bottom-0 end-0 m-2 shadow-sm" onclick="addToCart({{ $oldProduct->id }});">
                                                        <i class="fa-solid text-white fa-cart-shopping"></i>
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2 position-absolute bottom-0 end-0 m-2 shadow-sm">
                                                        Indisponible
                                                    </a>
                                                @endif
                                            @else
                                                <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2 position-absolute bottom-0 end-0 m-2 shadow-sm" onclick="addToCart({{ $oldProduct->id }});">
                                                    <i class="fa-solid text-white fa-cart-shopping"></i>
                                                </a>
                                            @endif

                                            @if (!empty($productImage->image))
                                                <img width="130" height="140" src="{{ asset('uploads/product/'.$productImage->image) }}" alt="{{ $oldProduct->title }}">
                                            @else
                                                <img width="130" height="140" src="{{ asset('assets-front/images/special_product_1.jpg') }}" alt="{{ $oldProduct->title }}">
                                            @endif
                                        </div>
                                        <div class="col-12 col-md-8 ps-2">
                                            <a href="javascript:void(0);" onclick="addToWishList({{ $oldProduct->id }})" class="position-absolute end-0 m-2">
                                                <i class="far fa-heart"></i>
                                            </a>
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $oldProduct->title }}</h6>
                                                <p class="card-text">{{ number_format($oldProduct->price, 0, '.', ' ') }} CFA</p>
                                                <div class="rating d-flex justify-content-star">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
                <div class="col-12 col-md-4">
                    <h3 class="d-inline-block text-uppercase fw-normal position-relative">Produits vendu</h3>
                    @if($latProducts->isNotEmpty())
                        @foreach ($latProducts as $latProduct)
                        @php
                            $productImage = $latProduct->product_images->first();
                        @endphp
                            <a class="nav-link" href="{{ route('product',$latProduct->slug) }}">
                                <div class="card rounded-1 shadow-sm border-0 mb-4">
                                    <div class="row g-0">
                                        <div class="col-12 col-md-4">

                                            @if ($latProduct->track_qty == 'Yes')
                                                @if ($latProduct->qty > 0)
                                                    <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2 position-absolute bottom-0 end-0 m-2 shadow-sm" onclick="addToCart({{ $latProduct->id }});">
                                                        <i class="fa-solid text-white fa-cart-shopping"></i>
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2 position-absolute bottom-0 end-0 m-2 shadow-sm">
                                                        Indisponible
                                                    </a>
                                                @endif
                                            @else
                                                <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2 position-absolute bottom-0 end-0 m-2 shadow-sm" onclick="addToCart({{ $latProduct->id }});">
                                                    <i class="fa-solid text-white fa-cart-shopping"></i>
                                                </a>
                                            @endif

                                            @if (!empty($productImage->image))
                                                <img width="130" height="140" src="{{ asset('uploads/product/'.$productImage->image) }}" alt="{{ $latProduct->title }}">
                                            @else
                                                <img width="130" height="140" src="{{ asset('assets-front/images/special_product_1.jpg') }}" alt="{{ $latProduct->title }}">
                                            @endif
                                        </div>
                                        <div class="col-12 col-md-8 ps-2">
                                            <a href="javascript:void(0);" onclick="addToWishList({{ $latProduct->id }})" class="position-absolute end-0 m-2">
                                                <i class="far fa-heart"></i>
                                            </a>
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $latProduct->title }}</h6>
                                                <p class="card-text">{{ number_format($latProduct->price, 0, '.', ' ') }} CFA</p>
                                                <div class="rating d-flex justify-content-star pt-0">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
                <div class="col-12 col-md-4">
                    <h3 class="d-inline-block text-uppercase fw-normal position-relative">Produits favoris</h3>
                    @if($feaProducts->isNotEmpty())
                        @foreach ($feaProducts as $feaProduct)
                        @php
                            $productImage = $feaProduct->product_images->first();
                        @endphp
                            <a class="nav-link" href="{{ route('product',$feaProduct->slug) }}">
                                <div class="card rounded-1 shadow-sm border-0 mb-4">
                                    <div class="row g-0">
                                        <div class="col-12 col-md-4">

                                            @if ($feaProduct->track_qty == 'Yes')
                                                @if ($feaProduct->qty > 0)
                                                    <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2 position-absolute bottom-0 end-0 m-2 shadow-sm" onclick="addToCart({{ $feaProduct->id }});">
                                                        <i class="fa-solid text-white fa-cart-shopping"></i>
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2 position-absolute bottom-0 end-0 m-2 shadow-sm">
                                                        Indisponible
                                                    </a>
                                                @endif
                                            @else
                                                <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2 position-absolute bottom-0 end-0 m-2 shadow-sm" onclick="addToCart({{ $feaProduct->id }});">
                                                    <i class="fa-solid text-white fa-cart-shopping"></i>
                                                </a>
                                            @endif

                                            @if (!empty($productImage->image))
                                                <img width="130" height="140" src="{{ asset('uploads/product/'.$productImage->image) }}" alt="{{ $feaProduct->title }}">
                                            @else
                                                <img width="130" height="140" src="{{ asset('assets-front/images/special_product_1.jpg') }}" alt="{{ $feaProduct->title }}">
                                            @endif
                                        </div>
                                        <div class="col-12 col-md-8 ps-2">
                                            <a href="javascript:void(0);" onclick="addToWishList({{ $feaProduct->id }})" class="position-absolute end-0 m-2">
                                                <i class="far fa-heart"></i>
                                            </a>
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $feaProduct->title }}</h6>
                                                <p class="card-text">{{ number_format($feaProduct->price, 0, '.', ' ') }} CFA</p>
                                                <div class="rating d-flex justify-content-star pt-0">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="Newsletter py-5">
        <div class="container-xl">
            <div class="title text-center">
                <h2 class="d-inline-block text-uppercase position-relative">Newsletter Subscription</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-6">
                    <p class=" text-center">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Perspiciatis eligendi quae laudantium quasi amet omnis!</p>
                    <form action="" method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <button class="input-group-text border-0" id="basic-addon2">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
