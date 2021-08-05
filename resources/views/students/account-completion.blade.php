<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="GEs">
    <meta name="author" content="GES">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GES</title>


    <!-- Favicon -->
    <link rel="icon" href="{{ URL::asset('assets/img/brand/favicon.png') }}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
    <!-- Page plugins -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/animate.css/animate.min.css') }}">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{  URL::asset('assets/css/argon.min9f1e.css?v=1.1.0') }}" type="text/css">
    <!-- Custom CSS -->
    @yield('custom-styles')
</head>

<body>
<!-- Main content -->
<div class="main-content" id="panel">
    <!-- Topnav -->
    @include('components.topnav')
    <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Account Completion</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <h3 class="mb-0">Your Account Has To Be Completed</h3>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                        @if(Auth::user()->email_verified_at == null)
                            Kindly Verify Email Clicking on the link in it.
                        @else
                            @if($account_info == null)
                                <h3>You haven't made any enrollments yet. Kindly make an enrollment of the institute you belong to</h3>
                                <div class="well">
                                    <form action="/student/request-enrollment" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="institute_code">Enter Institute Code : </label>
                                            <input
                                            class="form-control form-control-lg"
                                            type="text"
                                            minlength="4"
                                            maxlength="4"
                                            autocomplete="off"
                                            id="institute_code"
                                            oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);"
                                            style="width: 6rem!important;text-align:center;"
                                            >
                                            <p class="text-sm text-bold" id="institute_code_message"></p>
                                            <div id="institute_info" class="form-group"></div>
                                            <input type="hidden" name="institute_id" id="institute_id">
                                            <?php //$institutes = \App\Institute::all(); ?>
                                            <!-- <select name="institute_id" id="institute" class="form-control">
                                                {{--@foreach($institutes as $institute)
                                                    <option value="{{$institute->institute_id}}">{{ \App\User::where('id', '=', $institute->institute_user_id)->first()->name }}</option>
                                                @endforeach--}}
                                            </select> -->
                                        </div>

                                        <div class="form-group">
                                            <label for="course">Courses :</label>
                                            <select name="course_id" id="course" class="form-control"></select>
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary form-control-alternative" value="Submit">
                                        </div>
                                    </form>
                                </div>
                            @else
                                @if($account_info->enrollment_status == 0)
                                        <h3>Your Enrollment Request Is Still Not Verified By The Institute. Kindly Contact The Institute.</h3>
                                @else
                                    @if($account_info->enrollment_status == -1)
                                        <h3>Your Enrollment Request Is For The Course Has Been Rejected By The Institute. Kindly Try Again Or Contact The Institute.</h3>
                                    @elseif($account_info->enrollment_status == 3)
                                        <h3>Your Enrollment Request Is Blocked For The Course By The Institute. Kindly Don't repeat the same Enrollment Request and Pick another Course of Institute Or another Institute</h3>
                                    @endif
                                    <div class="well">
                                        <form action="/student/request-enrollment" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="institute_code">Enter Institute Code : </label>
                                                <input
                                                class="form-control form-control-lg"
                                                type="text"
                                                minlength="4"
                                                maxlength="4"
                                                autocomplete="off"
                                                id="institute_code"
                                                oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);"
                                                style="width: 6rem!important;text-align:center;"
                                                >
                                                <p class="text-sm text-bold" id="institute_code_message"></p>
                                                <div id="institute_info" class="form-group"></div>
                                                <input type="hidden" name="institute_id" id="institute_id">
                                                <?php //$institutes = \App\Institute::all(); ?>
                                                <!-- <select name="institute_id" id="institute" class="form-control">
                                                    {{--@foreach($institutes as $institute)
                                                        <option value="{{$institute->institute_id}}">{{ \App\User::where('id', '=', $institute->institute_user_id)->first()->name }}</option>
                                                    @endforeach--}}
                                                </select> -->
                                            </div>

                                            <div class="form-group">
                                                <label for="course">Courses :</label>
                                                <select name="course_id" id="course" class="form-control"></select>
                                            </div>

                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary form-control-alternative" value="Submit">
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            @endif
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Argon Scripts -->
    <!-- Core -->

    <script src="{{ URL::asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
    {{--Notification--}}
    <script src="{{ URL::asset('assets/vendor/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <!-- Argon JS -->
    <script src="{{ URL::asset('assets/vendor/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/chart.js/dist/Chart.extension.js') }}"></script>




    @yield('custom-script')
    <script src="{{ URL::asset('assets/js/argon.min9f1e.js') }}"></script>

    <script>
        let getCourses = function(institute_id) {
            $.ajax({
                type: 'GET',
                url: '/get-courses/' + institute_id,
                success: function(response) {
                    response = JSON.parse(response);
                    response.forEach(function (item) {
                        let tag = "<option value=" + item.course_id + ">" + item.course_name +"</option>";
                        $("#course").append(tag);
                    });
                }
            });
        };

        let getInstitute = function(institute_code) {
            return $.ajax({
                type: 'GET',
                url: '/get-institute/' + institute_code,
                // success: function(response) {
                //     return response;
                // }
            });
        }

        $('#institute_code').on("input", function() {
            let institute_code = $(this).val();
            $("#course").html("");
            $("institute_id").val("");
            if(institute_code.length < 4) {
                $('#institute_code_message').html("Invalid Code");
                $('#institute_code_message').removeClass("text-success");
                $('#institute_code_message').addClass("text-danger");
                $('#institute_info').html("");
            } else {
                getInstitute(institute_code).then(response => {
                    if(response == "-1") {
                        $('#institute_code_message').html("No such Institute with given code");
                        $('#institute_code_message').removeClass("text-success");
                        $('#institute_code_message').addClass("text-danger");
                    } else {
                        $('#institute_code_message').html("Valid Code");
                        $('#institute_code_message').removeClass("text-danger");
                        $('#institute_code_message').addClass("text-success");
                        $("#institute_id").val(response.id);
                        $('#institute_info').html(`<p><strong>Institute Name : </strong> ${response.name} </p><p><strong>Contact No.: </strong>${response.contact_no}</p><p><strong>Address  : </strong>${response.address}</p><p><strong>City : </strong>${response.city}</p>`);
                        getCourses(response.id);
                    }
                });
            }

            // getCourses(institute_id);
        });
    </script>
    @if(session()->has('type'))
        <script>
            $.notify({
                // options
                title: '<h4 style="color:white">{{ session('title') }}</h4>',
                message: '{{ session('message') }}',
            },{
                // settings
                type: '{{ session('type') }}',
                allow_dismiss: true,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 3000,
                timer: 1000,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                }
            });
        </script>
    @endif

</body>


</html>
