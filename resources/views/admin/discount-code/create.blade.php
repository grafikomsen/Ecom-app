@extends('admin.layouts.app')
@section('main')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="fw-bolder">Créer un code coupon</h2>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.discount') }}" class="btn btn-primary rounded-1 border-0">Retour</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form method="POST" name="discountForm" id="discountForm">
                <div class="card rounded-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control rounded-1" placeholder="Nom">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="code" class="form-control rounded-1" placeholder="Code coupon">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" rows="4" class="form-control rounded-1"></textarea>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_uses">Max uses</label>
                                    <input type="number" name="max_uses" id="max_uses" class="form-control rounded-1" placeholder="Max uses">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_uses_user">Max uses user</label>
                                    <input type="text" name="max_uses_user" id="max_uses_user" class="form-control rounded-1" placeholder="Max uses user">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type">Type</label>
                                    <select name="type" id="type" class="form-control rounded-1">
                                        <option value="percent">Percent</option>
                                        <option value="fixed">Fixed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control rounded-1">
                                        <option value="1">Active</option>
                                        <option value="0">Désactivé</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount_amount">Discount amount</label>
                                    <input type="text" name="discount_amount" id="discount_amount" class="form-control rounded-1" placeholder="Discount amount">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="min_amount">Min amount</label>
                                    <input type="text" name="min_amount" id="min_amount" class="form-control rounded-1" placeholder="Max uses user">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="starts_at">Starts At</label>
                                    <input type="text" autocomplete="off" name="starts_at" id="starts_at" class="form-control rounded-1" placeholder="Discount amount">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expires_at">Expires At</label>
                                    <input type="text" autocomplete="off" name="expires_at" id="expires_at" class="form-control rounded-1" placeholder="Max uses user">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary rounded-1 border-0">Sauvegardez</button>
                    <a href="{{ route('admin.discount') }}" class="btn btn-danger rounded-1 float-end ml-3">Annulez</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>

        $(document).ready(function(){
            $('#starts_at').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });

            $('#expires_at').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });
        });

        $('#discountForm').submit(function (event) {
            event.preventDefault();
            let element = $(this);
            $("button[type=submit]").prop('desabled', true);

            $.ajax({
                url: '{{ route("admin.discount.store") }}',
                type: 'POST',
                data: element.serializeArray(),
                dataType: 'json',
                success: function (response) {
                    $("button[type=submit]").prop('desabled', false);

                    if (response['status'] == true) {

                        window.location.href="{{ route('admin.discount') }}";

                        $('#name').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html('');

                        $('#code').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html('');

                        $('#discount_amount').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html('');

                        $('#starts_at').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html('');

                        $('#expires_at').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html('');

                    } else {

                        let errors = response['errors'];
                        // NAME
                        if (errors['name']) {
                            $('#name').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['name']);
                        } else {
                            $('#name').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html('');
                        }

                        // CODE
                        if (errors['code']) {
                            $('#code').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['code']);
                        } else {
                            $('#code').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html('');
                        }

                        // DISCOUNT AMOUNT
                        if (errors['discount_amount']) {
                            $('#discount_amount').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['discount_amount']);
                        } else {
                            $('#discount_amount').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html('');
                        }

                        // STARTS AT
                        if (errors['starts_at']) {
                            $('#starts_at').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['starts_at']);
                        } else {
                            $('#starts_at').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html('');
                        }

                        // EXPIRES AT
                        if (errors['expires_at']) {
                            $('#expires_at').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['expires_at']);
                        } else {
                            $('#expires_at').removeClass('is-invalid')
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
