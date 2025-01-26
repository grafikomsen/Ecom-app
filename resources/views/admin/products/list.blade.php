@extends('admin.layouts.app')
@section('main')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Produits</h1>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary border-0 rounded-1">Nouveau produit</a>
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
            <div class="card rounded">
                <form action="" method="GET">
                    <div class="card-header">
                        <div class="card-title float-end">
                            <a class="btn btn-primary btn-sm border-0 rounded-1" href="{{ route('admin.product') }}">Actualisé la page</a>
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
                                <th width="60">ID</th>
                                <th width="80">Image</th>
                                <th>Produit</th>
                                <th>Prix</th>
                                <th>Qty</th>
                                <th>SKU</th>
                                <th width="100">Status</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($products->isNotEmpty())
                                @foreach ($products as $product)
                                @php
                                    $productImage = $product->product_images->first();
                                @endphp
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>
                                            @if (!empty($productImage->image))
                                                <img src="{{ asset('uploads/product/'.$productImage->image) }}" class="img-thumbnail" width="50" />
                                            @else
                                                <img src="{{ asset('assets-admin/img/default-150x150.png') }}" class="img-thumbnail" width="50" />
                                            @endif
                                        </td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->price }} CFA</td>
                                        <td>{{ $product->qty }}</td>
                                        <td>{{ $product->sku }}</td>
                                        <td>
                                            @if ($product->status == 1)
                                                <i class="fa fa-check-circle text-primary"></i>
                                            @else
                                                <i class="fa fa-check-circle text-danger"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-sm rounded-1 border-0" href="{{ route('admin.product.edit',$product->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm rounded-1 border-0" onclick="deleteProduct({{ $product->id }})">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>Records Not Fount</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
@section('customJs')
    <script>
        function deleteProduct(id){

            let url = '{{ route("admin.product.destroy","ID") }}';
            let newUrl = url.replace('ID',id);

            if (confirm('Are you sure you want to delete')) {
                $.ajax({
                    url: newUrl,
                    type: 'DELETE',
                    data: {},
                    dataType: 'json',
                    success: function (response) {
                        $("button[type=submit]").prop('desabled', false);
                        if (response['status']) {
                            window.location.href="{{ route('admin.product') }}";
                        }
                    }
                })
            }
        }
    </script>
@endsection
