<!--
MIT License

Copyright (c) 2019 [Updivision](https://updivision.com)  [Creative Tim](https://www.creative-tim.com)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
-->

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
        <meta name="description" content="GES">
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


        <!-- Sidenav -->
        @include('components.sidenav')

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
{{--                                <h6 class="h2 text-white d-inline-block mb-0">Default</h6>--}}
                                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                        @yield('breadcrumb')
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-6 col-5 text-right">
                                @yield('actions')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
