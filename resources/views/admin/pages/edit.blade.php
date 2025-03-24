@extends('admin.layouts.app')
@section('main')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Créer</h1>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.pages') }}" class="btn btn-primary border-0 rounded-1">Retour</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form method="POST" name="pageUpdatedForm" id="pageUpdatedForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Nom</label>
                                    <input type="text" name="name" id="name" value="{{ $page->name }}" class="form-control" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" readonly name="slug" id="slug" value="{{ $page->slug }}" class="form-control" placeholder="Slug">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="content">Content</label>
                                    <textarea name="content" id="content" class="summernote" cols="30" rows="10">{{ $page->content }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary rounded-1 border-0">Modifiez</button>
                    <a href="{{ route('admin.pages') }}" class="btn btn-danger rounded-1 float-end ml-3">Annullez</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
<script>
    $('#pageUpdatedForm').submit(function (event) {
        event.preventDefault();
        let element = $(this);
        $("button[type=submit]").prop('desabled', true);

        $.ajax({
            url: '{{ route("admin.pages.updated",$page->id) }}',
            type: 'PUT',
            data: element.serializeArray(),
            dataType: 'JSON',
            success: function (response) {
                $("button[type=submit]").prop('desabled', false);

                if (response['status'] == true) {

                    window.location.href="{{ route('admin.pages') }}";

                    $('#name').removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html('');

                    $('#slug').removeClass('is-invalid')
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

                    // SLUG
                    if (errors['slug']) {
                        $('#slug').addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['slug']);
                    } else {
                        $('#slug').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html('');
                    }
                }

            }, error: function (jqXHR, exception) {
                console.log("Something went wrong");
            }
        });
    });

    $('#name').change(function() {
        element = $(this);
        $("button[type=submit]").prop('desabled', true);
        $.ajax({
            url: '{{ route("getSlug") }}',
            type: 'GET',
            data: {title: element.val()},
            dataType: 'json',
            success: function (response) {
                $("button[type=submit]").prop('desabled', false);
                if (response['status'] == true) {
                    $("#slug").val(response['slug']);
                }
            }
        });
    });

    /*Dropzone.autoDiscover = false;
    const dropzone = $("#image").dropzone({
        init: function() {
            this.on('addedfile', function(file) {
                if (this.files.length > 1) {
                    this.removeFile(this.files[0]);
                }
            });
        },
        url:  "{{ route('temp-images.create') }}",
        maxFiles: 1,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif,image/webp",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }, success: function(file, response){
            $("#image_id").val(response.image_id);
            //console.log(response)
        }
    });*/
</script>
@endsection

