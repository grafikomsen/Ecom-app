@extends('admin.layouts.app')
@section('main')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Modifiez produit</h1>
            </div>
            <div class="col-sm-6 text-end">
                <a href="{{ route('admin.product') }}" class="btn btn-primary rounded-1 border-0">Retour</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="POST" name="editForm" id="editForm">
            <div class="row">
                <div class="col-md-8">
                    <div class="card rounded-1 mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title">Titre</label>
                                        <input type="text" name="title" id="title" class="form-control rounded-1" value="{{ $product->title }}" placeholder="Title">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug">Lien</label>
                                        <input type="text" name="slug" id="slug" class="form-control rounded-1" value="{{ $product->slug }}" placeholder="slug">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="short_description">Courte description</label>
                                        <textarea name="short_description" id="short_description" class="summernote" placeholder="Description">{{ $product->short_description }}</textarea>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="summernote" placeholder="Description">{{ $product->description }}</textarea>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="shipping_returns">Retour du commande</label>
                                        <textarea name="shipping_returns" id="shipping_returns" class="summernote" placeholder="Description">{{ $product->shipping_returns}}</textarea>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card rounded-1 mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <br>Déposez les fichiers ici ou cliquez pour télécharger.<br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3" id="product-gallery">
                        @if ($productImages->isNotEmpty())
                            @foreach ($productImages as $image)
                                <div class="col-md-3" id="image-row-{{ $image->id }}">
                                    <div class="card">
                                        <input type="hidden" name="image_array[]" value="{{ $image->id }}">
                                        <img src="{{ asset('uploads/product/'.$image->image) }}" class="card-img-top" alt="">
                                        <div class="card-body">
                                            <a href="javascript:void(0)" onclick="deleteImage({{ $image->id }})" class="btn btn-danger btn-sm rounded-1 border-0">Supprimer <i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Inventaire</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" name="sku" id="sku" class="form-control rounded-1" value="{{ $product->sku }}" placeholder="sku">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" name="barcode" id="barcode" class="form-control rounded-1" value="{{ $product->barcode }}" placeholder="Barcode">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="track_qty" value="Yes" {{ ($product->track_qty == 'Yes') ? 'checked' : '' }} name="track_qty" value="Yes" checked>
                                            <label for="track_qty" class="custom-control-label rounded-1">Track Quantity</label>
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="number" min="0" name="qty" id="qty" class="form-control rounded-1" value="{{ $product->qty }}" placeholder="Qty">
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <div class="card rounded-1 mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Produits associés</h2>
                                    <div class="mb-3">
                                        <select multiple class="related-product w-100" name="related_products[]" id="related_products">
                                            @if (!empty($relatedProducts))
                                                @foreach($relatedProducts as $relProduct)
                                                    <option selected value="{{ $relProduct->id }}">{{ $relProduct->title }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Status produit</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control rounded-1">
                                    <option {{ ($product->status == 1) ? 'selected' : '' }} value="1">Active</option>
                                    <option {{ ($product->status == 0) ? 'selected' : '' }} value="0">Désactivé</option>
                                    <p></p>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card rounded-1 mb-3">
                        <div class="card-body">
                            <h2 class="h4  mb-3">Catégorie produit </h2>
                            <div class="mb-3">
                                <label for="category">Catégorie</label>
                                <select name="category" id="category" class="form-control rounded-1">
                                    <option value="">-- selectionnez -- </option>
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option {{ ($product->category_id == $category->id ) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                    <p></p>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="sub_category">Sous catégorie</label>
                                <select name="sub_category" id="sub_category" class="form-control rounded-1">
                                    <option value="">-- selectionnez --</option>
                                    @if ($subCategories->isNotEmpty())
                                        @foreach ($subCategories as $subCategory)
                                            <option {{ ($product->sub_category_id == $subCategory->id ) ? 'selected' : '' }} value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                        @endforeach
                                    @endif
                                    <p></p>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card rounded-1 mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Marque produit</h2>
                            <div class="mb-3">
                                <select name="brand" id="brand" class="form-control rounded-1">
                                    <option value="">-- selectionnez --</option>
                                    @if ($brands->isNotEmpty())
                                        @foreach ($brands as $brand)
                                            <option {{ ($product->brand_id == $brand->id ) ? 'selected' : '' }} value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    @endif
                                    <p></p>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card rounded-1 mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Featured product</h2>
                            <div class="mb-3">
                                <select name="is_featured" id="is_featured" class="form-control rounded-1">
                                    <option {{ ($product->is_featured == 'No') ? 'selected' : '' }} value="No">Non</option>
                                    <option {{ ($product->is_featured == 'Yes') ? 'selected' : '' }} value="Yes">Oui</option>
                                    <p></p>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card rounded-1 mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Prix</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price">Prix</label>
                                        <input type="text" name="price" id="price" class="form-control rounded-1" value="{{ $product->price }}" placeholder="Price">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="compare_price">Compare at Price</label>
                                        <input type="text" name="compare_price" id="compare_price" class="form-control rounded-1" value="{{ $product->compare_price }}" placeholder="Compare Price">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary rounded-1 border-0">Modifiez</button>
                <a href="{{ route('admin.product') }}" class="btn btn-danger rounded-1 float-end ml-3">Annulez</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
    <script>
        $('.related-product').select2({
            ajax: {
                url: '{{ route('product.getProducts') }}',
                dataType: 'json',
                tags: true,
                multiple: true,
                minimumInputLength: 3,
                processResults: function (data) {
                    return {
                        results: data.tags
                    };
                }
            }
        });

        $('#title').change(function() {
            element = $(this);
            $("button[type='submit']").prop('desabled', true);
            $.ajax({
                url: '{{ route("getSlug") }}',
                type: 'GET',
                data: {title: element.val()},
                dataType: 'json',
                success: function (response) {
                    $("button[type='submit']").prop('desabled', false);
                    if (response['status'] == true) {
                        $("#slug").val(response['slug']);
                    }
                }
            });
        });

        $('#editForm').submit(function(event) {
            event.preventDefault();
            let formArray = $(this).serializeArray();
            $("button[type='submit']").prop('desabled',true);

            $.ajax({
                url: '{{ route("admin.product.updated",$product->id) }}',
                type: 'PUT',
                data: formArray,
                dataType: 'json',
                success: function (response) {
                    $("button[type='submit']").prop('desabled',false);

                    if (response['status'] == true) {

                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'], select, input[type='number']").removeClass('is-invalid');

                        window.location.href="{{ route('admin.product') }}";

                    } else {

                        let errors = response['errors'];

                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'], select, input[type='number']").removeClass('is-invalid');

                        $.each(errors, function(key,value) {
                            $(`#${key}`)
                            .addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(value);
                        });
                    }
                },
                error: function () {
                    console.log('Quelque chose bloque les choses?');
                }
            });
        });

        $('#category').change(function(event) {

            let category_id = $(this).val();
            $.ajax({
                url: '{{ route("admin.productSubCategorie") }}',
                type: 'GET',
                data: {category_id:category_id},
                dataType: 'json',
                success: function (response) {
                    //console.log(response);
                    $("#sub_category").find("option").not(":first").remove();
                    $.each(response["subCategories"], function(key,item) {
                        $("#sub_category").append(`<option value='${item.id}'>${item.name}</option>`)
                    })
                },
                error: function () {
                    console.log('Quelque chose bloque les choses?');
                }
            });
        });

        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            url:  "{{ route('product-images.update') }}",
            maxFiles: 10,
            paramName: 'image',
            params: {'product_id': '{{ $product->id }}'},
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif,image/webp",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(file, response){
                let html = `
                <div class="col-md-3" id="image-row-${response.image_id}">
                    <div class="card">
                        <input type="hidden" name="image_array[]" value="${response.image_id}">
                        <img src="${response.ImagePath}" class="card-img-top" alt="">
                        <div class="card-body">
                            <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-danger btn-sm rounded-1 border-0">Supprimer <i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                </div>`;
                $("#product-gallery").append(html);
            },
            complete: function (file) {
                this.removeFile(file);
            }
        });

        function deleteImage(id){
            if (confirm("Êtes-vous sûr de vouloir supprimer l'image?")) {
                $.ajax({
                    url: '{{ route("product-images.destroy") }}',
                    type: 'DELETE',
                    data: {id:id},
                    success: function(response) {
                        if (response.status == true) {
                            alert(response.message)
                        } else {
                            alert(response.message)
                        }
                    }
                })
            }
        }
    </script>
@endsection

