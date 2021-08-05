@extends('layouts.base')

@section('custom-styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
<style>
    .ql-editor {
    font-family: inherit;
    margin: 0;
    margin-top: 1px;
    padding: 0;
    width: 100%!important;
    height: 100%!important;
    border-color: white;
    border-width: 0;
    width: 10rem;
    color: #525f7f;
    text-align: left;
    }
    .ql-editor p {
    font-size: .8125rem;
    }
</style>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/student"><i class="ni ni-ruler-pencil"></i></a></li>
<li class="breadcrumb-item"><a href="/student">My Tests</a></li>
<li class="breadcrumb-item active" aria-current="page">Completed Tests</li>
@endsection

@section('page-content')
<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header">
                <h3 class="mb-0">Completed Tests</h3>
            </div>
            <!-- Card body -->
            <div class="card-body">
                    <div class = "text-lg-center    ">
                        <div id="countdownExample" >
                            <div class="values"></div>
                        </div>
                    </div>
                    @foreach($questions as $question)
                        @php($isCorrect = -1)
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title mb-2 p-0">
                                        <div>{!!$question['question_text']!!}</div>
                                    </div>
                                    <div class="card-text row mb-2">
                                        <div class="col-6">
                                            @if($question['options'][0]['is_correct'] == 1)
                                                <div class="alert border-success p-0 mt-3" style="border-width: medium;">
                                                    {!! $question['options'][0]['option_text'] !!}
                                                </div>
                                                @if($question['options'][0]['is_correct'] == 1 and $question['selected_option_id'] == $question['options'][0]['option_id'])
                                                    @php($isCorrect = 1)
                                                @endif
                                            @elseif($question['options'][0]['is_correct'] == 0 and $question['selected_option_id'] == $question['options'][0]['option_id'])
                                                @php($isCorrect = 0)
                                                <div class="alert border-danger p-0 mt-3" style="border-width: medium;"">
                                                    {!! $question['options'][0]['option_text'] !!}
                                                </div>
                                            @else
                                                <div class="alert">
                                                    {!! $question['options'][0]['option_text'] !!}
                                                </div>
                                            @endif

                                        </div>
                                        <div class="col-6">
                                            @if($question['options'][1]['is_correct'] == 1)
                                                <div class="alert border-success p-0 mt-3" style="border-width: medium;">
                                                    {!! $question['options'][1]['option_text'] !!}
                                                </div>
                                                @if($question['options'][1]['is_correct'] == 1 and $question['selected_option_id'] == $question['options'][1]['option_id'])
                                                    @php($isCorrect = 1)
                                                @endif
                                            @elseif($question['options'][1]['is_correct'] == 0 and $question['selected_option_id'] == $question['options'][1]['option_id'])
                                                @php($isCorrect = 0)
                                                <div class="alert border-danger p-0 mt-3" style="border-width: medium;">
                                                    {!! $question['options'][1]['option_text'] !!}
                                                </div>
                                            @else
                                                <div class="alert" >
                                                    {!! $question['options'][1]['option_text'] !!}
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            @if($question['options'][2]['is_correct'] == 1)
                                                <div class="alert border-success  p-0 mt-3" style="border-width: medium;" >
                                                    {!! $question['options'][2]['option_text'] !!}
                                                </div>
                                                @if($question['options'][2]['is_correct'] == 1 and $question['selected_option_id'] == $question['options'][2]['option_id'])
                                                    @php($isCorrect = 1)
                                                @endif
                                            @elseif($question['options'][2]['is_correct'] == 0 and $question['selected_option_id'] == $question['options'][2]['option_id'])
                                                @php($isCorrect = 0)
                                                <div class="alert border-danger p-0 mt-3" style="border-width: medium;">
                                                    {!! $question['options'][2]['option_text'] !!}
                                                </div>
                                            @else

                                                <div class="alert" >
                                                    {!! $question['options'][2]['option_text'] !!}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            @if($question['options'][3]['is_correct'] == 1)
                                                <div class="alert border-success p-0 mt-3" style="border-width: medium;">
                                                    <label>{!! $question['options'][3]['option_text'] !!}</label>
                                                </div>
                                                @if($question['options'][3]['is_correct'] == 1 and $question['selected_option_id'] == $question['options'][3]['option_id'])
                                                    @php($isCorrect = 1)
                                                @endif
                                            @elseif($question['options'][3]['is_correct'] == 0 and $question['selected_option_id'] == $question['options'][3]['option_id'])
                                                @php($isCorrect = 0)
                                                <div class="alert border-danger p-0 mt-3" style="border-width: medium;">
                                                    {!! $question['options'][3]['option_text'] !!}
                                                </div>
                                            @else
                                                <div class="alert" >
                                                    {!! $question['options'][3]['option_text'] !!}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        @if($isCorrect == 0)
                                            <div>Wrong!!</div>
                                        @elseif($isCorrect == 1)
                                            <div>Correct</div>
                                        @else
                                            <div>Not Attempted</div>
                                        @endif
                                        <p>Explanation</p>
                                        {!! $question['question_answer_explanation'] !!}
                                    </div>
                                </div>
                            </div>
                    @endforeach
            </div>
        </div>
    </div>
</div>

@endsection


@section ('custom-script')
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>
<script>
    $('.card-footer div').each(function (index) {
        let parent = $(this).parent().parent()
        if($(this).text() == "Wrong!!")
        {
            $(this).parent().addClass('border-danger')
            parent.addClass('border border-danger').css('border-radius', '0.375rem');
        }
        else if($(this).text() == "Correct")
        {
            $(this).parent().addClass('border-success')
            parent.addClass('border border-success').css('border-radius', '0.375rem');
        }
        else
        {
            $(this).parent().addClass('border-primary')
            parent.addClass('border border-primary').css('border-radius', '0.375rem');
        }
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
@endsection

