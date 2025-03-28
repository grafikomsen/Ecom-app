@extends('admin.layouts.app')
@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-5 border-bottom">
        <h2 class="fs-2 fw-bold">Modifier le banniérè</h2>
        <div class="btn-toolbar mb-2 mb-md-0">

        </div>
    </div>

    <!-- Main content -->
    <section class="content h-100">
        <div class="container-fluid h-100">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary rounded-1">
                        <div class="card-header text-end">
                            <a href="{{ route('admin.banners') }}" class="btn btn-primary btn-sm shadow-sm rounded-1 border-0">
                                Retour <i class="fa fa-close text-danger fw-bolder px-2"></i>
                            </a>
                        </div>
                        <form name="editBannerForm" id="editBannerForm">
                            <div class="card-body">

                                <div class="form-group mb-3">
                                    <label for="name">Nom du banner</label>
                                    <input type="text" name="name" id="name" value="{{ $banner->name }}" class="form-control rounded-1" placeholder="Enter le nom du banner">
                                    <p class="error name-error text-danger"></p>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="content">Description</label>
                                    <textarea name="content" id="content" rows="6" class="form-control rounded-1">{{ $banner->content }}</textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="url">Url</label>
                                    <input type="text" name="url" id="url" value="{{ $banner->url }}" class="form-control rounded-1" placeholder="Enter un Url">
                                    <p class="error name-error text-danger"></p>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control rounded-1">
                                        <option {{ ($banner->status == 1) ? 'selected' : '' }} value="1">Activé</option>
                                        <option {{ ($banner->status == 0) ? 'selected' : '' }} value="0">Désactivé</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mb-3">
                                            <label for="image">Image</label>
                                            <input type="hidden" name="image_id" id="image_id" value="">
                                            <div id="image" class="dropzone dz-clickable rounded-1">
                                                <div class="dz-message needsclick">
                                                    <br>Déposez les fichiers ici ou cliquez pour télécharger.<br><br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for="image">Image</label>
                                        <div class="form-group mb-3">
                                            <img class="img-thumbnail my-2" src="{{ asset('uploads/banners/'.$banner->image) }}" width="300" height="100" alt="{{ $banner->name }}">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" name="submit" class="btn btn-primary border-0 rounded-1">Modifiez</button>
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

@section('customJs')

    <script>

        $('#editBannerForm').submit(function(e){
            e.preventDefault();
            $("button[type='submit']").prop('disabled',true);
            $.ajax({
                url: '{{ route("admin.banners.updated",$banner->id) }}',
                type: 'PUT',
                dataType: 'JSON',
                data: $('#editBannerForm').serializeArray(),
                success: function (response) {
                    $("button[type='submit']").prop('disabled',false);
                    if (response.status == 200) {
                        window.location.href = "{{ route('admin.banners') }}";
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
        });

    </script>

@endsection
