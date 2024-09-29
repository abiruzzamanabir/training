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
    <title>
        @if ($page == 'dashboard')
        Dashboard
        @elseif($page == 'trash')
        Trash
        @else
        Payment Verified
        @endif
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.13.2/datatables.min.css" />
    <script src="https://use.fontawesome.com/b477068b8c.js"></script>
    <link rel="shortcut icon" href="{{ asset('assets/img/' . $theme->favicon) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            background-color: #f1f1f1;
            background-image: url('{{ asset(' assets/img/' . $theme->background) }}');
        }

        .container-fluid {
            background-color: #f1f1f1;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
        }

        .container {
            background-color: #f1f1f1;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            box-shadow: 8px 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            border: none;
        }

        .card-header {
            background-color: #f1f1f1;
            border-radius: 10px;
            border-bottom: 1px solid #e1e1e1;
        }

        .card-body {
            background-color: #f1f1f1;
            border-radius: 10px;
        }

        .btn {
            border-radius: 8px;
            box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table {
            border-radius: 10px;
            box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .badge {
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btnsize {
            width: 20px;
            height: 20px;
            padding: 0;
            border-radius: 50%;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        textarea {
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 8px;
        }

        .btn-info {
            background-color: #58a3f7;
            color: #fff;
        }

        .btn-danger {
            background-color: #f15151;
            color: #fff;
        }

        .btn-success {
            background-color: #4caf50;
            color: #fff;
        }

        .btn-info:hover,
        .btn-info:focus {
            background-color: #4f93d6;
        }

        .btn-danger:hover,
        .btn-danger:focus {
            background-color: #e04343;
        }

        .btn-success:hover,
        .btn-success:focus {
            background-color: #47a847;
        }
    </style>

</head>

<body>
    @if (session('authenticatedDashboard'))
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        @if ($page == 'dashboard')
                        <a href="{{ route('trash.index') }}" class="btn btn-sm btn-danger">Trash<span
                                class="badge bg-light text-dark ms-1">{{ $count }}</span></a>
                        <a href="{{ route('paymentverified.index') }}" class="btn btn-sm btn-success">Payment
                            Verified<span class="badge bg-light text-dark ms-1">{{ $countpv }}</span></a>
                        @elseif($page == 'trash')
                        <a href="{{ route('dashboard.index') }}" class="btn btn-sm btn-info">Dashboard<span
                                class="badge bg-light text-dark ms-1">{{ $count }}</span></a>
                        <a href="{{ route('paymentverified.index') }}" class="btn btn-sm btn-success">Payment
                            Verified<span class="badge bg-light text-dark ms-1">{{ $countpv }}</span></a>
                        @elseif($page == 'pv')
                        <a href="{{ route('dashboard.index') }}" class="btn btn-sm btn-info">Dashboard<span
                                class="badge bg-light text-dark ms-1">{{ $count }}</span></a>
                        <a href="{{ route('trash.index') }}" class="btn btn-sm btn-danger">Trash<span
                                class="badge bg-light text-dark ms-1">{{ $count1 }}</span></a>
                        @endif
                        <a href="{{ route('invoice.index') }}" class="btn btn-sm btn-primary">Invoice<span
                                class="badge bg-light text-dark ms-1">{{ $invoice }}</span></a>
                        <a style="float: right;" href="{{ route('logout') }}" class="btn btn-sm btn-danger">Logout</a>

                    </div>
                    <div class="card-body overflow-auto">
                        @include('validate')
                        <table style="text-align: center" id="dashboard" class="table table-striped table-bordered">
                            <thead>
                                <tr class="table-info">
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Organization</th>
                                    <th scope="col">Team Members</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Comment</th>
                                    <th scope="col">Payment Method</th>
                                    @if ($page == 'pv')
                                    <th scope="col">Confirmation</th>
                                    @endif
                                    @if ($page == 'dashboard' || $page == 'trash')
                                    <th scope="col">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($all_nomination as $item)
                                <tr>
                                    <th onclick="copyUserId('{{ $item->ukey }}')"
                                        @if (!empty($item->comment)) style="background-color: #fadbd8"
                                        @else @endif
                                        scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ date('l, F j, Y, g:i A', strtotime($item->created_at)) }}</td>
                                    <td class="text-capitalize">{{ $item->name }}</td>
                                    <td onclick="copyUserEmail('{{ $item->email }}')">{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->designation }}</td>
                                    <td>{{ $item->organization }}</td>
                                    <td>
                                        @php
                                        $members = json_decode($item->members, true);
                                        @endphp

                                        @if (!empty($members) && is_array($members))
                                        <ul class="list-group">
                                            @foreach ($members as $member)
                                            <li class="list-group-item shadow-sm rounded my-1">
                                                <strong>Name:</strong> {{ $member['member_name'] }}<br>
                                                <strong>Designation:</strong> {{ $member['member_designation'] }}<br>
                                                <strong>Organization:</strong> {{ $member['member_organization'] }}<br>
                                                <strong>Contact:</strong> {{ $member['member_contact'] }}<br>
                                                <strong>Email:</strong> <a href="mailto:{{ $member['member_email'] }}">{{ $member['member_email'] }}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @else
                                        <div class="alert-warning p-2 shadow-sm">
                                            No members available.
                                        </div>
                                        @endif
                                    </td>


                                    <td>{{ $item->address }}</td>
                                    <td class="align-top">
                                        <form action="{{ route('dashboard.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <textarea name="comment" id="" cols="30" rows="3" placeholder="Enter Your Comment Here....">{{ $item->comment }}</textarea>
                                            <br>
                                            <button class="btn btn-info btn-sm btnsize" type="submit"><i
                                                    class="fa fa-check" aria-hidden="true"></i></button>
                                            <a class="btn btn-info btn-sm btnsize"
                                                href="{{ route('comment.empty', $item->id) }}"><i
                                                    class="fa fa-refresh" aria-hidden="true"></i></a>
                                        </form>
                                    </td>
                                    @php
                                    $order_details = DB::table('orders')
                                    ->where('transaction_id', $item->ukey)
                                    ->select('transaction_id', 'status', 'currency', 'amount', 'card_issuer')
                                    ->orderBy('id', 'desc')
                                    ->first();
                                    @endphp
                                    <td style="font-size: 12px">
                                        @if ($item->category == 'Best Innovation in Robotics & AI' || $item->category == 'Best Innovation in Software/App Solution Development' || $item->category == 'Best Innovation in New Business Solutions' || $item->category == 'Best Innovation in Medical/Healthcare')
                                        @if ($item->pv == 1)
                                        <p>Free<br><span
                                                class="badge bg-success">Free</span>
                                        </p>
                                        <a href="{{ route('payment.status.update', $item->ukey) }}"><span class="badge bg-success">Payment Verified</span></a>
                                        @elseif($item->pv == 0)
                                        <p>Free<br><span
                                                class="badge bg-success">Free</span>
                                        </p>
                                        <a href="{{ route('payment.status.update', $item->ukey) }}"><span class="badge bg-danger">Payment Unverified</span></a>
                                        @else @endif
                                        @elseif ($item->payment == 2)
                                        <p>Paid Online<br><span
                                                class="badge bg-success">Online</span><br><b>{{ $order_details->card_issuer }}</b>
                                        </p>
                                        @elseif ($item->invoice != null)
                                        @if ($item->pv == 0)
                                        <p class="m-0">Cheque Payment<br>Invoice : <b
                                                class="@if ($item->pv == 0) text-danger
                                                @elseif($item->pv == 1)
                                            text-success
                                                @else @endif">{{ $item->invoice }}</b><br><a
                                                href="{{ route('payment.status.update', $item->ukey) }}"><span
                                                    class="badge bg-danger">Payment Unverified</span></a>
                                        </p>
                                        {{-- <a class="text-success btnsize" style="font-size: 16px !important" href="{{ route('payment.status.update',$item->ukey) }}"><i
                                            class="fa fa-check" aria-hidden="true"></i></a> --}}
                                        @else
                                        <p class="m-0">Cheque Payment<br>Invoice : <b
                                                class="@if ($item->pv == 0) text-danger
                                                                    @elseif($item->pv == 1)
                                            text-success
                                            @else @endif">{{ $item->invoice }}</b><br><a
                                                href="{{ route('payment.status.update', $item->ukey) }}"><span
                                                    class="badge bg-success">Payment verified</span></a>
                                        </p>
                                        {{-- <a class="text-danger btnsize" style="font-size: 16px !important" href="{{ route('payment.status.update',$item->ukey) }}"><i
                                            class="fa fa-times" aria-hidden="true"></i></a> --}}
                                        @endif
                                        @else
                                        <form action="{{ route('dashboard.payment') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="name" readonly
                                                value="{{ $item->name }}">
                                            <input type="hidden" name="email" readonly
                                                value="{{ $item->email }}">
                                            <input type="hidden" name="phone" readonly
                                                value="{{ $item->phone }}">
                                            <input type="hidden" name="ukey" readonly
                                                value="{{ $item->ukey }}">
                                            <button type="submit" class="btn btn-info btn-sm">Send Mail For
                                                Payment <span
                                                    class="badge bg-success">{{ $item->confirmLinkSend }}</span></button>
                                        </form>
                                        @endif
                                    </td>
                                    @if ($page == 'pv')
                                    <td>
                                        @if ($item->payment == '2')
                                        <form action="{{ route('dashboard.payment.confirm') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="name" readonly
                                                value="{{ $item->name }}">
                                            <input type="hidden" name="email" readonly
                                                value="{{ $item->email }}">
                                            <input type="hidden" name="phone" readonly
                                                value="{{ $item->phone }}">
                                            <input type="hidden" name="ukey" readonly
                                                value="{{ $item->ukey }}">
                                            <button type="submit" class="btn btn-info btn-sm">Send Mail
                                                For
                                                Confirmation </button>
                                        </form>
                                        @endif
                                    </td>
                                    @endif
                                    @if ($page == 'dashboard' || $page == 'trash')
                                    <td>
                                        @if ($item->trash)
                                        <span class="d-flex">
                                            <a class="btn btn-sm btn-success me-1"
                                                href="{{ route('trash.update', $item->ukey) }}"><i
                                                    class="fa fa-undo" aria-hidden="true"></i></a>
                                            <form class="d-inline delete-form"
                                                action="{{ route('dashboard.destroy', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"><i
                                                        class="fa fa-trash"
                                                        aria-hidden="true"></i></button>
                                            </form>
                                        </span>
                                        @else
                                        <span class="d-flex">
                                            <a class="btn btn-sm btn-success me-1"
                                                href="{{ route('form.edit', $item->id) }}"><i
                                                    class="fa fa-edit" aria-hidden="true"></i></a>
                                            <a class="btn btn-sm btn-danger"
                                                href="{{ route('trash.update', $item->ukey) }}"><i
                                                    class="fa fa-trash" aria-hidden="true"></i></a>
                                        </span>
                                        @endif
                                    </td>
                                    @endif

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">@include('footer')</div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="container">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col-md-12">
                <div class="card-header text-center">
                    <h3><u>Settings</u></h3>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        @include('validate')
                        <form action="{{ route('authenticate.dashboard') }}" method="POST" class="was-validated">
                            @csrf
                            <div class="border p-3 shadow my-3">
                                <div class="mb-2">
                                    <label for="validationName" class="form-label">
                                        <b>Password</b> <span class="text-danger">*</span></b>
                                    </label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Enter Password To View This Page" autofocus required>
                                </div>
                            </div>
                            <div class="mt-2 text-center">
                                <button style="width: 120px;" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-footer text-muted text-center">
                    @include('footer')
                </div>
            </div>
        </div>
    </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js"
        integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.13.2/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.5/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var time = new Date().getTime();
        $(document.body).bind("mousemove keypress", function(e) {
            time = new Date().getTime();
        });

        function refresh() {
            if (new Date().getTime() - time >= 300000)
                window.location.reload(true);
            else if (new Date().getTime() - time >= 240000 && new Date().getTime() - time <= 246000) {
                let timerInterval
                Swal.fire({
                    title: 'Auto reload alert!',
                    html: 'I will reload in <b></b> milliseconds.',
                    timer: 54000,
                    allowOutsideClick: true,
                    showCancelButton: true,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.reload(true);
                    }
                })
            } else
                setTimeout(refresh, 10000);
        }

        setTimeout(refresh, 10000);
        $(document).ready(function() {
            $(".delete-form").submit(function(e) {
                let conf = confirm("Are you sure?");

                if (conf) {
                    return true;
                } else {
                    e.preventDefault();
                }
            });
            $('#dashboard').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    </script>
    @if (session('authenticatedDashboard'))

    @else
    @include('kill')
    @endif
    <script>
        function copyUserId(userId) {
            var dummyInput = document.createElement('input');
            document.body.appendChild(dummyInput);
            dummyInput.setAttribute('value', userId);
            dummyInput.select();
            document.execCommand('copy');
            document.body.removeChild(dummyInput);
            // alert('User ID copied to clipboard: ' + userId);
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'User ID copied to clipboard: ' + userId,
                showConfirmButton: false,
                timer: 2000
            })
        }

        function copyUserEmail(userEmail) {
            var dummyInput = document.createElement('input');
            document.body.appendChild(dummyInput);
            dummyInput.setAttribute('value', userEmail);
            dummyInput.select();
            document.execCommand('copy');
            document.body.removeChild(dummyInput);
            // window.location.href = "mailto:"+ userEmail;
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'User Email copied to clipboard: ' + userEmail,
                showConfirmButton: false,
                timer: 2000
            })
            // alert('User Email copied to clipboard: ' + userEmail);
        }
    </script>

</body>

</html>