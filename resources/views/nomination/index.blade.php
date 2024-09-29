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
    <title>Registration Form | {{ $theme->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/' . $theme->favicon) }}" type="image/x-icon">
    <style>
        body {
            background-color: #f2f2f2;
            background-image: url('{{ asset('assets/img/' . $theme->background) }}');
        }

        .container {
            max-width: 700px;
            padding: 20px;
            margin: 40px auto;
            background-color: #f2f2f2;
            border-radius: 15px;
            /* box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.1), -10px -10px 20px rgba(255, 255, 255, 0.5); */
        }

        .border {
            border-radius: 15px;
        }

        .form-control {
            background-color: #f2f2f2;
            border: none;
            border-radius: 10px;
            box-shadow: inset 6px 6px 6px rgba(0, 0, 0, 0.1), inset -6px -6px 6px rgba(255, 255, 255, 0.5);
        }

        .form-control:focus {
            outline: none;
            box-shadow: inset 4px 4px 4px rgba(0, 0, 0, 0.1), inset -4px -4px 4px rgba(255, 255, 255, 0.5);
        }

        .btn-primary {
            background-color: #65a9e6;
            border-color: #65a9e6;
            border-radius: 10px;
            box-shadow: 6px 6px 6px rgba(0, 0, 0, 0.1), -6px -6px 6px rgba(255, 255, 255, 0.5);
        }

        .btn-primary:hover {
            background-color: #5593cd;
            border-color: #5593cd;
        }

        .card {
            background-color: #f2f2f2;
            border: none;
            border-radius: 15px;
            /* box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.1), -10px -10px 20px rgba(255, 255, 255, 0.5); */
        }

        .card-header {
            background-color: #f2f2f2;
            border-bottom: none;
        }

        .card-body {
            padding: 20px;
        }

        .card-footer {
            background-color: #f2f2f2;
            border-top: none;
            border-radius: 0 0 15px 15px;
        }

        h5 {
            color: #333;
        }

        label {
            color: #555;
        }

        .count {
            font-size: 10px;
            box-shadow: inset 6px 6px 6px rgba(0, 0, 0, 0.1), inset -6px -6px 6px rgba(255, 255, 255, 0.5);
            display: block;
            text-align: center;
            margin: 5px auto 20px !important;
            width: 30%;
            padding: 5px;
            border-radius: 15px;
        }
    </style>
</head>

<body>
    <div class="container shadow">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12">
                @if (env('SSLCZ_STORE_ID') === 'bangl6362104f9019c' && env('SSLCZ_STORE_PASSWORD') === 'bangl6362104f9019c@ssl')
                <p class="badge bg-success p-1">⚪ Test Mode</p>
                @else
                <!-- <p class="badge bg-danger p-1">⚪ Live</p> -->
                @endif

                <div class="card-header text-center">
                    <a href="{{ $theme->url }}">
                        <img width="150px" src="{{ asset('assets/img/' . $theme->logo) }}" alt="">
                    </a>
                    <div class="time py-1" id="countdown"></div>
                </div>
                <div class="card shadow">
                    @php
                    use Carbon\Carbon;
                    $time = Carbon::parse($theme->close);
                    $close = $time;
                    @endphp
                    @if ($form_type == 'store')
                    @if (Carbon::now() <= $close)
                        <div class="card-body">
                        @include('validate')
                        <form action="{{ route('form.store') }}" method="POST" class="was-validated">
                            @csrf
                            <u>
                                <h5 class="text-center text-uppercase">Secure Entry Pass</h5>
                            </u>
                            <div class="border p-3 shadow my-3">
                                <div class="mb-2">
                                    <label for="validationName" class="form-label">
                                        <b>Full Name <span class="text-danger">*</span></b>
                                    </label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name') }}" required>
                                    <div class="invalid-feedback text-uppercase">Enter Your Full Name</div>
                                </div>
                                <div class="mb-2">
                                    <label for="validationName" class="form-label">
                                        <b>Designation <span class="text-danger">*</span></b>
                                    </label>
                                    <input type="text" name="designation" class="form-control"
                                        value="{{ old('designation') }}" required>
                                    <div class="invalid-feedback text-uppercase">Enter Your Designation</div>
                                </div>
                                <div class="mb-2">
                                    <label for="validationPhone" class="form-label">
                                        <b>Organization <span class="text-danger">*</span></b>
                                    </label>
                                    <input list="organisations" type="text" name="organization"
                                        class="form-control" value="{{ old('organization') }}" required>
                                    <div class="invalid-feedback text-uppercase">Enter Your Organization Name
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="validationEmail" class="form-label">
                                        <b>Email <span class="text-danger">*</span></b>
                                    </label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email') }}" required>
                                    <div class="invalid-feedback text-uppercase">Enter Your Email</div>
                                </div>
                                <div class="mb-2">
                                    <label for="validationPhone" class="form-label">
                                        <b>Contact Number <span class="text-danger">*</span></b>
                                    </label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone') }}" required>
                                    <div class="invalid-feedback text-uppercase">Enter Your Contact Number</div>
                                </div>
                                <div class="mb-2">
                                    <label for="validationPhone" class="form-label">
                                        <b>Address <span class="text-danger">*</span></b>
                                    </label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ old('address') }}" required>
                                    <div class="invalid-feedback text-uppercase">Enter Your Address</div>
                                </div>
                            </div>
                            <!-- <u>
                                <h5 class="text-center text-uppercase">Team Member</h5>
                            </u>
                            <p class="text-center text-muted">Detail Information About Your Team Member</p>
                            <div class="border p-3 shadow my-3">
                                <div class="my-4">
                                    <div class="form-group order member-btn-opt">
                                        <div class="member-btn-opt-area">


                                        </div>
                                        <a id="add-new-member-button" class="btn btn-sm btn-info">Add member</a>
                                    </div>
                                </div>
                            </div> -->
                            <div class="mt-2 text-center">
                                <button style="width: 120px;" type="submit"
                                    class="btn btn-primary">Submit</button>
                            </div>

                        </form>
                </div>
                @else
                <div class="card-body">
                    <h3 class="text-center text-danger">
                        Nomination submission window is now closed.
                    </h3>
                </div>
                @endif
                @endif
                @if ($form_type == 'edit')
                @include('nomination.edit')
                @endif
            </div>
            <div class="card-footer text-muted text-center">
                @include('footer')
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-iv3foDG0pThGh1J7P3q+d01usFSuYfbzV4F0L24hka/2sRE+dSmwyaDQnPjTzdfu" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js"
        integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {

            let btn_no = $(".member-btn-opt-area .btn-section").length + 1;

            $("#add-new-member-button").click(function(e) {
                e.preventDefault();

                $(".member-btn-opt-area").append(`
    <div class="btn-section">
        <div class="d-flex justify-content-between">
            <b>Member ${btn_no}</b>
            <span style="cursor: pointer" class="bg-danger px-2 py-1 rounded text-white remove-btn">Remove <i class="fas fa-times"></i></span>
        </div>
        <input name="member_name[]" required class="form-control my-3" type="text"
                                                    placeholder="Team Member Name">
                                                <input name="member_designation[]" required class="form-control my-3" type="text"
                                                    placeholder="Team Member Designation">
                                                <input name="member_organization[]" required class="form-control my-3" type="text"
                                                    placeholder="Team Member Organization">
                                                <input name="member_contact[]" required class="form-control my-3" type="text"
                                                    placeholder="Team Member Contact">
                                                <input name="member_email[]" required class="form-control my-3" type="text"
                                                    placeholder="Team Member Email">
    </div>
    `);
                btn_no++;
            });

            $(document).on("click", ".remove-btn", function() {
                $(this).closest(".btn-section").remove();
                $(".member-btn-opt-area .btn-section").each(function(index) {
                    $(this).find("b:first-child").text(`Member ${index + 1}`);
                });
                btn_no = $(".member-btn-opt-area .btn-section").length + 1;
            });

            var sections = [{
                    id: "#background",
                    displayId: "#display_backgroundcount",
                    wordLeftId: "#backgroundword_left",
                    countId: "#backgroundcount",
                    maxLength: 50
                },
                {
                    id: "#objective",
                    displayId: "#display_objectivecount",
                    wordLeftId: "#objectiveword_left",
                    countId: "#objectivecount",
                    maxLength: 50
                },
                {
                    id: "#vision",
                    displayId: "#display_visioncount",
                    wordLeftId: "#visionword_left",
                    countId: "#visioncount",
                    maxLength: 50
                },
                {
                    id: "#idea",
                    displayId: "#display_ideacount",
                    wordLeftId: "#ideaword_left",
                    countId: "#ideacount",
                    maxLength: 150
                },
                {
                    id: "#execution",
                    displayId: "#display_executioncount",
                    wordLeftId: "#executionword_left",
                    countId: "#executioncount",
                    maxLength: 150
                },
                {
                    id: "#value_addition",
                    displayId: "#display_value_additioncount",
                    wordLeftId: "#value_additionword_left",
                    countId: "#value_additioncount",
                    maxLength: 75
                },
                {
                    id: "#result",
                    displayId: "#display_resultcount",
                    wordLeftId: "#resultword_left",
                    countId: "#resultcount",
                    maxLength: 100
                }
            ];

            sections.forEach(function(section) {
                $(section.id).on('input', function() {
                    var words = this.value.match(/\S+/g).length;
                    if (words > section.maxLength) {
                        var trimmed = $(this).val().split(/\s+/, section.maxLength).join(" ");
                        $(this).val(trimmed + " ");
                    } else {
                        $(section.displayId).text(words);
                        $(section.wordLeftId).text(section.maxLength - words);
                        if (words > 1) {
                            $(section.countId).removeClass('d-none');
                        } else if (words < 1) {
                            $(section.countId).addClass('d-none');
                        } else {
                            $(section.countId).addClass('d-none');
                        }
                    }
                });
            });
        });

        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    </script>
    @php
    $databaseDatetime = strtotime($theme->close);

    // Calculate time remaining
    $currentDatetime = time();
    $timeRemaining = $databaseDatetime - $currentDatetime;

    // Send the time remaining to the client-side JavaScript
    echo '<script>
        var timeRemaining = ' . $timeRemaining . ';
    </script>';
    @endphp
    @include('kill')
    <script>
        // Receive the time remaining value from the server-side code
        var timeRemaining = <?php echo $timeRemaining; ?>;

        // Function to update the countdown timer
        function updateCountdown() {
            if (timeRemaining <= 0) {
                // The countdown has expired, you can handle this case here
                if (timeRemaining == 0) {
                    location.reload();
                }
            } else {
                var hours = Math.floor(timeRemaining / 3600);
                var minutes = Math.floor((timeRemaining % 3600) / 60);
                var seconds = timeRemaining % 60;
                var h = hours > 1 ? 'hours ' : 'hour ';
                var hz = hours < 10 ? '0' : '';
                var m = minutes > 1 ? 'minutes ' : 'minute ';
                var mz = minutes < 10 ? '0' : '';
                var s = seconds > 1 ? 'seconds ' : 'second ';
                var sz = seconds < 10 ? '0' : '';
                if (timeRemaining <= 86400) {
                    document.getElementById('countdown').innerHTML = '<p>Time Remain: ' + '<span>' + hz + hours + ' ' +
                        ': ' + '</span>' + '<span>' + mz + minutes + ' ' + ': ' + '</span>' + '<span>' + sz + seconds +
                        '</p>';
                }
                timeRemaining--;
                setTimeout(updateCountdown, 1000); // Update the countdown every second
            }
        }

        // Start the countdown
        updateCountdown();
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
