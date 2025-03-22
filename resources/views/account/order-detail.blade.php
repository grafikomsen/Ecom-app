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
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-text" href="{{ route('account.orders') }}">Mes commandes</a>
                    </li>
                    <li class="breadcrumb-item">Détails de la commande</li>
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
                    <div class="card shadow-sm rounded-1">
                        <div class="card-header rounded-1 shadow-sm bg-primary">
                            <h2 class="h5 mb-0 pt-2 text-white pb-2">Détails de la commande</h2>
                        </div>

                        <div class="card-body rounded-1 shadow-sm rounded-1 pb-4">
                            <!-- Info -->
                            <div class="card rounded-0 card-sm">
                                <div class="card-body p-3 bg-light mb-3">
                                    <div class="row">
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Commande No:</h6>
                                            <!-- Text -->
                                            <p class="mb-lg-0 fs-sm fw-bold">
                                                COM#{{ $order->id }}
                                            </p>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Date d'expédition:</h6>
                                            <!-- Text -->
                                            <p class="mb-lg-0 fs-sm fw-bold">
                                                <time>
                                                    @if (!empty($order->shipped_date))
                                                        {{ $order->shipped_date }}
                                                    @else
                                                        n/a
                                                    @endif
                                                </time>
                                            </p>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Status:</h6>
                                            <!-- Text -->
                                            <p class="mb-0 fs-sm fw-bold">
                                                @if ($order->status == 'pending')
                                                    <span class="badge bg-warning rounded-1">En attente</span>
                                                @elseif($order->status == 'shipped')
                                                    <span class="badge bg-info rounded-1">Expédié</span>
                                                @elseif($order->status == 'cancelled')
                                                    <span class="badge bg-danger rounded-1">Annulé</span>
                                                @else
                                                    <span class="badge bg-success rounded-1">Livré</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Montant de la commande:</h6>
                                            <!-- Text -->
                                            <p class="mb-0 fs-sm fw-bold">
                                                {{ number_format($order->grand_total,0,',',' ') }} CFA
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer shadow-sm rounded-1 p-3">

                            <!-- Heading -->
                            <h6 class="mb-7 h5 mt-4">Articles de commande ({{ $orderItemsCount }})</h6>

                            <!-- Divider -->
                            <hr class="my-3">

                            <!-- List group -->
                            <ul>
                                @if($orderItems->isNotEmpty())
                                    @foreach($orderItems as $orderItem)
                                        <li class="list-group-item border-bottom mt-2">
                                            <div class="row align-items-center">
                                                <div class="col-4 col-md-3 col-xl-2">
                                                    <!-- Image -->
                                                    @php
                                                        $productImage = getProductImage($orderItem->product_id);
                                                    @endphp

                                                    @if(!empty($productImage->image))
                                                        <img src="{{ asset('uploads/product/'.$productImage->image) }}" alt="{{ $orderItem->name }}" class="img-fluid">
                                                    @endif
                                                </div>
                                                <div class="col">
                                                    <!-- Title -->
                                                    <p class="mb-4 fs-sm fw-bold">
                                                        <a class="text-body" href="product.html">{{ $orderItem->name }} x {{ $orderItem->qty }}</a> <br>
                                                        <span class="text-muted">{{ number_format($orderItem->total,0,',',' ') }} CFA</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="card card-lg rounded-1 shadow-sm mb-5 mt-3">
                        <div class="card-body p-3">
                            <!-- Heading -->
                            <h6 class="mt-0 mb-3 h5">Total de la commande</h6>

                            <!-- List group -->
                            <ul>
                                <li class="list-group-item border-bottom mt-3 d-flex">
                                    <span>Sous total</span>
                                    <span class="ms-auto">{{ number_format($order->subtotal,0,',',' ') }} CFA</span>
                                </li>
                                <li class="list-group-item border-bottom mt-3 d-flex">
                                    <span>Code coupon {{ (!empty($order->coupon_code)) ? '('.$order->coupon_code.')' : '' }}</span>
                                    <span class="ms-auto">{{ number_format($order->discount,0,',',' ') }} CFA</span>
                                </li>
                                <li class="list-group-item border-bottom mt-3 d-flex">
                                    <span>Expédition</span>
                                    <span class="ms-auto">{{ number_format($order->shipping,0,',',' ') }} CFA</span>
                                </li>
                                <li class="list-group-item border-bottom mt-3 d-flex fs-lg fw-bold pt-2">
                                    <span>Total</span>
                                    <span class="ms-auto">{{ number_format($order->grand_total,0,',',' ') }} CFA</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
