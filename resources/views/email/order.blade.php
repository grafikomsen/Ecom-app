<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets-front/bootstrap/css/bootstrap.min.css') }}">
</head>
<body style=" font-family:'poppins">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if($mailData['userType'] == 'Client')
                    <h3>Merci pour votre commande!</h3>
                    <h4>Votre numéro de commande est: COM#{{ $mailData['order']->id }}</h4>
                @else
                    <h3>Vous avez reçu une commande!</h3>
                    <h4>Commande ID: COM#{{ $mailData['order']->id }}</h4>
                @endif

                <h5 class="fw-bold">Adresse de livraison</h5>
                <address class="mb-4">
                    <strong>{{ $mailData['order']->first_name.' '.$mailData['order']->last_name }}</strong><br>
                    {{ $mailData['order']->city }}<br>
                    {{ $mailData['order']->address.', '.$mailData['order']->apartment }} - {{ getCountryInfo($mailData['order']->country_id)->name }}<br>
                    Phone: {{ $mailData['order']->mobile }}<br>
                    Email: {{ $mailData['order']->email }}
                </address>

                <table cellpadding="3" cellspacing="3" border="0" width="700">
                    <thead>
                        <tr style="background: #CCC">
                            <th>Produit</th>
                            <th width="100">Prix</th>
                            <th width="100">Qty</th>
                            <th width="100">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mailData['order']->items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ number_format($item->price, 0, '.', ' ') }} CFA</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ number_format($item->total, 0, '.', ' ') }} CFA</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="3" class="text-end">Subtotal:</th>
                            <td>{{ number_format($mailData['order']->subtotal, 0, '.', ' ') }} CFA</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Shipping:</th>
                            <td>{{ number_format($mailData['order']->shipping, 0, '.', ' ') }} CFA</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Discount ({{ (!empty($mailData['order']->coupon_code)) ? $mailData['order']->coupon_code : '' }}):</th>
                            <td>{{ number_format($mailData['order']->discount, 0, '.', ' ') }} CFA</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Grand Total:</th>
                            <td>{{ number_format($mailData['order']->grand_total, 0, '.', ' ') }} CFA</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
