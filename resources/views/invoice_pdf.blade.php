@php
use Rmunate\Utilities\SpellNumber;
use App\Models\Theme;
$theme = Theme::findOrFail(1);
$amount = $theme->amount;
$vat = $theme->amount *= 0.15;
$total = $amount + $vat;
@endphp
<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
</head>
<style type="text/css">
    @page {
        margin: 0cm 0cm;
    }

    body {
        font-family: 'Roboto Condensed', sans-serif;
        margin-top: 1cm;
        margin-bottom: 1cm;
        margin-left: 1cm;
        margin-right: 1cm;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {
        padding-top: 5px;
    }

    .pb-5 {
        padding-bottom: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .mb-10 {
        margin-bottom: 10px;
    }

    .text-center {
        text-align: center !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .w-55 {
        width: 55%;
    }

    .w-45 {
        width: 45%;
    }

    .w-85 {
        width: 85%;
    }

    .w-15 {
        width: 15%;
    }

    .logo img {
        width: auto;
        height: 60px;
    }

    .gray-color {
        color: #5D5D5D;
    }

    .text-bold {
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    table tr,
    th,
    td {
        border: 1px solid #d2d2d2;
        border-collapse: collapse;
        padding: 7px 8px;
    }

    table tr th {
        background: #F4F4F4;
        font-size: 15px;
    }

    table tr td {
        font-size: 13px;
    }

    table {
        border-collapse: collapse;
    }

    .box-text p {
        line-height: 20px;
    }

    .float-left {
        float: left;
    }

    .total-part {
        font-size: 16px;
        line-height: 12px;
    }

    .total-right p {
        padding-right: 20px;
    }

    .text-upper {
        text-transform: uppercase;
    }

    footer {
        border: 1px solid #d2d2d2;
        margin-top: 20px;
        padding: 5px 0;
        background-color: #F4F4F4;

    }
</style>

<body>
    <div class="head-title">
        <h1 class="text-center m-0 p-0">Invoice</h1>
    </div>
    <div class="add-detail mt-10">
        <div class="w-55 float-left mt-10">
            <!-- <p class="m-0 pt-5 text-bold w-100">Order Id - <span class="gray-color">#1</span></p>
        <p class="m-0 pt-5 text-bold w-100">Invoice Number - <span class="gray-color">AB123456A</span></p>
        <p class="m-0 pt-5 text-bold w-100">Date - <span class="gray-color">22-01-2023</span></p> -->
            <table>
                {{-- <tr>
                    <th style="text-align: left;">Order Id</th>
                    <td>{{ $id }}</td>
                </tr> --}}
                <tr>
                    <th style="text-align: left;">Invoice Number</th>
                    <td>{{ $ukey }}</td>
                </tr>
                <tr>
                    <th style="text-align: left;">Date</th>
                    <td>{{ date('l, F j, Y, g:i A', strtotime($tran_date)) }}</td>
                </tr>
                <tr>
                    <th style="text-align: left;">Type</th>
                    <!-- <td style="color: red;">UNPAID</td> -->
                    <td style="color: green;font-weight: bold;">PAID</td>
                </tr>
                <!-- <tr>
              <th></th>
              <td style="color: red;">UNPAID</td>
              <td style="color: green;">PAID</td>
            </tr> -->
            </table>
        </div>
        <div class="w-45 float-left logo mt-10">
            <img style="float: right !important;"
                src="https://brandzealconsultancy.com/wp-content/uploads/2022/11/Brandzeal-Consultancy-Ltd.png"
                alt="Logo">
        </div>
        <div style="clear: both;"></div>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">From</th>
                <th class="w-50">To</th>
            </tr>
            <tr>
                <td>
                    <div class="box-text">
                        <p><b style="line-height: 20px !important;">Brandzeal, </b>Apartment No-9/A (level-9), House #30
                            CWN (A), Road #42/43,</p>
                        <p>Gulshan-2, Dhaka-1212, Bangladesh.</p>
                        <p>Contact: +88 02 58815318</p>
                    </div>
                </td>
                <td>
                    <div class="box-text">
                        <p style="line-height: 20px !important;"><b
                                style="line-height: 20px !important;">{{ $organization }}, </b>{{ $address }}</p>
                        <p>Email: {{ $email }}</p>
                        <p>Contact: {{ $phone }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">Payment Method</th>
            </tr>
            <tr>
                <td>Online Payment @if ($card_issuer != '')
                    Through <b>{{ $card_issuer }}
                        @endif
                    </b></td>
            </tr>
        </table>
    </div>

    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <thead>
                <tr>
                    <th class="w-50">Description</th>
                    <th class="w-50">Qty</th>
                    <th class="w-50">Rate</th>
                    <th class="w-50">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr align="center">
                    <td><b>"{{ Config::get('app.name') }} {{ now()->year }}"</b><br>Registration Fee</td>
                    <td>{{$member_count}}</td>
                    @php
                    $rate_2 = getenv('RATE_2');
                    $rate_3 = getenv('RATE_3');
                    if ($member_count <= 3) {
                        $rate=$amount;
                        } elseif ($member_count>= 4 && $member_count <= 6) {
                            $rate=$rate_2;
                            } else {
                            $rate=$rate_3;
                            }
                            $amount_total=$rate * $member_count;
                            @endphp
                            <td>BDT {{ number_format($rate) }}</td>
                            <td>BDT {{ number_format($amount_total) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">
                        <div class="total-part">
                            <table style="float: right;">
                                <tr>
                                    <th style="text-align: left;">Sub Total</th>
                                    <td style="text-align: right;">{{ number_format($amount_total) }}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left;">Vat (15%)</th>
                                    <td style="text-align: right;">{{ number_format($amount_total * 0.15) }}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left;">Due</th>
                                    <td style="text-align: right;">0</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left;">Total</th>
                                    <td style="text-align: right;">{{ number_format($amount_total * 1.15) }}</td>
                                </tr>
                            </table>
                            <div style="clear: both;"></div>
                            <p style="font-size:13px;"><b>In Words:</b> {{ SpellNumber::value((int)($amount_total * 1.15))->toLetters() }} Taka Only.</p>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="table-section bill-tbl w-100 mt-10">
        @if (count($members_array) > 0)
        <table class="table w-100 mt-10">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Organizaion</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">{{ $name }}</td>
                    <td style="text-align: center;">{{ $designation }}</td>
                    <td style="text-align: center;">{{ $organization }}</td>
                    <td style="text-align: center;">{{ $phone }}</td>
                </tr>
                @foreach ($members_array as $member)
                <tr>
                    <td style="text-align: center">{{ $member->member_name }}</td>
                    <td style="text-align: center">{{ $member->member_designation }}</td>
                    <td style="text-align: center">{{ $member->member_organization }}</td>
                    <td style="text-align: center">{{ $member->member_contact }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <div style="text-align: center;margin: 10px 0px;font-size: 14px;line-height: 10px;">
                    <p>If you have any queries about this invoice, please contact</p>
                    <p>+880 174 383 6608, +880 183 585 8601 , registration@commward.com</p>
                </div>
                <!--<p style="color: red;font-size:12px;text-align: center">This is system generated invoice</p>-->
            </tr>
        </table>
    </div>
    <footer>
        <div style="text-align: center;font-size: 12px;line-height: 5px;letter-spacing: 1px;">
            <p><b>Brandzeal: </b>Apartment No-9/A (level-9), House #30 CWN (A), Road #42/43</p>
            <p>Gulshan-2, Dhaka-1212, Bangladesh | Phone: +88 02 58815318</p>
            <p>Email: info@bangladeshbrandforum.com | Blog: <a href="https://bbf.digital">BBF.DIGITAL</a></p>
        </div>
    </footer>
    <p style="color: red;font-size:12px;text-align: center">NOTE : This is system generated invoice and does not require physical signature.</p>
</body>

</html>
