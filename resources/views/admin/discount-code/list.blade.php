@extends('admin.layouts.app')
@section('main')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Code coupon</h1>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.discount.create') }}" class="btn btn-primary rounded-1 border-0">Nouveau code coupon</a>
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
            <div class="card rounded-1">
                <form action="" method="GET">
                    <div class="card-header">
                        <div class="card-title float-end">
                            <a class="btn btn-primary rounded-1 border-0 btn-sm" href="{{ route('admin.discount') }}">Actualisé la page</a>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" value="{{ Request::get('keyword') }}" name="keyword" class="form-control rounded-1 float-right" placeholder="Cherchez ici...">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary border-0 rounded-1">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive p-0 rounded-1">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Nom</th>
                                <th>Code</th>
                                <th>Commence à</th>
                                <th>expire à</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($discounts->isNotEmpty())
                                @foreach ($discounts as $discount)
                                    <tr>
                                        <td>{{ $discount->id }}</td>
                                        <td>{{ $discount->name }}</td>
                                        <td>{{ $discount->code }}</td>
                                        <td>{{ (!empty($discount->starts_at)) ? \Carbon\Carbon::parse($discount->starts_at)->format('Y/m/d H:i:s') : "" }}</td>
                                        <td>{{ (!empty($discount->expires_at)) ? \Carbon\Carbon::parse($discount->expires_at)->format('Y/m/d H:i:s') : "" }}</td>
                                        <td>
                                            @if ($discount->type == "percent")
                                                {{ $discount->discount_amount }} %
                                            @else
                                                {{ $discount->discount_amount }} CFA
                                            @endif
                                        </td>
                                        <td>
                                            @if ($discount->status)
                                                <i class="fa fa-check-circle text-primary"></i>
                                            @else
                                                <i class="fa fa-check-circle text-danger"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-sm rounded-1 border-0" href="{{ route('admin.discount.edit',$discount->id) }}">
                                                <i class="fa fa-edit text-white"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm rounded-1 border-0" onclick="deleteDiscount({{ $discount->id }})">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="5">Enregistrements introuvables</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $discounts->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->


@endsection

@section('customJs')
    <script>
        function deleteDiscount(id){

            let url = '{{ route("admin.discount.destroy","ID") }}';
            let newUrl = url.replace('ID',id);

            if (confirm('Etes-vous sûr de vouloir supprimer')) {
                $.ajax({
                    url: newUrl,
                    type: 'DELETE',
                    data: {},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $("button[type=submit]").prop('desabled', false);
                        if (response['status']) {
                            window.location.href="{{ route('admin.discount') }}";
                        }
                    }
                })
            }
        }
    </script>
@endsection
