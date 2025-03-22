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
                        <a class="breadcrumb-text" href="{{ route('account.profile') }}">Mon compte</a>
                    </li>
                    <li class="breadcrumb-item">Mes commandes</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-11 bg-light py-5">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('account.sidebar')
                </div>
                <div class="col-md-9">
                    <div class="card rounded-1">
                        <div class="card-header rounded-0 bg-primary">
                            <h2 class="h5 mb-0 pt-2 text-white pb-2">Mes commandes</h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Commandes #</th>
                                            <th>Date d'achat</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($orders->isNotEmpty())
                                            @foreach($orders as $order)
                                               <tr>
                                                    <td>
                                                        <a href="{{ route('account.ordersId',$order->id) }}">Commande n°{{ $order->id }}</a>
                                                    </td>
                                                    <td>{{ $order->created_at }}</td>
                                                    <td>
                                                        @if ($order->status == 'pending')
                                                            <span class="badge bg-warning rounded-1">En attente</span>
                                                        @elseif($order->status == 'shipped')
                                                            <span class="badge bg-info rounded-1">Expédié</span>
                                                        @elseif($order->status == 'cancelled')
                                                            <span class="badge bg-danger rounded-1">Annulé</span>
                                                        @else
                                                            <span class="badge bg-success rounded-1">Livré</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ number_format($order->grand_total,0,',',' ') }} CFA</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="text-center" colspan="3">Commande introuvable</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
