@extends('layouts.app')
@section('content')
    <section class="section-5 py-2 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a class="text-black" href="{{ route('home') }}">Accueil</a>
                    </li>
                    <li class="breadcrumb-item active">Boutique</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Catégories</h3>
                    </div>

                    <div class="card shadow-sm border-0 rounded-0">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                                @if ($categories->isNotEmpty())
                                    @foreach ($categories as $key => $categorie)
                                        <div class="accordion-item">
                                            @if ($categorie->sub_categories->isNotEmpty())
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{ $key }}" aria-expanded="false" aria-controls="collapseOne-{{ $key }}">
                                                        {{ $categorie->name }}
                                                    </button>
                                                </h2>
                                            @else
                                                <a href="{{ route('shop', $categorie->slug) }}" class="nav-item nav-link  {{ ($categorieSelected == $categorie->id) ? 'active' : '' }}">{{ $categorie->name }}</a>
                                            @endif

                                            @if ($categorie->sub_categories->isNotEmpty())
                                            <div id="collapseOne-{{ $key }}" class="accordion-collapse collapse {{ ($categorieSelected == $categorie->id) ? 'show' : '' }}" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="navbar-nav">
                                                            @foreach ($categorie->sub_categories as $SubCategorie)
                                                                <a href="{{ route('shop', [$categorie->slug,$SubCategorie->slug]) }}" class="nav-item nav-link {{ ($subCategorieSelected == $SubCategorie->id) ? 'active' : '' }}">{{ $SubCategorie->name }}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Brand</h3>
                    </div>

                    <div class="card shadow-sm border-0 rounded-0">
                        <div class="card-body">
                            @if ($brands->isNotEmpty())
                                @foreach ($brands as $brand)
                                    <div class="form-check mb-2">
                                        <input {{ (in_array($brand->id, $brandsArray)) ? 'checked' : '' }} class="form-check-input brand-label" type="checkbox" name="brand[]" value="{{ $brand->id }}"  id="brand-{{ $brand->id }}">
                                        <label class="form-check-label" for="brand-{{ $brand->id }}">
                                            {{ $brand->name }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Price</h3>
                    </div>

                    <div class="card shadow-sm border-0 rounded-0">
                        <div class="card-body">
                            <input type="text" class="js-range-slider" name="my_range" value=""/>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light bg-white border-0 rounded-0 dropdown-toggle" data-bs-toggle="dropdown">Sorting</button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Latest</a>
                                            <a class="dropdown-item" href="#">Price High</a>
                                            <a class="dropdown-item" href="#">Price Low</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            @if($products->isNotEmpty())
                                @foreach ($products as $product)
                                @php
                                    $productImage = $product->product_images->first();
                                @endphp
                                    <div class="col-12 col-md-4">
                                        <a class="nav-link" href="">
                                            <div class="card p-2 mb-4 rounded-0 shadow-sm border-0 position-relative">
                                                @if ($product->compare_price > 0)
                                                    <span class="badge bg-danger position-absolute m-2 rounded-4">PROMO: {{ $product->compare_price }} CFA</span>
                                                @endif


                                                @if (!empty($productImage->image))
                                                    <img src="{{ asset('uploads/product/'.$productImage->image) }}" alt="{{ $product->title }}">
                                                @else
                                                    <img src="" alt="{{ $product->title }}">
                                                @endif
                                                <div class="d-flex justify-content-between">
                                                    <h6 class="py-1 text-uppercase text-start">{{ $product->title }}</h6>
                                                    <h6 class="py-1 text-uppercase text-start">{{ $product->category_id }}</h6>
                                                </div>

                                                <div class="py-1 rating d-flex justify-content-start">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h6 class="fw-bold">{{ $product->price }} CFA</h6>
                                                    <i class="fa-solid fa-cart-shopping"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('customJs')
    <script>

        rangeSlider = $('.js-range-slider').ionRangeSlider({
            type: "double",
            min: 0,
            max: 1000000,
            from: {{ $priceMin }},
            step: 10,
            to: {{ $priceMax }},
            skin: "round",
            max_postfix: '+',
            prefix: 'CFA',
            onFinish: function(){
                applyFilters()
            }
        });

        let slider = $(".js-range-slider").data('ionRangeSlider');

        $('.brand-label').change(function(){
            apply_filters();
        });

        function apply_filters(){
            let brands = [];

            $('.brand-label').each(function(){
                if($(this).is(":checked") == true) {
                    brands.push($(this).val());
                }
            });
            console.log(brands.toString());
            let url = '{{ url()->current() }}?';
            url += '&price_min='+slider.result.from+'&price_max='+slider.result.to;
            window.location.href = url+'&brand='+brands.toString();
        }

    </script>
@endsection
