@section('header')
<div class="header pb-6 d-flex align-items-center"
    style="min-height: 500px; background-image: url(../../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
    <!-- Mask -->
    <span class="mask bg-gradient-default opacity-8"></span>
    <!-- Header container -->
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="col-lg-7 col-md-10">
                 <h1 class="display-2 text-white">Hey {{ $student->name }}</h1>
                <p class="text-white mt-0 mb-5">This is your profile page.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-content')
<div class="row">
    <div class="col-xl-4 order-xl-2">
        <div class="card card-profile">
            <img src="../../assets/img/theme/img-1-1000x600.jpg" alt="Image placeholder" class="card-img-top">
            <div class="row justify-content-center">
                <div class="col-lg-3 order-lg-2">
                    <div class="card-profile-image">
                        <a href="#">
                         <img src="{{$student->photo}}" class="rounded-circle">
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-10">
                <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center">
                                <div>
                                    <span class="heading hide"></span>
                                    <span class="description"></span>
                                </div>
                                <div>
                                    <span class="heading hide"></span>
                                    <span class="description hide"></span>
                                </div>

                            </div>
                        </div>
                    </div>

                <div class="text-center" style="margin=20 0 0 0 px;">
                    <h5 class="h3"> {{ $student->name }}</h5>
                    <h5 class="h5"> <strong>Contact Number : </strong>{{$student->contact_no}}</h5>
                    <h5 class="h5"> <strong>Institute : </strong>{{$courses[0]->name}}</h5>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"> Courses </div>
            <div class="card-body">
                <ul>
                    @foreach($courses as $course)
                        <li>{{$course->course_name}}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn btn-primary btn-sm float-right" onclick="$('#add-enrollment').toggleClass('d-none');"><span><i class="fa fa-plus"></i></span></button>
                <div class="clearfix"></div>
                <div id="add-enrollment" class="d-none">
                    @if(sizeof($unenrolledCourses) > 0)
                    <form action="/student/enrollment-request/" type="POST">
                        @csrf
                        <input type="hidden" name="institute_id" value="{{$courses[0]->institute_id}}">
                        @foreach ($unenrolledCourses as $c)
                            <div class="custom-control custom-checkbox mt-1 mb-1">
                                <input type="checkbox" class="custom-control-input" value="{{$c->course_id}}" id="course{{$c->course_id}}" name="course_id[]">
                                <label class="custom-control-label" for="course{{$c->course_id}}">{{$c->course_name}}</label>
                            </div>
                        @endforeach
                        <input type="submit" class="btn btn-info btn-sm" value="Add Courses">
                    </form>
                    @else
                    <small class="text-info"> No Other Courses Available </small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <form action="/staff/updateProfile" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Profile </h3>
                    </div>
                    <div class="col-4 text-right">
                        <button type="submit" class="btn btn-outline-primary">Update</button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <h6 class="heading-small text-muted mb-4">User information</h6>
                <div class="pl-lg-4">
                    <div>
                        <div>
                            <div class="form-group">
                                <label class="form-control-label" for="name">Name</label>
                                <input autocomplete="off" type="text" id="name" name="name" class="form-control" placeholder="Name" value = {{ $student->name }}>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div>
                            <div class="form-group">
                                <label class="form-control-label" for="email">Email address</label>
                                <input autocomplete="off" type="email" id="email" name="email" class="form-control" value="{{$student->email}}">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div>
                            <div class="form-group">
                                <label class="form-control-label" for="contact_no">Contact No</label>
                                <input autocomplete="off" type="text" id="contact_no" name="contact_no" class="form-control" value="{{ $student->contact_no }}">
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" />
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">Contact information</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-control-label" for="address">Address</label>
                                <input autocomplete="off" id="address" class="form-control" name="address" placeholder="Home Address" value="{{ $student->address }}" type="text">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="city">City</label>
                                <input autocomplete="off" type="text" id="city" name="city" class="form-control" placeholder="City" value="{{ $student->city }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection



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
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GES</title>


    <!-- Favicon -->
    <link rel="icon" href="{{ URL::asset('assets/img/brand/favicon.png') }}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css') }}"
        type="text/css">
    <!-- Page plugins -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/animate.css/animate.min.css') }}">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{  URL::asset('assets/css/argon.min9f1e.css?v=1.1.0') }}" type="text/css">
    <!-- Custom CSS -->
    @yield('custom-styles')
</head>

<body>


    <!-- Sidenav -->
    @include('components.sidenav')

    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        @include('components.topnav')

        <!-- Header -->
        @yield('header')
        <!-- Page content -->
        <div class="container-fluid mt--6">
            @yield('page-content')
            <!-- Footer -->
            @include('components.footer')
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
</body>


</html>



@section ('custom-script')
@if(session()->has('type'))
<script>
    $.notify({
        // options
        title: '<h4 style="color:white">{{ session('
        title ') }}</h4>',
        message: '{{ session('
        message ') }}',
    }, {
        // settings
        type: '{{ session('
        type ') }}',
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
@endsection
