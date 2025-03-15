@extends('admin.layouts.app')
@section('main')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Commande: #{{ $order->id }}</h1>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.order') }}" class="btn btn-primary border-0 rounded-1">Retour</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    @include('admin.messages')
                    <div class="card rounded-1 mb-4">
                        <div class="card-header">
                            <div class="row invoice-info">
                                <div class="col-sm-6 invoice-col">
                                    <h5 class="fw-bold">Adresse de livraison</h5>
                                    <address>
                                        <strong>{{ $order->first_name.' '.$order->last_name }}</strong><br>
                                        {{ $order->city }}<br>
                                        {{ $order->address.', '.$order->apartment }}<br>
                                        Phone: {{ $order->mobile }}<br>
                                        Email: {{ $order->email }}
                                    </address>
                                </div>

                                <div class="col-sm-6 invoice-col">
                                    <h5 class="fw-bold">Facture #{{ $order->id }}</h5>
                                    <b>Commande ID:</b> {{ $order->id }}<br>
                                    <b>Total:</b> {{ number_format($order->grand_total, 0, '.', ' ') }} CFA<br>
                                    <b>Status:</b>
                                        @if ($order->status == 'pending')
                                            <span class="badge bg-warning rounded-1">En attente</span>
                                        @elseif(($order->status == 'shipped'))
                                            <span class="badge bg-info rounded-1">Expédié</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger rounded-1">Annulé</span>
                                        @else
                                            <span class="badge bg-success rounded-1">Livré</span>
                                        @endif
                                    <br>
                                    <b>Date d'expédition:</b>
                                    <time>
                                        @if (!empty($order->shipped_date))
                                            {{ $order->shipped_date }}
                                        @else
                                            n/a
                                        @endif
                                    </time>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="100">Produit</th>
                                        <th width="50">Prix</th>
                                        <th width="10">Qty</th>
                                        <th width="50">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($orderItems->isNotEmpty())
                                       @foreach($orderItems as $item)
                                       <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ number_format($item->price, 0, '.', ' ') }} CFA</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ number_format($item->total, 0, '.', ' ') }} CFA</td>
                                        </tr>
                                       @endforeach
                                    @endif

                                    <tr>
                                        <th colspan="3" class="text-end">Subtotal:</th>
                                        <td>{{ number_format($order->subtotal, 0, '.', ' ') }} CFA</td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end">Shipping:</th>
                                        <td>{{ number_format($order->shipping, 0, '.', ' ') }} CFA</td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end">Discount ({{ (!empty($order->coupon_code)) ? $order->coupon_code : '' }}):</th>
                                        <td>{{ number_format($order->discount, 0, '.', ' ') }} CFA</td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end">Grand Total:</th>
                                        <td>{{ number_format($order->grand_total, 0, '.', ' ') }} CFA</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card rounded-1 mb-4">
                        <form method="POST" name="changeOrderStatusForm" id="changeOrderStatusForm">
                            <div class="card-body">
                                <h5 class="h4 mb-3">Statut de la commande</h5>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control rounded-1">
                                        <option {{ ($order->status == 'pending') ? 'selected' : '' }} value="pending">En attente</option>
                                        <option {{ ($order->status == 'shipped') ? 'selected' : '' }} value="shipped">Expédié</option>
                                        <option {{ ($order->status == 'delivered') ? 'selected' : '' }} value="delivered">Livré</option>
                                        <option {{ ($order->status == 'cancelled') ? 'selected' : '' }} value="cancelled">Annulé</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="shipped_date">Date d'expédition</label>
                                    <input autocomplete="off" name="shipped_date" id="shipped_date" class="form-control rounded-1" value="{{ $order->shipped_date }}">
                                </div>

                                <div class="mb-3">
                                    <button class="btn btn-primary border-0 rounded-1">Mise à jour</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card rounded-1">
                        <div class="card-body">
                            <h5 class="h4 mb-3">Envoyer un e-mail de notification</h5>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control rounded-1">
                                    <option value="">Client</option>
                                    <option value="">Administrateur</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary border-0 rounded-1">Envoyer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>

        $(document).ready(function(){
            $('#shipped_date').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });
        });

        $('#changeOrderStatusForm').submit(function(e){
            e.preventDefault();

            $.ajax({
                url: '{{ route("admin.order.changeOrderStatus",$order->id) }}',
                type: 'POST',
                data: $(this).serializeArray(),
                dataType: 'JSON',
                success: function(){
                    window.location.href="{{ route('admin.order.detail',$order->id) }}";
                }
            });
        });

    </script>
@endsection
