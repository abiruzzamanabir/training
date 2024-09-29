@php
use App\Models\Theme;
$theme = Theme::findOrFail(1);
$rate_2 = getenv('RATE_2');
$rate_3 = getenv('RATE_3');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment - {{ $name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ asset('assets/img/'.$theme->favicon)}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        body {
            background-color: #e9ebee;
            background-image: url('{{ asset(' assets/img/' . $theme->background) }}');
        }

        .container {
            margin-top: 30px;
        }

        .card {
            background: #f1f3f6;
            border: none;
            border-radius: 15px;
            /* box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.1), -10px -10px 20px rgba(255, 255, 255, 0.5); */
        }

        .card-header {
            background: #e9ebee;
            border-bottom: none;
            border-radius: 15px 15px 0 0;
        }

        .card-body {
            background: #f1f3f6;
            border-top: none;
        }

        .card-footer {
            background: #e9ebee;
            border-top: none;
            border-radius: 0 0 15px 15px;
        }

        .text-muted {
            color: #8792a1;
        }

        .btn-primary {
            background: #d1d9e6;
            color: #5e6687;
            border: none;
            box-shadow: 4px 4px 8px #b7bfcf, -4px -4px 8px #ffffff;
        }

        .btn-primary:hover {
            background: #b1b9c6;
            color: #4d5470;
        }

        .btn-primary:focus {
            box-shadow: none;
        }

        table {
            background: #f1f3f6;
            border: none;
            border-radius: 10px;
            box-shadow: 8px 8px 16px #d6d9de, -8px -8px 16px #ffffff;
        }

        table thead {
            background: #d1d9e6;
            color: #5e6687;
            border-radius: 10px 10px 0 0;
        }

        table td {
            border-top: none;
        }

        .accordion-header {
            background: #d1d9e6;
            color: #5e6687;
            border: none;
            border-radius: 10px;
            box-shadow: 8px 8px 16px #b7bfcf, -8px -8px 16px #ffffff;
        }

        .accordion-header:hover {
            background: #b1b9c6;
            color: #4d5470;
        }

        .accordion-header.collapsed {
            background: #f1f3f6;
        }

        .accordion-body {
            background: #f1f3f6;
            border-radius: 0 0 10px 10px;
            border-top: none;
            box-shadow: 8px 8px 16px #d6d9de, -8px -8px 16px #ffffff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center g-2 mt-3">
            <div class="col-md-8">
                @include('validate')

                <div>
                    @if ($payment == 2)
                    <div class="card shadow">
                        <div class="card-header">
                            <h2 class="text-center">Thank You <span class="text-muted text-capitalize">{{ $name }}</span> !</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="text-center text-muted">This Registration ID: <b class="text-dark">{{ $ukey }}</b> is paid successfully @if ($card_issuer != '')
                                through
                                @else
                                by
                                @endif <span class="text-dark">
                                    @if ($card_issuer != '')
                                    <b>{{ $card_issuer }}
                                        @else
                                        online payment
                                        @endif
                                </span>.</h5>
                        </div>
                        <div>
                            <table style="box-shadow: none;border:1px solid white" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <td class="text-center border-0 bg-dark text-white" colspan="2">
                                            <h4>Payment details</h4>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="w-50 text-center">
                                            <h6>Transaction ID</h6>
                                        </td>
                                        <td class="w-50 text-center">
                                            <h6>{{ $transaction_id }}</h6>
                                        </td>
                                    </tr>
                                    @if ($tran_date)
                                    <tr>
                                        <td class="w-50 text-center">
                                            <h6>Transaction Time</h6>
                                        </td>
                                        <td class="w-50 text-center">
                                            <h6>{{ date('d-m-Y, g:i A ' , strtotime($tran_date)) ?? '' }}</h6>
                                            {{-- <h6>{{ $tran_date ?? '' }}</h6> --}}
                                        </td>
                                    </tr>
                                    @endif
                                    @if ($card_issuer)
                                    <tr>
                                        <td class="w-50 text-center">
                                            <h6>Payment Method</h6>
                                        </td>
                                        <td class="w-50 text-center">
                                            <h6>{{ $card_issuer }}</h6>
                                        </td>
                                    </tr>
                                    @endif
                                    @if ($bank_tran_id)
                                    <tr>
                                        <td class="w-50 text-center">
                                            <h6>Bank Transaction ID</h6>
                                        </td>
                                        <td class="w-50 text-center">
                                            <h6>{{ $bank_tran_id ?? '' }}</h6>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="w-50 text-center">
                                            <h6>Amount</h6>
                                        </td>
                                        <td class="w-50 text-center">
                                            <h6>BDT {{ number_format($amount) ?? '' }}.00</h6>
                                        </td>
                                    </tr>
                                </tbody>P
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-center"><a href="{{ route('form.index') }}" class="btn btn-md my-3 w-75 btn-primary">Submit Another Nomination</a></div>
                            <div class="col-md-6 text-center"><a href="{{$theme->url}}" class="btn btn-md my-3 w-75 btn-primary">Go To Home</a></div>
                        </div>
                        <div class="card-footer text-center">
                            @include('footer')
                        </div>
                    </div>
                    @elseif ($invoice != null)
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-center">Thank You <span class="text-muted text-capitalize">{{ $name }}</span> !</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="text-center text-muted">This Registration ID: <b class="text-dark">{{ $ukey }}</b> is already submitted by <span class="text-dark">Cash Payment</span>.</h5>
                        </div>
                        <div>
                            <table style="box-shadow: none;border:1px solid white" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <td class="text-center border-0 bg-dark text-white" colspan="2">
                                            <h4>Payment details</h4>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="w-50 text-center">
                                            <h6>Invoice Number</h6>
                                        </td>
                                        <td class="w-50 text-center">
                                            <h6>{{ $invoice }}</h6>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-center"><a href="{{ route('form.index') }}" class="btn btn-md my-3 w-75 btn-primary">Submit Another Nomination</a></div>
                            <div class="col-md-6 text-center"><a href="{{$theme->url}}" class="btn btn-md my-3 w-75 btn-primary">Go To Home</a></div>
                        </div>
                        <div class="card-footer text-center">
                            @include('footer')
                        </div>

                    </div>
                    @else
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div>
                                    <h1 style="text-decoration: underline;" class="modal-title text-danger text-center">Important Notice</h1>
                                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                </div>
                                <div class="modal-body">
                                    <h4 class="text-center text-danger">This is a paid event. Please ensure your payment is completed to secure your seat. Failure to pay will result in cancelation of your registration.</h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Got it</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center"><b class="text-uppercase">Registration ID:</b> {{ $ukey }}
                            </h4>
                            <h6 class="text-center">Pay Your Registration Fees</h6>
                        </div>
                        <div class="card-body">
                            <h3 class="text-muted">Your Cart</h3>
                            @php
                            if($total_member<=3){ $amount=$theme->amount;
                                }
                                if($total_member>=4 && $total_member <=6){ $amount=$rate_2; } if($total_member>=7){
                                    $amount = $rate_3;
                                    }
                                    $total_amount=$amount*$total_member;
                                    $vat = $total_amount *0.15;
                                    $total = $total_amount+$vat;
                                    @endphp
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                @if($total_member >= 7)
                                                <td>Nomination Fee</td>
                                                <td class="text-end text-muted"><del>BDT {{ number_format($theme->amount) }} </del>BDT {{ number_format($amount) }}/Person</td>
                                                @elseif($total_member >= 4 && $total_member <= 6) <td>Nomination Fee</td>
                                                    <td class="text-end text-muted"><del>BDT {{ number_format($theme->amount) }} </del>BDT {{ number_format($amount) }}/Person</td>
                                                    @else
                                                    <td>Nomination Fee</td>
                                                    <td class="text-end text-muted">BDT {{ number_format($amount) }}/Person</td>
                                                    @endif
                                            </tr>

                                            <tr>
                                                <td>Number Of Nomination</td>
                                                <td class="text-end text-muted">{{ $total_member }}</td>
                                            </tr>
                                            <tr>
                                                <td>Sub Total</td>
                                                <td class="text-end text-muted">BDT {{ number_format($total_amount) }}</td>
                                            </tr>
                                            <tr>
                                                <td>VAT (15%)</td>
                                                <td class="text-end text-muted">BDT {{ number_format($vat) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total</td>
                                                <td class="text-end"><b>BDT {{ number_format($total) }}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <b>Card Payment | Mobile Banking | Internet Banking</b>
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    @include('nomination.information')
                                                    <form action="{{ route('pay') }}" method="POST">
                                                        @csrf
                                                        <input class="form-control my-2" type="hidden" value="{{ $ukey }}" name="uid" id="uid">
                                                        <input class="form-control my-2" type="hidden" value="{{ $ukey }}" name="ukey" id="ukey">
                                                        <input class="form-control my-2" type="hidden" value="{{ $name }}" name="name" id="customer_name">
                                                        <input class="form-control my-2" type="hidden" value="{{ $email }}" name="email" id="email">
                                                        <input class="form-control my-2" type="hidden" value="{{ $phone }}" name="phone" id="mobile">
                                                        <input class="form-control my-2" type="hidden" value="{{$total}}" name="total" id="total_amount">
                                                        <button style="width: 100%" class="btn btn-primary" postdata="" endpoint="/pay-via-ajax"> Pay Now
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        </div>
                        <div class="card-footer text-center">
                            @include('footer')
                        </div>
                    </div>
                    @endif

                </div>

            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.querySelector('.modal'));
            modal.show();
        });
    </script>

    <script>
        var obj = {};
        obj.cus_id = $('#uid').val();
        obj.cus_keu = $('#ukey').val();
        obj.cus_name = $('#customer_name').val();
        obj.cus_phone = $('#mobile').val();
        obj.cus_email = $('#email').val();
        obj.cus_addr1 = $('#address').val();
        obj.amount = $('#total_amount').val();

        $('#sslczPayBtn').prop('postdata', obj);
    </script>

    <script>
        (function(window, document) {
            var loader = function() {
                var script = document.createElement("script"),
                    tag = document.getElementsByTagName("script")[0];
                script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
                tag.parentNode.insertBefore(script, tag);
            };

            window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
        })(window, document);
    </script>
    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    </script>
    @include('kill')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>