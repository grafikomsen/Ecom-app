@extends('layouts.app')
@section('content')

    <section class="section-5 py-3 pt-4 pb-2 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-text" href="{{ route('home') }}">Acceuil</a>
                    </li>
                    <li class="breadcrumb-item">Mon compte</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-11 bg-light py-4">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('account.sidebar')
                </div>
                <div class="col-md-9">
                    @include('account.message')
                    <div class="card mb-4 rounded-1">
                        <div class="card-header bg-primary rounded-0">
                            <h2 class="h5 mb-0 pt-2 text-white pb-2">Informations personnelles</h2>
                        </div>
                        <div class="card-body rounded-1 p-4">
                            <form name="profileForm" id="profileForm">
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="name">Nom</label>
                                        <input type="text" name="name" id="name" value="{{ $user->name }}" placeholder="Entrez votre nom" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" value="{{ $user->email }}" placeholder="Entrez votre e-mail" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone">Téléphone</label>
                                        <input type="text" name="phone" id="phone" value="{{ $user->phone }}" placeholder="Entrez votre téléphone" class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-default rounded-1">
                                            Mise à jour
                                            <i class="fa fa-upload text-white"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mb-4 rounded-1">
                        <div class="card-header bg-primary rounded-0">
                            <h2 class="h5 mb-0 pt-2 text-white pb-2">Adresse</h2>
                        </div>
                        <div class="card-body rounded-1 p-4">
                            <form name="addressForm" id="addressForm">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="first_name">Prénom</label>
                                        <input type="text" name="first_name" id="first_name" value="{{ (!empty($customerAddress->first_name)) ? $customerAddress->first_name : '' }}" placeholder="Entrez votre nom" class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="last_name">Nom</label>
                                        <input type="text" name="last_name" id="last_name" value="{{ (!empty($customerAddress->last_name)) ? $customerAddress->last_name : '' }}" placeholder="Entrez votre nom" class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" value="{{ (!empty($customerAddress->email)) ? $customerAddress->email : '' }}" placeholder="Entrez votre e-mail" class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="mobile">Téléphone</label>
                                        <input type="text" name="mobile" id="mobile" value="{{ (!empty($customerAddress->mobile)) ? $customerAddress->mobile : '' }}" placeholder="Entrez votre téléphone" class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="address">Pays</label>
                                        <select name="country" id="country" class="form-control">
                                            <option value=""> -- Selectionnez pays -- </option>
                                            @if($countries->isNotEmpty())
                                                @foreach ($countries as $country)
                                                    <option {{ (!empty($customerAddress) && $customerAddress->country_id == $country->id) ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>

                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="state">Ville</label>
                                        <input type="text" name="state" id="state" value="{{ (!empty($customerAddress->state)) ? $customerAddress->state : '' }}" placeholder="Entrez votre téléphone" class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="city">Commune</label>
                                        <input type="text" name="city" id="city" value="{{ (!empty($customerAddress->city)) ? $customerAddress->city : '' }}" placeholder="Entrez votre e-mail" class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="apartment">Appartement</label>
                                        <input type="text" name="apartment" id="apartment" value="{{ (!empty($customerAddress->apartment)) ? $customerAddress->apartment : '' }}" placeholder="Entrez votre téléphone" class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="col-12 col-md-3 mb-3">
                                        <label for="zip">Zip</label>
                                        <input type="text" name="zip" id="zip" value="{{ (!empty($customerAddress->zip)) ? $customerAddress->zip : '' }}" placeholder="Entrez votre téléphone" class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="address">Adresse</label>
                                        <input type="text" name="address" id="address" value="{{ (!empty($customerAddress->address)) ? $customerAddress->address : '' }}" placeholder="Entrez votre e-mail" class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="mb-3">
                                        <label for="notes">Note</label>
                                        <textarea type="text" name="notes" id="notes" rows="2" cols="30" class="form-control">{{ (!empty($customerAddress->notes)) ? $customerAddress->notes : '' }}</textarea>
                                        <p></p>
                                    </div>

                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-default rounded-1">
                                            Mise à jour
                                            <i class="fa fa-upload text-white"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('customJs')
    <script>

        $('#profileForm').submit(function(e){
            e.preventDefault();
            $("button[type='submit']").prop('disabled',true);

            $.ajax({
                url: '{{ route("account.UpdateProfile") }}',
                type: 'PUT',
                data: $(this).serializeArray(),
                dataType: 'JSON',
                success: function(response){
                    $("button[type='submit']").prop('disabled',false);

                    if(response.status == true){

                        //NAME
                        $('#name')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');

                        //EMAIL
                        $('#email')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');

                        //PHONE
                        $('#phone')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');

                        window.location.href="{{ route('account.profile') }}";

                    } else {

                        let errors = response.errors;
                        // NAME
                        if(errors.name){
                            $('#name')
                            .addClass('is-invalid')
                            .siblings('p')
                            .html(errors.name)
                            .addClass('invalid-feedback');
                        } else {
                            $('#name')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');
                        }

                        //EMAIL
                        if(errors.email){
                            $('#email')
                            .addClass('is-invalid')
                            .siblings('p')
                            .html(errors.email)
                            .addClass('invalid-feedback');
                        } else {
                            $('#email')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');
                        }

                        //PHONE
                        if(errors.phone){
                            $('#phone')
                            .addClass('is-invalid')
                            .siblings('p')
                            .html(errors.phone)
                            .addClass('invalid-feedback');
                        } else {
                            $('#phone')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');
                        }
                    }
                }
            });
        });

        $('#addressForm').submit(function(e){
            e.preventDefault();
            $("button[type='submit']").prop('disabled',true);

            $.ajax({
                url: '{{ route("account.updateAddress") }}',
                type: 'PUT',
                data: $(this).serializeArray(),
                dataType: 'JSON',
                success: function(response){
                    $("button[type='submit']").prop('disabled',false);

                    if(response.status == true){

                        //NAME
                        $('#first_name')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');

                        //last_name
                        $('#last_name')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');

                        //MOBILE
                        $('#mobile')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');

                        //STATE
                        $('#state')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');

                        //CITY
                        $('#city')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');

                        //ADDRESS
                        $('#address')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');

                        //ZIP
                        $('#zip')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');

                        window.location.href="{{ route('account.profile') }}";

                    } else {

                        let errors = response.errors;
                        // FIRST_NAME
                        if(errors.first_name){
                            $('#first_name')
                            .addClass('is-invalid')
                            .siblings('p')
                            .html(errors.first_name)
                            .addClass('invalid-feedback');
                        } else {
                            $('#first_name')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');
                        }

                        //LAST_NAME
                        if(errors.last_name){
                            $('#last_name')
                            .addClass('is-invalid')
                            .siblings('p')
                            .html(errors.last_name)
                            .addClass('invalid-feedback');
                        } else {
                            $('#last_name')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');
                        }

                        //EMAIL
                        if(errors.email){
                            $('#email')
                            .addClass('is-invalid')
                            .siblings('p')
                            .html(errors.email)
                            .addClass('invalid-feedback');
                        } else {
                            $('#email')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');
                        }

                        //MOBILE
                        if(errors.mobile){
                            $('#mobile')
                            .addClass('is-invalid')
                            .siblings('p')
                            .html(errors.mobile)
                            .addClass('invalid-feedback');
                        } else {
                            $('#mobile')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');
                        }

                        //STATE
                        if(errors.state){
                            $('#state')
                            .addClass('is-invalid')
                            .siblings('p')
                            .html(errors.state)
                            .addClass('invalid-feedback');
                        } else {
                            $('#state')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');
                        }

                        //CITY
                        if(errors.city){
                            $('#city')
                            .addClass('is-invalid')
                            .siblings('p')
                            .html(errors.city)
                            .addClass('invalid-feedback');
                        } else {
                            $('#city')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');
                        }

                        //ZIP
                        if(errors.zip){
                            $('#zip')
                            .addClass('is-invalid')
                            .siblings('p')
                            .html(errors.zip)
                            .addClass('invalid-feedback');
                        } else {
                            $('#zip')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');
                        }

                        //ADDRESS
                        if(errors.address){
                            $('#address')
                            .addClass('is-invalid')
                            .siblings('p')
                            .html(errors.address)
                            .addClass('invalid-feedback');
                        } else {
                            $('#address')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');
                        }

                        //NOTES
                        if(errors.notes){
                            $('#notes')
                            .addClass('is-invalid')
                            .siblings('p')
                            .html(errors.notes)
                            .addClass('invalid-feedback');
                        } else {
                            $('#notes')
                            .removeClass('is-invalid')
                            .siblings('p')
                            .html('')
                            .removeClass('invalid-feedback');
                        }
                    }
                }
            });
        });

    </script>
@endsection
