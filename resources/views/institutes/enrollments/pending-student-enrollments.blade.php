@extends('layouts.base')

@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/enrollments"><i class="ni ni-ruler-pencil"></i></a></li>
    <li class="breadcrumb-item"><a href="/enrollments">Student Enrollment</a></li>
    <li class="breadcrumb-item active" aria-current="page">Pending Enrollments</li>
@endsection

@section('page-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Student Enrollments</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="add-enrollment-list">
                            <thead class="thead-light">
                            <tr>
                                <th> # </th>
                                <th> Name </th>
                                <th> Address </th>
                                <th> City </th>
                                <th> Email </th>
                                <th> Contact No </th>
                                <th> Course Name </th>
                                <th> Enroll </th>
                                <th> Delete </th>
                                <th> Block </th>
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
                <h6 class="modal-title" id="modal-title-default">Delete Enrollment Request</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form  id="delete_form" method="GET" action="/institute/enrollments/change-enrollment-status/">
                <div class="modal-body">
                    @csrf
                    <div class="form-body">
                        <!-- START OF MODAL BODY -->
                        <div class="container">
                            <label><strong>Delete</strong> the enrollment request ?</label>
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

<!-- Block Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="blockModal">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Block Enrollment Request</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form  id="block_form" method="GET" action="/institute/enrollments/change-enrollment-status/">
                <div class="modal-body">
                    @csrf
                    <div class="form-body">
                        <!-- START OF MODAL BODY -->
                        <div class="container">
                            <label><strong>Block</strong> further enrollment requests for this course from this student ?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default  ml-auto" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Block</button>
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
    <script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <script>
        let enrollTable = $('#add-enrollment-list');
        enrollTable.DataTable({
            processing: true,
            serverSide: true,
            select: true,
            ajax:  '/institute/enrollments/get-enrollment-requests',
            columns: [
                {data: 'student_id'},
                {data: 'name'},
                {data: 'address'},
                {data: 'city'},
                {data: 'email'},
                {data: 'contact_no'},
                {data: 'course_name'},
                {data: 'enroll'},
                {data: 'delete'},
                {data: 'block'}
            ],
            language: {paginate: {previous: "<i class='fa fa-angle-left'>", next: "<i class='fa fa-angle-right'>"}}
        });

        enrollTable.on('click', '.enroll', function() {
            let student_id = $(this).attr('data-student-id');
            let course_id = $(this).attr('data-course-id');
            window.location.pathname = '/institute/enrollments/enroll/' + student_id + '/' + course_id;
        });

        enrollTable.on('click', '.delete', function() {
            let student_id = $(this).attr('data-student-id');
            let course_id = $(this).attr('data-course-id');
            $('#delete_form').attr('action', '/institute/enrollments/change-enrollment-status/' + student_id + '/' + course_id + "/-1");
        });

        enrollTable.on('click', '.block', function() {
            let student_id = $(this).attr('data-student-id');
            let course_id = $(this).attr('data-course-id');
            $('#block_form').attr('action', '/institute/enrollments/change-enrollment-status/' + student_id + '/' + course_id + "/3");
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

