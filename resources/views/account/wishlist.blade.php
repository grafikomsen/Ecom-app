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
                        <li class="breadcrumb-item">Souhaits</li>
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
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0 pt-2 pb-2">Mes souhaits</h2>
                            </div>
                            <div class="card-body p-4">
                                @if($wishlists->isNotEmpty())
                                    @foreach ($wishlists as $wishlist)
                                        <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                                            <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                                                <a class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{ route('product',$wishlist->product->slug) }}" style="width: 10rem;">
                                                    @php
                                                        $productImage = getProductImage($wishlist->product_id);
                                                    @endphp

                                                    @if(!empty($productImage->image))
                                                        <img width="80" height="80" src="{{ asset('uploads/product/'.$productImage->image) }}" alt="{{ $wishlist->product->title }}">
                                                    @endif
                                                </a>
                                                <div class="pt-2">
                                                    <h3 class="product-title fs-base mb-2">{{ $wishlist->product->title }}</h3>
                                                    <div class="fs-lg text-accent pt-2">{{ number_format($wishlist->product->price,0,',',' ') }} CFA</div>
                                                </div>
                                            </div>
                                            <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                                <button onclick="removeProduct({{ $wishlist->product->id }})" class="btn btn-default btn-sm" type="button">
                                                    <i class="fas fa-trash-alt text-white me-2"></i> supprimer
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center">
                                        <h3 class="text-center">Aucun produit disponible</h3>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('customJs')
    <script>

        function removeProduct(id){
            if(confirm('Êtes-vous sûr de vouloir supprimer?')){
                $.ajax({
                    url: '{{ route("account.removeProductFromWishlist") }}',
                    type: 'POST',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == true){
                            window.location.href="{{ route('account.wishlist') }}";
                        }
                    }
                });
            }
        }

    </script>
@endsection
