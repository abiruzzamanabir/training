@php
    use App\Models\Theme;
    $theme = Theme::findOrFail(1);
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thank you - {{$name}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="shortcut icon" href="{{ asset('assets/img/'.$theme->favicon)}}" type="image/x-icon">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        body {
            background-color: #e9ebee;
            background-image: url('{{ asset('assets/img/' . $theme->background) }}');
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
                    <div class="card shadow">
                        <div class="card-header">
                            <h2 class="text-center">Thank You <span
                                    class="text-muted text-capitalize">{{ $name }}</span> !</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="text-center text-muted">This Order ID: <b
                                    class="text-dark">{{ $ukey }}</b> is Submitted Successfully.</h5>
                        </div>
                        <div>
                            <table style="box-shadow: none;border:1px solid white"
                                class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <td class="text-center border-0 bg-dark text-white" colspan="2">
                                            <h4>Payment details</h4>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $vat= $themeamount*0.15;
                                        $total= $themeamount+$vat;
                                    @endphp
                                    <tr>
                                        <td class="w-50 text-center">
                                            <h6>Amount</h6>
                                        </td>
                                        <td class="w-50 text-center">
                                            <h6><del>BDT {{ number_format($total) ?? '' }}.00 </del> BDT 0.00</h6>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                 <div class="col-md-6 text-center"><a href="{{ route('form.index') }}"
                                        class="btn btn-md my-3 w-75 btn-primary">Submit Another Nomination</a></div>
                                <div class="col-md-6 text-center"><a href="{{$theme->url}}"
                                        class="btn btn-md my-3 w-75 btn-primary">Go To Home</a></div>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            @include('footer')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
