@extends('layouts.app')
@section('content')
<main>
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
                    <li class="breadcrumb-item">Panier</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 py-4 bg-light">
        <div class="container">
            <div class="row">
                @if (Cart::count() > 0)
                   <div class="col-md-8">
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

                        <div class="table-responsive shadow-sm rounded-1">
                            <table class="table" id="cart">
                                <thead>
                                    <tr>
                                        <th class="text-start">Produit</th>
                                        <th class="text-center">Prix</th>
                                        <th class="text-center">Quantité</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-end">Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($cartContent))
                                        @foreach ($cartContent as $item)
                                            <tr>
                                                <td class="text-start">
                                                    <div class="d-flex align-items-center">
                                                        @if (!empty($item->options->productImage->image))
                                                            <img width="40px" height="40px" src="{{ asset('uploads/product/'.$item->options->productImage->image) }}" alt="{{ $item->name }}">
                                                        @else
                                                            <img width="40px" height="40px" src="{{ asset('assets-front/images/c_polo-shirt.png') }}" alt="{{ $item->name }}">
                                                        @endif

                                                        <h6 class="px-2">{{ $item->name }}</h6>
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ $item->price }} CFA</td>
                                                <td class="text-center">
                                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-sm btn-default btn-minus p-2 pt-1 pb-1 sub" data-id="{{ $item->rowId }}">
                                                                <i class="fa fa-minus text-white"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm  border-0 text-center" value="{{ $item->qty }}">
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-sm btn-default btn-plus p-2 pt-1 pb-1 add" data-id="{{ $item->rowId }}">
                                                                <i class="fa fa-plus text-white"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->price*$item->qty }} CFA
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-danger float-end" onclick="deleteItem('{{ $item->rowId }}')">
                                                        <i class="fa fa-times text-white"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm cart-summery">
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
                                    <a href="{{ route('checkout') }}" class="btn-default btn btn-block w-100">Passer à la caisse</a>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="input-group apply-coupan mt-4">
                            <input type="text" placeholder="Code promo" class="form-control">
                            <button class="btn btn-dark" type="button" id="button-addon2">Appliquer le coupon</button>
                        </div> --}}
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body d-flex align-content-center justify-content-center">
                                <h4>Le panier est vide!</h4>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</main>
@endsection
@section('customJs')

    <script>

        $('.add').click(function(){
            let qtyElement = $(this).parent().prev(); // Qty Input
            let qtyValue = parseInt(qtyElement.val());
            if (qtyValue < 10) {
                let rowId = $(this).data('id');
                qtyElement.val(qtyValue+1);
                let newQty = qtyElement.val();
                updateCart(rowId,newQty);
            }
        });

        $('.sub').click(function(){
            let qtyElement = $(this).parent().next();
            let qtyValue = parseInt(qtyElement.val());
            if (qtyValue > 1) {
                let rowId = $(this).data('id');
                qtyElement.val(qtyValue-1);
                let newQty = qtyElement.val();
                updateCart(rowId,newQty);
            }
        });

        function updateCart(rowId, qty){
            $.ajax({
                url: '{{ route("cart.updateCart") }}',
                type: 'POST',
                data: {rowId:rowId, qty},
                dataType: 'json',
                success: function(response){
                    window.location.href = "{{ route('cart') }}";
                }
            });
        }

        function deleteItem(rowId){
            if(confirm('Êtes-vous sûr de vouloir supprimer?')){
                $.ajax({
                    url: '{{ route("cart.deleteItem") }}',
                    type: 'POST',
                    data: {rowId:rowId},
                    dataType: 'json',
                    success: function(response){
                        window.location.href = "{{ route('cart') }}";
                    }
                });
            }
        }

    </script>

@endsection
