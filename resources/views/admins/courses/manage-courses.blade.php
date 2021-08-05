@extends('layouts.base')

@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/courses"><i class="ni ni-ruler-pencil"></i></a></li>
    <li class="breadcrumb-item"><a href="/courses/dashboard ">Courses</a></li>
    <li class="breadcrumb-item active" aria-current="page">Manage Courses</li>
@endsection

@section('page-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Manage Courses</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="course-list">
                            <thead class="thead-light">
                            <tr>
                                <th> # </th>
                                <th> Course Name </th>
                                <th> Course Description </th>
                                <th> Edit Subjects/Institues </th>
                                <th> Delete </th>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteCourse_Modal">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form  id="delete_form" method="GET">
                    <div class="modal-body">
                        @csrf
                        <div class="form-body">
                            <!-- START OF MODAL BODY -->
                            <div class="container">
                                <label><strong>Delete</strong> the Course request ?</label>
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

    <!-- Edit Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editSubjects_Institutes_Modal">
        <div class="modal-dialog modal- modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
{{--                <form  id="block_form" method="GET" >--}}
                    <div class="modal-body">
                        @csrf
                        <div class="form-body">
                            <!-- START OF MODAL BODY -->
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="card">
                                            <!-- Card header -->
                                            <div class="card-header">
                                                <h3 class="mb-0">Add Courses</h3>
                                            </div>
                                            <!-- Card body -->
                                            <div class="card-body">
                                                @if (count($errors) > 0)
                                                    <div class = "alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <form action="{{url('admin/admin-courses/edit-course-query')}}" id = "edit-course-form" method="post">
                                                    <div class="mb-2">
                                                        <label for="course_name" class="form-control-label">Course Name</label>
                                                        <input type="text" class="form-control" id="course_name" name="course_name">
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="course_description" class="form-control-label">Course Description</label>
                                                        <textarea class="form-control" name="course_description" id="course_description"></textarea>
                                                    </div>

                                                    @csrf
                                                    <div class="mb-2 Subject_select" style="border: 1px solid #e0e0e0 ; border-radius: 5px ; padding: 5px">
                                                    </div>
                                                    <div class="mb-2 Institute_select" style="border: 1px solid #e0e0e0 ; border-radius: 5px ; padding: 5px">

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger  ml-auto" data-dismiss="modal">Close</button>
                                                        <input type="submit" class="btn btn-success" value="Edit Course">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

{{--                </form>--}}
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
        let courseTable = $('#course-list')
        courseTable.DataTable({
            processing: true,
            serverSide: true,
            ajax:  '/admin/admin-courses/get-courses',
            "columns":[
                {data : 'course_id'},
                {data : 'course_name'},
                {data : 'course_description'},
                {data : 'editSubjects_Institutes'},
                {data : 'delete'},
            ],
            language: {paginate: {previous: "<i class='fa fa-angle-left'>", next: "<i class='fa fa-angle-right'>"}}
        });

        courseTable.on('click' , '.deleteCourse' , function () {
            let course_id = $(this).attr('data-course-id');
            $('#delete_form').attr('action', '/admin/admin-courses/delete-course/'+ course_id);
            console.log($('#delete_form').attr('action'));
        });

        //Function to feed data into edit course modal
        courseTable.on('click' , '.editSubjects_Institutes' , function () {
            let course_id = $(this).attr('data-course-id');
            $.ajax({
                type: 'GET',
                url: '/admin/admin-courses/edit-courses/' + course_id,
                success: function(data){
                    var result = $.parseJSON(data);
                    var select_subject = $('.Subject_select');
                    var select_institue = $('.Institute_select');
                    var checkbox_subject = "<label for=\"subjects\" class=\"form-control-label\">Subjects</label>";
                    var checkbox_institute = "<label for=\"institutes\" class=\"form-control-label\">Institutes</label>";
                    var checked = "";
                    for (var i = 0 ; i < result[2].length ; i++)
                    {
                        for(var j = 0 ; j < result[0].length ; j++)
                        {
                            if (result[2][i].subject_name == result[0][j].subject_name)
                            {
                                checked = 'checked';
                                console.log(result[0][j].subject_name);
                                break;
                            }
                            else
                                checked = '';
                        }
                        checkbox_subject += '<div class="custom-control custom-checkbox"> <input type="checkbox" '+checked+' class="custom-control-input" value="'+result[2][i].subject_id+'" id="subject'+result[2][i].subject_id+'" name="subject_id[]"> <label class="custom-control-label" for="subject'+result[2][i].subject_id+'">'+result[2][i].subject_name+'</label></div>'
                    }

                    for (var i = 0 ; i < result[3].length ; i++)
                    {
                        for(var j = 0 ; j < result[1].length ; j++)
                        {
                            if (result[3][i].name == result[1][j].name)
                            {
                                checked = 'checked';
                                break;
                            }
                            else
                                checked = '';
                        }
                        checkbox_institute += '<div class="custom-control custom-checkbox"> <input type="checkbox" '+checked+' class="custom-control-input" value="'+result[3][i].institute_id+'" id="institute'+result[3][i].institute_id+'" name="institute_id[]"> <label class="custom-control-label" for="institute'+result[3][i].institute_id+'">'+result[3][i].name+'</label></div>'
                    }

                    select_subject.html(checkbox_subject);
                    select_institue.html(checkbox_institute);
                    $('#course_name').val(result[4][0].course_name);
                    $('#course_description').val(result[4][0].course_description);
                    $('#edit-course-form').attr('action' , '/admin/admin-courses/edit-course-query/'+course_id);
                    },
                    error: function(){
                        console.log('Error!!');
                    },
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


