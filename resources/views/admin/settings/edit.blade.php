@extends('admin.layouts.app')
@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-5 border-bottom">
        <h2 class="fs-2 fw-bold">Modifier les Paramètres</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.settings') }}" class="btn btn-primary btn-sm shadow-sm rounded-0 border-0">
                Retour <i class="fa fa-close text-danger fw-bolder px-2"></i>
            </a>
        </div>
    </div>

    <!-- Main content -->
    <section class="content h-100">
        <div class="container-fluid h-100">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <form name="editSettingForm" id="editSettingForm">
                        <div class="card card-secondary rounded-1">
                            <div class="card-header text-start">
                                <h3 class="text-uppercase fw-bold mt-2">Informations du SEO</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group mb-3">
                                    <label for="website_title">Titre du web site</label>
                                    <input type="text" name="website_title" id="website_title" value="{{ $setting->website_title }}" class="form-control rounded-1" placeholder="Enter le titre du site web">
                                    <p class="error name-error text-danger"></p>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" rows="7" class="form-control">{{ $setting->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="image">Image</label>
                                            <input type="hidden" name="image_id" id="image_id" value="">
                                            <div id="image" class="dropzone dz-clickable rounded-1">
                                                <div class="dz-message needsclick">
                                                    <br>Déposez les fichiers ici ou cliquez pour télécharger.<br><br>
                                                </div>
                                            </div>
                                            <img class="img-thumbnail my-2" src="{{ asset('uploads/settings/'.$setting->image) }}" width="50" alt="{{ $setting->name }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="keyword">Le mot clé</label>
                                            <input type="text" name="keyword" id="keyword" value="{{ $setting->keyword }}" class="form-control rounded-1" placeholder="Enter le mot clé">
                                            <p class="error name-error text-danger"></p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="url_canonique">Url canonique</label>
                                            <input type="text" name="url_canonique" id="url_canonique" value="{{ $setting->url_canonique }}" class="form-control rounded-1" placeholder="Enter l' url canonique">
                                            <p class="error name-error text-danger"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="og_locale">Og locale</label>
                                            <input type="text" name="og_locale" id="og_locale" value="{{ $setting->og_locale }}" class="form-control rounded-1">
                                            <p class="error name-error text-danger"></p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="og_type">Og type</label>
                                            <input type="text" name="og_type" id="og_type" value="{{ $setting->og_type }}" class="form-control rounded-1">
                                            <p class="error name-error text-danger"></p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="og_image_type">Og image type</label>
                                            <input type="text" name="og_image_type" id="og_image_type" value="{{ $setting->og_image_type }}" class="form-control rounded-1">
                                            <p class="error name-error text-danger"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="article_modified_time">Modification de la date de l'article</label>
                                            <input type="date" name="article_modified_time" id="article_modified_time" value="{{ $setting->article_modified_time }}" class="form-control rounded-1">
                                            <p class="error name-error text-danger"></p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="twitter_card">Carte de twitter</label>
                                            <input type="text" name="twitter_card" id="twitter_card" value="{{ $setting->twitter_card }}" class="form-control rounded-1">
                                            <p class="error name-error text-danger"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="Google_tag">Google Tag</label>
                                    <textarea name="Google_tag" id="Google_tag" rows="5" class="form-control">{{ $setting->Google_tag }}</textarea>
                                </div>

                                <div class="row">
                                    <h3 class="text-uppercase fw-bold mt-2">Informations du lien Google</h3>
                                    <div class="col-12 col-md-6">
                                        <label for="url_googleMaps">Google Map</label>
                                        <input type="text" name="url_googleMaps" id="url_googleMaps" value="{{ $setting->url_googleMaps }}" class="form-control rounded-1" placeholder="Enter l'url de google map">
                                        <p class="error name-error text-danger"></p>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="url_googleSearchConsole">Google search Console</label>
                                        <input type="text" name="url_googleSearchConsole" id="url_googleSearchConsole" value="{{ $setting->url_googleSearchConsole }}" class="form-control rounded-1" placeholder="Enter l'url google search console">
                                        <p class="error name-error text-danger"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-secondary my-4 rounded-1">
                            <div class="card-header text-start">
                                <h3 class="text-uppercase fw-bold mt-2">Informations des réseaux sociaux</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <label for="url_facebook">Facebook</label>
                                        <input type="text" name="url_facebook" id="url_facebook" value="{{ $setting->url_facebook }}" class="form-control rounded-1" placeholder="Enter l'url de Facebook">
                                        <p class="error name-error text-danger"></p>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="url_instagram">Instagram</label>
                                        <input type="text" name="url_instagram" id="url_instagram" value="{{ $setting->url_instagram }}" class="form-control rounded-1" placeholder="Enter l'url de Instagram">
                                        <p class="error name-error text-danger"></p>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="url_twintter">Twintter</label>
                                        <input type="text" name="url_twintter" id="url_twintter" value="{{ $setting->url_twintter }}" class="form-control rounded-1" placeholder="Enter l'url de Twintter">
                                        <p class="error name-error text-danger"></p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card card-secondary my-4 rounded-1">
                            <div class="card-header text-start">
                                <h3 class="text-uppercase fw-bold mt-2">Informations de contacts</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                     <div class="col-12 col-md-4">
                                        <label for="address">Emplacement du local</label>
                                        <input type="text" name="address" id="address" value="{{ $setting->address }}" class="form-control rounded-1" placeholder="Enter l'emlpacement">
                                        <p class="error name-error text-danger"></p>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="phone_1">N° de téléphone</label>
                                        <input type="text" name="phone" id="phone" value="{{ $setting->phone }}" class="form-control rounded-1" placeholder="Enter le N° de téléphone">
                                        <p class="error name-error text-danger"></p>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label for="email_1">Adresse mail</label>
                                        <input type="email" name="email" id="email" value="{{ $setting->email }}" class="form-control rounded-1" placeholder="Enter le mail">
                                        <p class="error name-error text-danger"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-secondary my-4 rounded-1 p-4">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label for="copyright">Copy right</label>
                                    <input type="text" name="copyright" id="copyright" value="{{ $setting->copyright }}" class="form-control rounded-1" placeholder="Enter le mail">
                                    <p class="error name-error text-danger"></p>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="sitemap">Plan du site</label>
                                    <input type="text" name="sitemap" id="sitemap" value="{{ $setting->sitemap }}" class="form-control rounded-1" placeholder="Enter le plan du site">
                                    <p class="error name-error text-danger"></p>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control rounded-0">
                                    <option {{ ($setting->status == 1) ? 'selected' : '' }} value="1">Activé</option>
                                    <option {{ ($setting->status == 0) ? 'selected' : '' }} value="0">Désactivé</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="submit" class="btn btn-primary border-0 rounded-0">Modifiez</button>
                        </div>
                    </form>
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

        $("#editSettingForm").submit(function(e){
            e.preventDefault();
            $("button[type='submit']").prop('disabled',true);
            $.ajax({
                url: '{{ route("admin.settings.updated",$setting->id) }}',
                type: 'PUT',
                dataType: 'JSON',
                data: $("#editSettingForm").serializeArray(),
                success: function (response) {
                    $("button[type='submit']").prop('disabled',false);
                    if (response.status == 200) {
                        window.location.href = "{{ route('admin.settings') }}";
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
