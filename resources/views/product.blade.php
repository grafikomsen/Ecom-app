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
                        <a class="active" href="{{ route('shop') }}">Boutique</a>
                    </li>
                    <li class="breadcrumb-item">{{ $product->title }}</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-7 bg-light pt-3 ">
        <div class="container">
            <div class="row ">
                <div class="col-md-5">
                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @if($product->product_images)
                                @foreach($product->product_images as $key => $productImage)
                                <div class="carousel-item {{ ($key == 0) ? 'active' : '' }}">
                                    <img class="w-100 h-100 rounded-1" src="{{ asset('uploads/product/'.$productImage->image) }}" alt="Image">
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="right me-4">
                        <h3 class="fs-2">{{ $product->title }}</h3>
                        <div class="d-flex mb-3">
                            <div class="text-primary mr-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <small class="pt-1">(99 avis)</small>
                        </div>

                        @if ($product->compare_price > 0)
                            <h3 class="price text-secondary"><del>{{ number_format($product->compare_price, 0, '.', ' ') }} CFA</del></h3>
                        @endif
                        <h2 class="price">{{ number_format($product->price, 0, '.', ' ') }} CFA</h2>

                        <p>{!! $product->short_description !!}</p>

                        <div class="d-flex align-items-center">
                            Quantité:
                            <input readonly class="form-control product-qty my-2 mx-2 px-2" value="{{ $product->qty }}"/>
                        </div>

                        @if ($product->track_qty == 'Yes')
                            @if ($product->qty > 0)
                                <a href="javascript:void(0);" onclick="addToCart({{ $product->id }});" class="btn btn-panier rounded-1 border-0 shadow-sm">
                                    <i class="fas fa-shopping-cart text-white"></i> &nbsp;AJOUTER AU PANIER
                                </a>
                            @else
                                <a href="javascript:void(0);" class="btn btn-danger text-white btn-sm rounded-1 w-100">
                                    Épuisé
                                </a>
                            @endif
                        @else
                            <a href="javascript:void(0);" onclick="addToCart({{ $product->id }});" class="btn btn-panier rounded-5 border-0 shadow-sm">
                                <i class="fas fa-shopping-cart text-white"></i> &nbsp;AJOUTER AU PANIER
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <div class="">
                        <ul class="nav nav-tabs rounded-1 mb-0" id="myTab" role="tablist">
                            <li class="nav-item bg-white" role="presentation">
                                <button class="nav-link rounded-1 text-tap active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item bg-white mx-1" role="presentation">
                                <button class="nav-link rounded-1 text-tap" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">Expédition & Retours</button>
                            </li>
                            <li class="nav-item bg-white mx-1" role="presentation">
                                <button class="nav-link rounded-1 text-tap" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Avis</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane rounded-1 fade mt-0 show active p-4 bg-white" id="description" role="tabpanel" aria-labelledby="description-tab">
                                {!! $product->description !!}
                            </div>
                            <div class="tab-pane fade mt-0 p-4 bg-white" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                {!! $product->shipping_returns !!}
                            </div>
                            <div class="tab-pane rounded-1 fade mt-0 p-4 bg-white" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-5 section-8 bg-light py-4">
        <div class="container">
            <div class="section-title">
                <h2>Les produits similaires</h2>
            </div>
            <div class="container">
                <div class="row">
                    @if(!empty($relatedProducts))
                        @foreach ($relatedProducts as $relatedProduct)
                        @php
                            $productImage = $relatedProduct->product_images->first();
                        @endphp
                            <div class="col-12 col-md-3">
                                <div class="card p-2 mb-4 rounded-0 shadow-sm border-0 position-relative">
                                    @if ($relatedProduct->compare_price > 0)
                                        <span class="badge bg-danger position-absolute m-2 rounded-1">PROMO: {{ number_format($relatedProduct->compare_price, 0, '.', ' ') }} CFA</span>
                                    @endif

                                    <a href="javascript:void(0);" onclick="addToWishList({{ $relatedProduct->id }})" class="position-absolute end-0 m-1">
                                        <i class="far fa-heart"></i>
                                    </a>

                                    @if (!empty($productImage->image))
                                        <img  class="w-100 h-100" src="{{ asset('uploads/product/'.$productImage->image) }}" alt="{{ $relatedProduct->title }}">
                                    @else
                                        <img  class="w-100 h-100" src="{{ asset('assets-front/images/c_polo-shirt.png') }}" alt="{{ $relatedProduct->title }}">
                                    @endif

                                    <div class="d-flex justify-content-between">
                                        <a class="nav-link" href="{{ route('product',$relatedProduct->slug) }}">
                                            <h6 class="py-1 text-uppercase text-start">{{ $relatedProduct->title }}</h6>
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
                                        <h6 class="fw-bold">{{ number_format($relatedProduct->price, 0, '.', ' ') }} CFA</h6>
                                        @if ($relatedProduct->track_qty == 'Yes')
                                            @if ($relatedProduct->qty > 0)
                                                <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2" onclick="addToCart({{ $relatedProduct->id }});">
                                                    <i class="fa-solid text-white fa-cart-shopping"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2">
                                                    Indisponible
                                                </a>
                                            @endif
                                        @else
                                            <a href="javascript:void(0);" class="btn btn-default btn-sm rounded-1 p-2" onclick="addToCart({{ $relatedProduct->id }});">
                                                <i class="fa-solid text-white fa-cart-shopping"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection

@section('customJs')
@endsection
