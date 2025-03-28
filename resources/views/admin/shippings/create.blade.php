@extends('admin.layouts.app')
@section('main')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-12">
                <h1>Gestion des expéditions</h1>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form method="POST" name="shippingForm" id="shippingForm">
            @include('admin.messages')
            <div class="card p-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title">Nom</label>
                            <select type="text" name="country" id="country" class="form-control rounded-1">
                                <option value=""> -- Sélectionnez un pays -- </option>
                                @if ($countries->isNotEmpty())
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                    <option value="rest_of_world">Reste du monde</option>
                                @endif
                            </select>
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="title">Prix</label>
                            <input type="text" name="amount" id="amount" class="form-control rounded-1" placeholder="Montant">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="my-4">
                            <button type="submit" class="btn btn-primary rounded-1 border-0">Sauvegardez</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card pt-2 mt-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body table-responsive p-0 rounded-1">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Prix</th>
                                        <th width="100">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if($shippingCharges->isNotEmpty())
                                        @foreach($shippingCharges as $shipping)
                                        <tr>
                                            <td>{{ $shipping->id }}</td>
                                            <td>{{ ($shipping->country_id == 'rest_of_world') ? 'Le reste du monde' : $shipping->name }}</td>
                                            <td>{{ $shipping->amount }}</td>
                                            <td width="100">
                                                <a class="btn btn-primary btn-sm rounded-1 border-0" href="{{ route('admin.shipping.edit',$shipping->id) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm rounded-1 border-0" onclick="deleteShipping({{ $shipping->id }})">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
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
        $('#shippingForm').submit(function (event) {
            event.preventDefault();
            let element = $(this);
            $("button[type=submit]").prop('desabled', true);

            $.ajax({
                url: '{{ route("admin.shipping.store") }}',
                type: 'POST',
                data: element.serializeArray(),
                dataType: 'json',
                success: function (response) {
                    $("button[type=submit]").prop('desabled', false);

                    if (response['status'] == true) {

                        window.location.href="{{ route('admin.shipping.create') }}";

                    } else {

                        let errors = response['errors'];
                        // NAME
                        if (errors['country']) {
                            $('#country').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['country']);
                        } else {
                            $('#country').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html('');
                        }

                        // AMOUNT
                        if (errors['amount']) {
                            $('#amount').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['amount']);
                        } else {
                            $('#amount').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html('');
                        }

                    }

                }, error: function (jqXHR, exception) {
                    console.log("Something went wrong");
                }
            });
        });

        function deleteShipping(id){

            let url = '{{ route("admin.shipping.delete","ID") }}';
            let newUrl = url.replace("ID",id);
            if(confirm("Êtes-vous sûr de vouloir supprimer?")){
                $.ajax({
                    url: newUrl,
                    type: 'DELETE',
                    data: {},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response['status']) {
                            window.location.href="{{ route('admin.shipping.create') }}";
                        }
                    }
                });

            }
        }

    </script>
@endsection
