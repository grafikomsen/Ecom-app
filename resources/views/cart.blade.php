@extends('layouts.app')
@section('content')

    <section class="section-5 py-3 pt-4 pb-2 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('home') }}">Acceuil</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('shop') }}">Boutique</a></li>
                    <li class="breadcrumb-item">Panier</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table" id="cart">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix</th>
                                    <th>Quantité</th>
                                    <th>Total</th>
                                    <th>Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($cartContent))
                                    @foreach ($cartContent as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if (!empty($item->options->productImage->image))
                                                        <img width="40px" height="40px" src="{{ asset('uploads/product/'.$item->options->productImage->image) }}" alt="{{ $item->name }}">
                                                    @else
                                                        <img width="40px" height="40px" src="{{ asset('assets-front/images/c_polo-shirt.png') }}" alt="{{ $item->name }}">
                                                    @endif

                                                    <h6 class="px-2">{{ $item->name }}</h6>
                                                </div>
                                            </td>
                                            <td>{{ $item->price }} CFA</td>
                                            <td>
                                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1">
                                                            <i class="fa fa-minus text-white"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm  border-0 text-center" value="{{ $item->qty }}">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1">
                                                            <i class="fa fa-plus text-white"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $item->price*$item->qty }} CFA
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-danger"><i class="fa fa-times text-white"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card cart-summery">
                        <div class="sub-title p-3">
                            <h2 class="bg-white">Panier Résumé</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between pb-2">
                                <div>Sous total</div>
                                <div>{{ Cart::subtotal() }} CFA</div>
                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <div>Expédition</div>
                                <div>400 CFA</div>
                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <div>Total</div>
                                <div>{{ Cart::subtotal() }} CFA</div>
                            </div>
                            <div class="pt-5">
                                <a href="login.php" class="btn-dark btn btn-block w-100">Passer à la caisse</a>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="input-group apply-coupan mt-4">
                        <input type="text" placeholder="Code promo" class="form-control">
                        <button class="btn btn-dark" type="button" id="button-addon2">Appliquer le coupon</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>

@endsection
