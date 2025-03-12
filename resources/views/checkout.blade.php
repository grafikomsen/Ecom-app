@extends('layouts.app')
@section('content')
<main>
    <section class="section-5 py-3 pt-4 pb-2 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-text" href="{{ route('home') }}"><i class="fa fa-home" aria-hidden="true"></i> Acceuil</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-text" href="{{ route('shop') }}">Boutique</a>
                    </li>
                    <li class="breadcrumb-item">Commandez</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 py-4 bg-light">
        <div class="container">
            <form name="orderForm" id="orderForm" method="POST">
                <div class="row">
                    <div class="col-md-8">
                        <div class="sub-title">
                            <h2>Shipping Address</h2>
                        </div>
                        <div class="card shadow-sm border-0">
                            <div class="card-body checkout-form">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{ (!empty($customerAddress)) ? $customerAddress->first_name : '' }}">
                                            {{-- <p></p> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name"  value="{{ (!empty($customerAddress)) ? $customerAddress->last_name : '' }}">
                                            {{-- <p></p> --}}
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="email" name="email" id="email" class="form-control" placeholder="Email"  value="{{ (!empty($customerAddress)) ? $customerAddress->email : '' }}">
                                            {{-- <p></p> --}}
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <select name="country" id="country" class="form-control">
                                                <option> -- Selectionnez votre pays -- </option>
                                                @if($countries->isNotEmpty())
                                                    @foreach($countries as $country)
                                                        <option {{ (!empty($customerAddress) && $customerAddress->country_id == $country->id) ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="text" name="address" id="address" placeholder="Adresse" class="form-control" value="{{ (!empty($customerAddress)) ? $customerAddress->address : '' }}">
                                            {{-- <p></p> --}}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="text" name="apartment" id="apartment" class="form-control" placeholder="Appartement, suite, unit, etc. (optional)" value="{{ (!empty($customerAddress)) ? $customerAddress->apartment : '' }}">
                                            {{-- <p></p> --}}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="city" id="city" class="form-control" placeholder="Ville" value="{{ (!empty($customerAddress)) ? $customerAddress->city : '' }}">
                                            {{-- <p></p> --}}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="state" id="state" class="form-control" placeholder="State" value="{{ (!empty($customerAddress)) ? $customerAddress->state : '' }}">
                                            {{-- <p></p> --}}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="zip" id="zip" class="form-control" placeholder="Zip" value="{{ (!empty($customerAddress)) ? $customerAddress->zip : '' }}">
                                            {{-- <p></p> --}}
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile No." value="{{ (!empty($customerAddress)) ? $customerAddress->mobile : '' }}">
                                            {{-- <p></p> --}}
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="notes" id="notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control"> {{ (!empty($customerAddress)) ? $customerAddress->notes : '' }}</textarea>
                                            {{-- <p></p> --}}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sub-title">
                            <h2>Order Summery</h3>
                        </div>
                        <div class="card border-0 shadow-sm cart-summery">
                            <div class="card-body">

                                @foreach(Cart::content() as $item)
                                    <div class="d-flex justify-content-between pb-2">
                                        <div class="h6">{{ $item->name }} X {{ $item->qty }}</div>
                                        <div class="h6">{{ number_format($item->price*$item->qty, 0, '.', ' ') }} CFA</div>
                                    </div>
                                @endforeach
                                <hr>
                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6"><strong>Subtotal</strong></div>
                                    <div class="h6"><strong>{{ Cart::subtotal(0,'.',' ') }} CFA</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="h6"><strong>Shipping</strong></div>
                                    <div class="h6"><strong  id="shippingCharge">{{ number_format($totalShippingCharge, 0, '.', ' ') }} CFA</strong></div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mt-2 summery-end">
                                    <div class="h5"><strong>Total</strong></div>
                                    <div class="h5"><strong id="grandTotal">{{ number_format($grandTotal, 0, '.', ' ') }} CFA</strong></div>
                                </div>
                            </div>
                        </div>

                        <div class="card payment-form border-0 shadow-sm p-4 mt-4">
                            <h3 class="card-title h5 mb-3">Méthode de Paiement</h3>
                            <div class="">
                                <input type="radio" checked name="payment_method" value="cod" id="payment_method_one">
                                <label for="payment_method_on" class="form-check-label">Mode de paiement</label>
                            </div>

                            <div class="">
                                <input type="radio" name="payment_method" value="cod" id="payment_method_two">
                                <label for="payment_method_two" class="form-check-label">Stripe</label>
                            </div>

                            <div class="card-body p-0 d-none" id="card-payment-form">
                                <div class="mb-3">
                                    <label for="card_number" class="mb-2">Card Number</label>
                                    <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="expiry_date" class="mb-2">Expiry Date</label>
                                        <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="expiry_date" class="mb-2">CVV Code</label>
                                        <input type="text" name="expiry_date" id="expiry_date" placeholder="123" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="btn-dark btn btn-default border-0 w-100">Pay Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection

@section('customJs')
    <script>
        $("#payment_method_one").click(function(){
            if($(this).is(":checked") == true){
                $("#card-payment-form").addClass('d-none');
            }
        });

        $("#payment_method_two").click(function(){
            if($(this).is(":checked") == true){
                $("#card-payment-form").removeClass('d-none');
            }
        });

        $("#orderForm").submit(function(e){
            e.preventDefault();

            $('button[type="submit"]').prop('disabled',true);

            $.ajax({
                url: '{{ route("processCheckout") }}',
                type: 'POST',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){

                    let errors = response.errors;
                    $('button[type="submit"]').prop('disabled',false);

                    if (response.status == false){

                        if(errors.first_name){
                            $("#first_name").addClass('is-invalid').siblings("p")
                            .addClass('invalid-feedback').html(errors.first_name)
                        } else {
                            $("#first_name").removeClass('is-invalid').siblings("p")
                            .removeClass('invalid-feedback').html('')
                        }

                        if(errors.last_name){
                            $("#last_name").addClass('is-invalid').siblings("p")
                            .addClass('invalid-feedback').html(errors.last_name)
                        } else {
                            $("#last_name").removeClass('is-invalid').siblings("p")
                            .removeClass('invalid-feedback').html('')
                        }

                        if(errors.email){
                            $("#email").addClass('is-invalid').siblings("p")
                            .addClass('invalid-feedback').html(errors.email)
                        } else {
                            $("#email").removeClass('is-invalid').siblings("p")
                            .removeClass('invalid-feedback').html('')
                        }

                        if(errors.country){
                            $("#country").addClass('is-invalid').siblings("p")
                            .addClass('invalid-feedback').html(errors.country)
                        } else {
                            $("#country").removeClass('is-invalid').siblings("p")
                            .removeClass('invalid-feedback').html('')
                        }

                        if(errors.address){
                            $("#address").addClass('is-invalid').siblings("p")
                            .addClass('invalid-feedback').html(errors.address)
                        } else {
                            $("#address").removeClass('is-invalid').siblings("p")
                            .removeClass('invalid-feedback').html('')
                        }

                        if(errors.city){
                            $("#city").addClass('is-invalid').siblings("p")
                            .addClass('invalid-feedback').html(errors.city)
                        } else {
                            $("#city").removeClass('is-invalid').siblings("p")
                            .removeClass('invalid-feedback').html('')
                        }

                        if(errors.state){
                            $("#state").addClass('is-invalid').siblings("p")
                            .addClass('invalid-feedback').html(errors.state)
                        } else {
                            $("#state").removeClass('is-invalid').siblings("p")
                            .removeClass('invalid-feedback').html('')
                        }

                        if(errors.zip){
                            $("#zip").addClass('is-invalid').siblings("p")
                            .addClass('invalid-feedback').html(errors.zip)
                        } else {
                            $("#zip").removeClass('is-invalid').siblings("p")
                            .removeClass('invalid-feedback').html('')
                        }

                        if(errors.mobile){
                            $("#mobile").addClass('is-invalid').siblings("p")
                            .addClass('invalid-feedback').html(errors.mobile)
                        } else {
                            $("#mobile").removeClass('is-invalid').siblings("p")
                            .removeClass('invalid-feedback').html('')
                        }

                    } else {
                        window.location.href="{{ url('/merci-de-commandez/') }}/"+response.orderId;
                    }
                }
            });
        });

        $("#country").change(function(){
            $.ajax({
                url: '{{ route("getOrderSummery") }}',
                type: 'POST',
                data: {country_id: $(this).val()},
                dataType: 'JSON',
                success: function(response){
                    if (response.status == true){
                        $("#shippingCharge").html(response.shippingCharge+' CFA');
                        $("#grandTotal").html(response.grandTotal+' CFA');
                    }
                }
            });
        });
    </script>
@endsection
