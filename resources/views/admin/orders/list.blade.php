@extends('admin.layouts.app')
@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Commandes</h1>
                </div>
                <div class="col-sm-6 text-right">
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('admin.messages')
            <div class="card">
                <form action="" method="GET">
                    <div class="card-header">
                        <div class="card-title float-end">
                            <a class="btn btn-primary btn-sm border-0 rounded-1" href="{{ route('admin.order') }}">Actualisé la page</a>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" value="{{ Request::get('keyword') }}" name="keyword" class="form-control float-right" placeholder="Cherchez ici...">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary border-0 rounded-1">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Orders #</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date Purchased</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($orders->isNotEmpty())
                                @foreach ($orders as $order)
                                    <tr>
                                        <td><a href="{{ route('admin.order.detail',[$order->id]) }}">COM#{{ $order->id }}</a></td>
                                        <td>{{ $order->name }}</td>
                                        <td>{{ $order->email }}</td>
                                        <td>{{ $order->mobile }}</td>
                                        <td>
                                            @if ($order->status == 'pending')
                                                <span class="badge bg-warning">En attente</span>
                                            @elseif(($order->status == 'shipped'))
                                                <span class="badge bg-info">Expédié</span>
                                            @elseif($order->status == 'cancelled')
                                                <span class="badge bg-danger rounded-1">Annulé</span>
                                            @else
                                                <span class="badge bg-success">Livré</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($order->grand_total, 0, '.', ' ') }} CFA</td>
                                        <td>{{ $order->created_at }}</td>
                                    </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td class="5">Records not found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

