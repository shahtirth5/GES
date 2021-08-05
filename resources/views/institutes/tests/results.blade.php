@extends('layouts.base')

@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/tests"><i class="ni ni-ruler-pencil"></i></a></li>
    <li class="breadcrumb-item"><a href="/tests">Tests</a></li>
    <li class="breadcrumb-item active" aria-current="page">Results</li>
@endsection

@section('page-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Test Results</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form action="/institute/tests/results">
                        <label for="test_id" class="form-control-label">Test</label>
                            <select name="test_id" id="test_id" class="form-control">
                                @foreach ($tests as $test)
                                    <option value="{{$test->test_id}}">{{$test->test_name}}</option>
                                @endforeach
                            </select>
                    </form>

                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="results-list">
                            <thead class="thead-light">
                            <tr>
                                <th> Student Name </th>
                                <th> Marks Scored </th>
                                <th> Max Marks </th>
                                <th> View </th>
                            </tr>
                            </thead>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{--MODAL SECTION--}}
<!-- DELETE MODAL -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Delete Test</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form  id="delete_form" method="GET" action="/institute/tests/delete-test/">
                <div class="modal-body">
                    @csrf
                    <div class="form-body">
                        <!-- START OF MODAL BODY -->
                        <div class="container">
                            <label><strong>Delete</strong> the test ?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default  ml-auto" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
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

    <script>
        let getResults = function(test_id) {
            let resultsTable = $('#results-list');
            resultsTable.DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                select: true,
                ajax:  '/institute/tests/results-query/'+test_id,
                columns: [
                    {data: 'name'},
                    {data: 'marks_scored'},
                    {data: 'max_marks'},
                    {data: 'view'},
                ],
                language: {paginate: {previous: "<i class='fa fa-angle-left'>", next: "<i class='fa fa-angle-right'>"}}
            });
        };

        $("#test_id").change(function() {
            let selectedTestId = $(this).children("option:selected").val();
            getResults(selectedTestId);
        });

        $(document).ready(function () {
            let selectedTestId = $("#test_id").children("option:selected").val();
            getResults(selectedTestId);
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

