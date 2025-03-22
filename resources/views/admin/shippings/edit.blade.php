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
        <form method="POST" name="shippingEditForm" id="shippingEditForm">
            @include('admin.messages')
            <div class="card p-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title">Nom</label>
                            <select type="text" name="country" id="country" class="form-control rounded-1" value="{{ $shipping->country }}">
                                <option value=""> -- Select a country -- </option>
                                @if ($countries->isNotEmpty())
                                    @foreach($countries as $country)
                                        <option {{ ($shipping->country_id == $country->id ) ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                    <option {{ ($shipping->country_id == $country->id ) ? 'selected' : '' }} value="rest_of_world">Rest of the world</option>
                                @endif
                            </select>
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="title">Prix</label>
                            <input type="text" name="amount" id="amount" class="form-control rounded-1" placeholder="Montant" value="{{ $shipping->amount }}">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="my-4">
                            <button type="submit" class="btn btn-primary rounded-1 border-0">Mis à jour</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
    <script>
        $('#shippingEditForm').submit(function (event) {
            event.preventDefault();
            let element = $(this);
            $("button[type=submit]").prop('desabled', true);

            $.ajax({
                url: '{{ route("admin.shipping.updated",$shipping->id) }}',
                type: 'PUT',
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

    </script>
@endsection
