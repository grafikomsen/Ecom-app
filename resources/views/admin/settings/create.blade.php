@extends('admin.layouts.app')
@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-5 border-bottom">
        <h2 class="fs-2 fw-bold">Créer le faq</h2>
        <div class="btn-toolbar mb-2 mb-md-0">

        </div>
    </div>

    <!-- Main content -->
    <section class="content h-100">
        <div class="container-fluid h-100">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary rounded-0">
                        <div class="card-header text-end">
                            <a href="{{ route('admin.faqs') }}" class="btn btn-primary btn-sm shadow-sm rounded-0 border-0">
                                Retour <i class="fa fa-close text-danger fw-bolder px-2"></i>
                            </a>
                        </div>
                        <form method="POST" name="createFaqForm" id="createFaqForm">
                            <div class="card-body">

                                <div class="form-group mb-3">
                                    <label for="question">Question du faq</label>
                                    <input type="text" name="question" id="question" class="form-control rounded-0" placeholder="Enter le nom du faq">
                                    <p class="error name-error text-danger"></p>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="answer">Response</label>
                                    <textarea name="answer" id="answer" rows="6" class="form-control"></textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control rounded-0">
                                        <option value="1">Activé</option>
                                        <option value="0">Désactivé</option>
                                    </select>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" name="submit" class="btn btn-primary border-0 rounded-0">Sauvegardez</button>
                            </div>
                        </form>
                    </div>
                </div>
             </div>
            <!-- /.row -->
            <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('extraJs')

    <script>

        $('#createFaqForm').submit(function(event){
            event.preventDefault();
            $("button[type='submit']").prop('disabled',true);
            $.ajax({
                url: '{{ route("admin.faqs.store") }}',
                type: 'POST',
                dataType: 'json',
                data: $('#createFaqForm').serializeArray(),
                success: function (response) {
                    $("button[type='submit']").prop('disabled',false);
                    if (response.status == 200) {
                        window.location.href = "{{ route('admin.faqs') }}";
                    } else {
                        $('.name-error').html(response.errors.name);
                    }
                }
            });
        });

        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url:  "{{ route('tempUpload') }}",
            maxFiles: 1,
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif,image/webp",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(file, response){
                $("#image_id").val(response.id);
                //console.log(response)
            }
        });

    </script>

@endsection
