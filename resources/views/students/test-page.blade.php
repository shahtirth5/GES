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
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css') }}"
        type="text/css">
    <!-- Page plugins -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/animate.css/animate.min.css') }}">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{  URL::asset('assets/css/argon.min9f1e.css?v=1.1.0') }}" type="text/css">

    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/quilljs/css/quill.bubble.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/quilljs/css/quill.snow.css')}}">
    <!-- Custom CSS -->
    @yield('custom-styles')
</head>

<body>
    <!-- Sidenav -->
    <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="sidenav-header d-flex align-items-center">
                <a class="navbar-brand" href="#">
                    <h1>GES</h1>
                </a>
                <div class="ml-auto">
                    <!-- Sidenav toggler -->
                    <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin"
                        data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="navbar-nav">
                        @if($message == 'success')
                        @php
                        $i=1;
                        @endphp
                        @foreach($questions as $question)
                        <li class='nav-item question-nav' rel="{{$question['question_id']}}">
                            <a class="nav-link @if($i == 1) active @endif" style="cursor: pointer;">
                                Q{{$i++}} ({{$question['subject_name']}})
                                <span class="nav-link-text" id="icon">
                                    @if($question['status'] == 0)
                                    <i class="text-danger fas fa-exclamation-circle"></i>
                                    @elseif($question['status'] == 1)
                                    <i class="text-success fas fa-check-circle"></i>
                                    @elseif($question['status'] == 2)
                                    <i class="text-warning fas fa-flag"></i>
                                    @endif
                                </span>
                            </a>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Navbar links -->
                    <ul class="navbar-nav align-items-center ml-md-auto">
                        <li class="nav-item d-xl-none">
                            <!-- Sidenav toggler -->
                            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
                                data-target="#sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item d-sm-none">
                            <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                                <i class="ni ni-zoom-split-in"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="ni ni-bell-55"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden">
                                <!-- Dropdown header -->
                                <div class="px-3 py-3">
                                    {{--                            <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">{{ Auth::user()->unreadNotifications->count() }}</strong>
                                    notifications.</h6>--}}
                                </div>
                                <a href="/notification/mark-all-as-read"
                                    class="dropdown-item text-center text-primary font-weight-bold py-3">Mark All
                                    Read</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="ni ni-ungroup"></i>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default dropdown-menu-right">
                                <div class="row shortcuts px-4">
                                    <a href="#!" class="col-4 shortcut-item">
                                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                                            <i class="ni ni-calendar-grid-58"></i>
                                        </span>
                                        <small>Calendar</small>
                                    </a>
                                    <a href="#!" class="col-4 shortcut-item">
                                        <span class="shortcut-media avatar rounded-circle bg-gradient-orange">
                                            <i class="ni ni-email-83"></i>
                                        </span>
                                        <small>Email</small>
                                    </a>
                                    <a href="#!" class="col-4 shortcut-item">
                                        <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                                            <i class="ni ni-credit-card"></i>
                                        </span>
                                        <small>Payments</small>
                                    </a>
                                    <a href="#!" class="col-4 shortcut-item">
                                        <span class="shortcut-media avatar rounded-circle bg-gradient-green">
                                            <i class="ni ni-books"></i>
                                        </span>
                                        <small>Reports</small>
                                    </a>
                                    <a href="#!" class="col-4 shortcut-item">
                                        <span class="shortcut-media avatar rounded-circle bg-gradient-purple">
                                            <i class="ni ni-pin-3"></i>
                                        </span>
                                        <small>Maps</small>
                                    </a>
                                    <a href="#!" class="col-4 shortcut-item">
                                        <span class="shortcut-media avatar rounded-circle bg-gradient-yellow">
                                            <i class="ni ni-basket"></i>
                                        </span>
                                        <small>Shop</small>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav align-items-center ml-auto ml-md-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        <img alt="" src="{{ Auth::user()->photo }}">
                                    </span>
                                    <div class="media-body ml-2 d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user()->first_name }}
                                            {{ Auth::user()->last_name }}</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome!</h6>
                                </div>
                                <a href="/profile" class="dropdown-item">
                                    <i class="ni ni-single-02"></i>
                                    <span>My profile</span>
                                </a>
                                <a href="/timeline" class="dropdown-item">
                                    <i class="ni ni-calendar-grid-58"></i>
                                    <span>Activity</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="/logout" class="dropdown-item">
                                    <i class="ni ni-user-run"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        {{--End of Top Nav--}}

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
            <div class="row">
                <div class="col">
                    <div class="card">
                        <!-- Card header -->
                        {{--                    <div class="card-header">--}}
                        {{--                        <h3 class="mb-0">Add Chapters</h3>--}}
                        {{--                    </div>--}}
                        <!-- Card body -->
                        <div class="card-body">
                            @if($message == 'success' and !session()->has('testEnded'))
                            <div class="alert alert-primary" role="alert">
                                Please mark submit after selecting the Option for Successful Submission
                            </div>
                            <div class="text-lg-center mb-4">
                                <div id="countdownExample">
                                    <div class="values"></div>
                                </div>
                            </div>
                            @foreach($questions as $question)
                            <form action="{{url('institute/questions/add-question-query')}}" class="question-div"
                                data-question="{{$question['question_id']}}" id="{{$question['question_id']}}"
                                method="post">
                                @csrf
                                <div>
                                    <div>
                                        <div class="card-title mb-2 ">
                                            <div>
                                                {!! $question['question_text'] !!}
                                            </div>

                                            <div class="m-2 float-right questionStatusSVG{{$question['question_id']}}"
                                                style="z-index: -1">
                                                @if($question['status'] == 0)
                                                <i class="text-danger fas fa-exclamation-circle"></i>
                                                @elseif($question['status'] == 1)
                                                <i class="text-success fas fa-check-circle"></i>
                                                @elseif($question['status'] == 2)
                                                <i class="text-warning fas fa-flag"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="card-text mb-2">
                                            <div class="mb-1">
                                                @if($question['options'][0]['option_id'] ==
                                                $question['selected_option_id'])
                                                @php $checked = 'checked'@endphp
                                                @else
                                                @php $checked = ''@endphp
                                                @endif
                                                <div class="row">
                                                    <div class="ml-3 custom-control custom-radio"
                                                        data-option="{{$question['options'][0]['option_id']}}">
                                                        <input type="radio"
                                                            data-option-question-id="{{$question['question_id']}}"
                                                            class="custom-control-input" {{$checked}}
                                                            value="{{$question['options'][0]['option_id']}}"
                                                            id="option_id:{{$question['options'][0]['option_id']}}"
                                                            name="questionOption">
                                                        <label class="custom-control-label"
                                                            for="option_id:{{$question['options'][0]['option_id']}}"></label>
                                                    </div>
                                                    <div class="col-11">
                                                        {!! $question['options'][0]['option_text'] !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-1">
                                                @if($question['options'][1]['option_id'] ==
                                                $question['selected_option_id'])
                                                @php $checked = 'checked'@endphp
                                                @else
                                                @php $checked = ''@endphp
                                                @endif
                                                <div class="row">
                                                    <div class="ml-3 custom-control custom-radio"
                                                        data-option="{{$question['options'][1]['option_id']}}">
                                                        <input type="radio"
                                                            data-option-question-id="{{$question['question_id']}}"
                                                            class="custom-control-input" {{$checked}}
                                                            value="{{$question['options'][1]['option_id']}}"
                                                            id="option_id:{{$question['options'][1]['option_id']}}"
                                                            name="questionOption">
                                                        <label class="custom-control-label"
                                                            for="option_id:{{$question['options'][1]['option_id']}}"></label>
                                                    </div>
                                                    <div class="col-11">
                                                        {!! $question['options'][1]['option_text'] !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-1">
                                                @if($question['options'][2]['option_id'] ==
                                                $question['selected_option_id'])
                                                @php $checked = 'checked'@endphp
                                                @else
                                                @php $checked = ''@endphp
                                                @endif
                                                <div class="row">
                                                    <div class="ml-3 custom-control custom-radio"
                                                        data-option="{{$question['options'][2]['option_id']}}">
                                                        <input type="radio"
                                                            data-option-question-id="{{$question['question_id']}}"
                                                            class="custom-control-input" {{$checked}}
                                                            value="{{$question['options'][2]['option_id']}}"
                                                            id="option_id:{{$question['options'][2]['option_id']}}"
                                                            name="questionOption">
                                                        <label class="custom-control-label"
                                                            for="option_id:{{$question['options'][2]['option_id']}}"></label>
                                                    </div>
                                                    <div class="col-11">
                                                        {!! $question['options'][2]['option_text'] !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-1">
                                                @if($question['options'][3]['option_id'] ==
                                                $question['selected_option_id'])
                                                @php $checked = 'checked'@endphp
                                                @else
                                                @php $checked = ''@endphp
                                                @endif
                                                <div class="row">
                                                    <div class="ml-3 custom-control custom-radio"
                                                        data-option="{{$question['options'][3]['option_id']}}">
                                                        <input type="radio"
                                                            data-option-question-id="{{$question['question_id']}}"
                                                            class="custom-control-input" {{$checked}}
                                                            value="{{$question['options'][3]['option_id']}}"
                                                            id="option_id:{{$question['options'][3]['option_id']}}"
                                                            name="questionOption">
                                                        <label class="custom-control-label"
                                                            for="option_id:{{$question['options'][3]['option_id']}}"></label>
                                                    </div>
                                                    <div class="col-11">
                                                        {!! $question['options'][3]['option_text'] !!}
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="col-6">
                                                    @if($question['options'][2]['option_id'] == $question['selected_option_id'])
                                                        @php $checked = 'checked'@endphp
                                                    @else
                                                        @php $checked = ''@endphp
                                                    @endif
                                                    <div class="custom-control custom-radio" data-option = "{{$question['options'][2]['option_id']}}">
                                            <input type="radio" data-option-question-id="{{$question['question_id']}}"
                                                class="custom-control-input" {{$checked}}
                                                value="{{$question['options'][2]['option_id']}}"
                                                id="option_id:{{$question['options'][2]['option_id']}}"
                                                name="questionOption"> --}}
                                            {{-- <label class="custom-control-label" for="option_id:{{$question['options'][2]['option_id']}}">{!!
                                            $question['options'][2]['option_text'] !!}</label> --}}
                                            {{-- </div>
                                                </div> --}}
                                        </div>
                                        <div class="row mb-2">

                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-primary"
                                                data-option-question-id="{{$question['question_id']}}"
                                                onclick="btnSubmitClicked(event);"> Submit </button>
                                            <button type="button" class="btn btn-warning"
                                                data-option-question-id="{{$question['question_id']}}"
                                                onclick="btnTagClicked(event);">@if($question['status'] == '2')Untag <i
                                                    class="far fa-flag"></i>@else Tag <i
                                                    class="far fa-flag"></i>@endif</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-option-question-id="{{$question['question_id']}}"
                                                onclick="btnClearClicked(event);">Clear</button>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-lg btn-danger" onClick="finishTest();">Finish</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @endforeach
                            {{-- <div class='float-right'>
                                <button type="button" class="btn btn-outline-info" onclick="showPrev();" id="show-prev"><i class='fa fa-angle-left'></i></button>
                                <button type="button" class="btn btn-outline-info" onclick="showNext();" id="show-next"><i class='fa fa-angle-right'></i></button>
                            </div> --}}

                            @elseif($message == 'Fail1')
                            <div class="alert alert-danger">
                                <strong>Sorry!</strong> Test Attempting time is over now.
                            </div>
                            @elseif($message == 'Fail2')
                            <div class="alert alert-danger">
                                <strong>Sorry!</strong> This Test is not for you.
                            </div>
                            @elseif($message == 'Fail3')
                            <div class="alert alert-danger">
                                <strong>Sorry!</strong> You are not enrolled for the test.
                            </div>
                            @elseif($message == 'Fail4')
                            <div class="alert alert-danger">
                                You have already attempted the test.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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
    <script src="{{ URL::asset('assets/vendor/easytimer-master/dist/easytimer.min.js') }}"></script>

    @yield('custom-script')
    <script src="{{ URL::asset('assets/js/argon.min9f1e.js') }}"></script>
    <script>
        var question_id;
    var allQuestions = $('.question-div');
    var data_questions = [];
    var i = 0;
    $('.question-div').each(function () {
        data_questions[i++] = $(this).attr('data-question');
    });
    var firstQuestion = data_questions[0];
    var visibleQuestion = firstQuestion;
    console.log($('.question-div[data-question ="'+visibleQuestion+'"]'));

    function showQuestion() {
        $('.question-div').hide();
        $('.question-div[data-question ="'+visibleQuestion+'"]').show();
        question_id = $('form:visible').attr('data-question');
        $('.question-nav[rel = '+question_id+']').children('a').addClass('active');
        $('.question-nav[rel = '+question_id+']').siblings('li').children('a').removeClass('active');
    }
    showQuestion();
    function showNext() {
        // console.log(visibleQuestion);
        if(visibleQuestion == allQuestions.length)
        {
            visibleQuestion = 1;
        }
        else {
            visibleQuestion++;
        }
        showQuestion();
    }
    function showPrev() {
        // console.log(visibleQuestion);
        if(visibleQuestion == firstQuestion)
        {
            visibleQuestion = allQuestions.length;
        }
        else {
            visibleQuestion--;
        }
        showQuestion();
    }


    //Script for Radio Button Change(Status , Tag)
    function btnSubmitClicked(event) {
        let question_id = event.target.getAttribute('data-option-question-id');
        let test_session_id = {{ $test_session_id }};
        let status = 1;
        let optionSelected = $('input[type = radio][name=questionOption][data-option-question-id = '+question_id+']:checked').val();
        if(optionSelected == null)
        {
            return;
        }
        updateTestSelectedQuestion(question_id , test_session_id , optionSelected , status);
    }

    function btnTagClicked(event) {
        let question_id = event.target.getAttribute('data-option-question-id');
        let test_session_id = {{ $test_session_id }};
        let optionSelected = $('input[type = radio][name=questionOption][data-option-question-id = '+question_id+']:checked').val();
        // console.log(event.target);
        if(event.target.innerText == 'Tag ') {
            event.target.innerHTML = "Untag <i class='far fa-flag'></i>";
            let status = 2;
            updateTestSelectedQuestion(question_id , test_session_id , optionSelected , status);
        } else if(event.target.innerText == 'Untag ') {
            event.target.innerHTML = "Tag <i class='fa fa-flag'></i>";
            if(optionSelected == null) {
                status = 0;
            } else {
                status = 1;
            }
            updateTestSelectedQuestion(question_id , test_session_id , optionSelected , status);
        }
    }

    function btnClearClicked(event) {
        let question_id = event.target.getAttribute('data-option-question-id');
        let test_session_id = {{ $test_session_id }};
        let optionSelected = $('input[type = radio][name=questionOption][data-option-question-id = '+question_id+']:checked');
        optionSelected.prop('checked', false);
        let status = 0;
        updateTestSelectedQuestion(question_id , test_session_id , "null" , status);
    }

    function updateTestSelectedQuestion(question_id , test_session_id , optionSelected , status) {
        if(optionSelected == null) {
            optionSelected = -1;
        }
        console.log(question_id+"+"+test_session_id+"+"+optionSelected+"+"+status);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/student/test/updateTestSelectionQuestion',
            data:{
                'question_id' : question_id,
                'test_session_id' : test_session_id,
                'optionSelected' : optionSelected,
                'status' : status,

            },
            success: function(data){
                let iconDiv = $('div .questionStatusSVG'+question_id);
                let iconNav = $('.question-nav[rel = '+question_id+'] span');
                console.log(iconDiv);
                console.log(iconNav);
                let status_icon = '';
                if(status == 0)
                {
                    status_icon = '<i class="text-danger fas fa-exclamation-circle"></i>';
                }
                else if(status == 1) {
                    status_icon = '<i class="text-success fas fa-check-circle"></i>';
                }
                else if(status == 2){
                    status_icon = '<i class="text-warning fas fa-flag"></i>';
                }
                iconDiv.html(status_icon);
                iconNav.html(status_icon);
            },
            error: function(){
                console.log('Error!!');
            },
        });
    }

    $('.question-nav').on('click' , function () {
        var target = $(this).attr('rel');
        $(this).children('a').addClass('active');
        $("#"+target).show().siblings("form").hide();
        $(this).siblings('li').children('a').removeClass('active');
        visibleQuestion = target;
    });



    //Script For Timer
    var timer = new easytimer.Timer();
    var tenSec = 0;
    var test_duration = {{ $timeLeft }}
    // var test_duration = 20;
    if(test_duration <= 0)
    {
        endTest({{$test_session_id}});
    }
    timer.start({
        countdown: true,
        startValues: {seconds: test_duration}});
    $('#countdownExample .values').html(timer.getTimeValues().toString());
    timer.addEventListener('secondsUpdated', function (e) {
        tenSec++;
        if (tenSec == 5)
        {
            tenSec = 0;
            updateDatabase();
        }
        $('#countdownExample .values').html(timer.getTimeValues().toString());
    });
    timer.addEventListener('targetAchieved', function (e) {
        endTest({{$test_session_id}});
        $('#countdownExample .values').html('Test has Ended');

    });
    function updateDatabase() {
        $.ajax({
            type: 'GET',
            url: '/student/test/{{ $student_id }}/{{ $test_id }}',
            success: function(data){

            },
            error: function(){
                console.log('Error!!');
            },
        });
    }


    // Finish test
    function finishTest() {
        endTest({{$test_session_id}});
    }

    function endTest(test_session_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/student/test/endTest',
            data:{
                'test_session_id' : test_session_id,
            },
            success: function(data){
                console.log(data)
                window.location = '/student/dashboard';
            },
            error: function(){
                console.log('Error!!');
            },
        });
    }



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
