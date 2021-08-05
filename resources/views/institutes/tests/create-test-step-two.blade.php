@extends('layouts.base')

@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
          xmlns:width="http://www.w3.org/1999/xhtml">
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
    <li class="breadcrumb-item"><a href="/tests"><i class="ni ni-ruler-pencil"></i></a></li>
    <li class="breadcrumb-item"><a href="/tests">Tests</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Test</li>
@endsection

@section('page-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-3">Create Test - Step 2 : Add Questions</h3>
                    <p class="text-primary font-weight-bold mb-0">{{$test->test_name}}</p>
                    <p class="text-primary font-italic mb-1">{{$test->test_description}}</p>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form action="{{ url('/institute/tests/create-test-query') }}" method="post">
                        @csrf
                        @foreach($subjects as $subject)
                            <div class="mb-2">
                                <label class='form-control-label mb-1 mr-3 mt-2'>{{$subject->subject_name}}</label>
                                <button type="button" id='add-button-{{$subject->subject_id}}' class='btn btn-sm btn-info fa fa-plus add-question-button' data-toggle="modal" data-target="#modal-{{$subject->subject_id}}"></button>
                                <!-- Add Question Modal -->
                                <div class="modal fade" tabindex="-1" role="dialog" id="modal-{{$subject->subject_id}}">
                                    <div class="modal-dialog modal-lg" role="document">
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
                                                            <table class="table table-flush modal-table" id="modal-table-{{$subject->subject_id}}">
                                                                <thead class="thead-light">
                                                                <tr>
                                                                    <th></th>
                                                                    <th> Chapter </th>
                                                                    <th> Question </th>
                                                                    <th> Option 1 </th>
                                                                    <th> Option 2 </th>
                                                                    <th> Option 3</th>
                                                                    <th> Option 4 </th>
                                                                    <th> Answer </th>
                                                                    <th> Answer Explanation </th>
                                                                    <th> Difficulty Rating </th>
                                                                    <th> Add </th>
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
                                                                    <th></th>
                                                                    <th> Difficulty Rating </th>
                                                                    <th></th>
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
                                <!-- End of Add Question Modal -->

                                <div class="table-responsive py-4">
                                    <table class="table table-flush question-table" id="question-table-{{$subject->subject_id}}">
                                        <thead class="thead-light">
                                        <tr>
                                            <th></th>
                                            <th> Chapter </th>
                                            <th> Question </th>
                                            <th> Option 1 </th>
                                            <th> Option 2 </th>
                                            <th> Option 3</th>
                                            <th> Option 4 </th>
                                            <th> Answer </th>
                                            <th> Answer Explanation </th>
                                            <th> Difficulty Rating </th>
                                            <th> Remove </th>
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
                                            <th></th>
                                            <th> Difficulty Rating </th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        @endforeach
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
    {{-- <script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script> --}}
    <script>
        var subject;
        var questionTable = $('.question-table');
        $(document).ready(function() {
            $('.add-question-button').on('click', function() {
                var id = $(this).attr('id');
                subject = id.split('-')[2];
                manageModalTable(subject);
            });

            var manageModalTable = function(subject) {
                var modalTable = $('#modal-table-'+subject);
                modalTable.dataTable({
                    initComplete: function() {
                        this.api().columns([1,8]).every( function () {
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
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    select: true,
                    ajax:  '/institute/questions/get-questions-not-in-test/{{$test->test_id}}/' + subject,
                    columns: [
                        {data: 'byGES'},
                        {data: 'chapter'},
                        {data: 'question_text'},
                        {data: 'option_1'},
                        {data: 'option_2'},
                        {data: 'option_3'},
                        {data: 'option_4'},
                        {data: 'correct_option'},
                        {data: 'question_explanation'},
                        {data: 'question_rating'},
                        {data: 'add'},
                    ],
                    language: {paginate: {previous: "<i class='fa fa-angle-left'>", next: "<i class='fa fa-angle-right'>"}}
                });

                modalTable.on('click', '.add', function(event) {
                $(event.target).hide();
                var subject_id = $(this).closest('table').attr('id').split('-')[2];
                $.ajax({
                    type: "GET",
                    url: "/institute/tests/addQuestionToTest/{{$test->test_id}}/" + $(this).attr('data-question-id'),
                    success: function (response) {
                            if(response == 'ok') {
                                var parentTable = $('#modal-table-'+subject_id);
                                var mt = parentTable.DataTable()
                                mt.ajax.reload();
                                var questionTable = $('#question-table-'+subject_id);
                                var qt = questionTable.DataTable();
                                qt.ajax.reload();
                            } else {
                                window.alert("There was some error. Please Try Again Later !");
                            }
                        }
                    });
                });
            };

            questionTable.each(function(index, element) {
                subject_id = element.id.split('-')[2];
                $(element).dataTable({
                    initComplete: function() {
                        this.api().columns([1,8]).every( function () {
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
                    ajax:  '/institute/questions/get-questions-in-test/{{$test->test_id}}/' + subject_id,
                    columns: [
                        {data: 'byGES'},
                        {data: 'chapter'},
                        {data: 'question_text'},
                        {data: 'option_1'},
                        {data: 'option_2'},
                        {data: 'option_3'},
                        {data: 'option_4'},
                        {data: 'correct_option'},
                        {data: 'question_explanation'},
                        {data: 'question_rating'},
                        {data: 'remove'}
                    ],
                    language: {paginate: {previous: "<i class='fa fa-angle-left'>", next: "<i class='fa fa-angle-right'>"}}
                });
            });

            questionTable.on('click', '.remove', function(event) {
                $(event.target).hide();
                var subject_id = $(this).closest('table').attr('id').split('-')[2];
                $.ajax({
                    type: "GET",
                    url: "/institute/tests/removeQuestionFromTest/{{$test->test_id}}/" + $(this).attr('data-question-id'),
                    success: function (response) {
                        if(response == 'ok') {
                            var questionTable = $('#question-table-'+subject_id);
                            var qt = questionTable.DataTable();
                            qt.ajax.reload();
                        } else {
                            window.alert("There was some error. Please Try Again Later !");
                        }
                    }
                });
            });
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

