@extends('layouts.base')

@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/tests"><i class="ni ni-ruler-pencil"></i></a></li>
    <li class="breadcrumb-item"><a href="/tests">Tests</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create A Test</li>
@endsection

@section('page-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Add Question</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form action="{{url('institute/questions/add-question-query')}}" method="post">
                        <div class="mb-2">
                            <label for="test_name" class="form-control-label">Test Name</label>
                            <input type="text" name="test_name" id="test_name" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label for="course" class="form-control-label">Course</label>
                            <select name="course_id" id="course" class="form-control">
                                @foreach($courses as $course)
                                    <option value="{{$course->course_id}}">{{$course->course_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="subjects">

                        </div>

                        {{-- <div class="mb-2">
                            <label for="chapter" class="form-control-label">Chapter</label>
                            <select name="chapter_id" id="chapter" class="form-control">

                            </select>
                        </div>

                        @csrf
                        <div class="mb-2">
                            <label for="question_text" class="form-control-label">Question</label>
                            <textarea class="form-control" name="question_text" id="question_text"></textarea>
                        </div>

                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="option_1" class="form-control-label">Option 1</label>
                                <textarea class="form-control" name="option_1" id="option_1"></textarea>
                            </div>
                            <div class="col-6">
                                <label for="option_2" class="form-control-label">Option 2</label>
                                <textarea class="form-control" name="option_2" id="option_2"></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="option_3" class="form-control-label">Option 3</label>
                                <textarea class="form-control" name="option_3" id="option_3"></textarea>
                            </div>
                            <div class="col-6">
                                <label for="option_4" class="form-control-label">Option 4</label>
                                <textarea class="form-control" name="option_4" id="option_4"></textarea>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="correct_option" class="form-control-label">Correct Option</label>
                            <select name="correct_option" id="correct_option" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label for="question_answer_explanation" class="form-control-label">Answer Explanation</label>
                            <textarea class="form-control" name="question_answer_explanation" id="question_answer_explanation"></textarea>
                        </div>

                        <div class="mb-2">
                            <label for="question_rating" class="form-control-label">Difficulty Rating</label>
                            <select name="question_rating" id="question_rating" class="form-control">
                                <option value="1">Easy</option>
                                <option value="2">Medium</option>
                                <option value="3">Hard</option>
                                <option value="4">Very Hard</option>
                            </select>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Add Question"> --}}

                    </form>
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

        var getSubjects = function(course_id) {
            $.ajax({
                type: 'GET',
                url: '/get-subjects/' + course_id,
                success: function(response) {
                    var html = "";
                    response = JSON.parse(response);
                    response.forEach((i, index) => {
                        html += "<div><label class='form-control-label mb-1 mr-3'>"+ i.subject_name +"</label><button onclick='addQuestionButtonClicked(event);' id='"+ i.subject_id +"' class='btn btn-info'>+</div>";
                        let tableMarkup ='<div class="table-responsive py-4 mb-4">'+
                                            '<table class="table table-flush" id="'+ i.subject_id + '-table">'+
                                            '    <thead class="thead-light">'+
                                            '    <tr>'+
                                            '        <th> Chapter </th>'+
                                            '        <th> Question </th>'+
                                            '        <th> Option 1 </th>'+
                                            '        <th> Option 2 </th>'+
                                            '        <th> Option 3</th>'+
                                            '        <th> Option 4 </th>'+
                                            '        <th> Answer </th>'+
                                            '        <th> Answer Explanation </th>'+
                                            '        <th> Difficulty Rating </th>'+
                                            '    </tr>'+
                                            '    </thead>'+
                                            '    <tfoot class="tfoot-light">'+
                                            '        <tr>'+
                                            '            <th> Chapter </th>'+
                                            '        </tr>'+
                                            '    </tfoot>'+
                                            '</table>'+
                                        '</div>';
                        html += tableMarkup;
                        html += `
                        <div class="modal fade" tabindex="-1" role="dialog" id="`+ i.subject_id+`-modal" style="width:90vw!important;">
                            <div class="modal-dialog modal-lg" role="document" style="width:100%!important;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="modal-title-default">Add Questions</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                        <div class="modal-body">
                                            <!-- START OF MODAL BODY -->
                                            <div class="container">
                                                <div class="card-body">
                                                    <div class="table-responsive py-4">
                                                        <table class="table table-flush" id="`+i.subject_id+`-modal-table">
                                                            <thead class="thead-light">
                                                            <tr>
                                                                <th><th>
                                                                <th> Chapter </th>
                                                                <th> Question </th>
                                                                <th> Option 1 </th>
                                                                <th> Option 2 </th>
                                                                <th> Option 3</th>
                                                                <th> Option 4 </th>
                                                                <th> Answer </th>
                                                                <th> Answer Explanation </th>
                                                                <th> Difficulty Rating </th>
                                                            </tr>
                                                            </thead>
                                                            <tfoot class="tfoot-light">
                                                                <tr>
                                                                    <th></th>
                                                                    <th> Chapter </th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th> Difficulty Rating </th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">

                                        </div>
                                </div>
                            </div>
                        </div>
                        `;
                    });
                    $("#subjects").html(html);
                }
            });
        }

        $("#course").on('change', function() {
            getSubjects($(this).val());
        });

        $(document).ready(function () {
            getSubjects($("#course").val());
        });

        addQuestionButtonClicked = function(event) {
            event.preventDefault();
            modal_id = "#" + event.target.id+ "-modal";
            $(modal_id).modal('show');
            let questionTable = $("#" + event.target.id+ "-modal-table");
            questionTable.DataTable({
                initComplete: function() {
                this.api().columns([1,9]).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
            },
            processing: true,
            serverSide: true,
            select: true,
            ajax:  '/institute/questions/get-questions/'+event.target.id,
            columns: [
                {data: 'add_to_test'},
                {data: 'chapter'},
                {data: 'question_text'},
                {data: 'option_1'},
                {data: 'option_2'},
                {data: 'option_3'},
                {data: 'option_4'},
                {data: 'correct_option'},
                {data: 'question_explanation'},
                {data: 'question_rating'},
            ],
            language: {paginate: {previous: "<i class='fa fa-angle-left'>", next: "<i class='fa fa-angle-right'>"}}
            });
        };

    </script>
    <script>
        var getChapters = function(subject_id) {
            $.ajax({
                type: 'GET',
                url: '/get-chapters/' + subject_id,
                success: function(response) {
                    response = JSON.parse(response);
                    response.forEach(function (item) {
                        let tag = "<option value=" + item.chapter_id + ">" + item.chapter_name +"</option>";
                        $("#chapter").append(tag);
                    });
                }
            })
        };

        $(document).ready(function() {
            let subject_id = $('#subject').val();
            getChapters(subject_id);
        });

        $('#subject').change(function(event) {
            let subject_id = $(this).val();
            $("#chapter").html("");
            getChapters(subject_id);
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


