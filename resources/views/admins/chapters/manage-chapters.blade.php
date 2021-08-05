@extends('layouts.base')

@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/chapters"><i class="ni ni-ruler-pencil"></i></a></li>
    <li class="breadcrumb-item"><a href="/chapters/dashboard ">Chapters</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chapters Subjects</li>
@endsection

@section('page-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Manage Chapters</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="chapter-list">
                            <thead class="thead-light">
                            <tr>
                                <th> # </th>
                                <th> Chapter Name </th>
                                <th> Chapter Description </th>
                                <th> Edit </th>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteChapter_Modal">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Delete Chapter Request</h6>
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
                                <label><strong>Delete</strong> the Chapter request ?</label>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="editChapters_Modal">
        <div class="modal-dialog modal- modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Edit Chapter Request</h6>
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
                                            <h3 class="mb-0">Edit Chapter</h3>
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
                                            <form action="{{url('admin/admin-chapters/edit-chapter-query')}}" id = "edit-chapter-form" method="post">
                                                @csrf
                                                <div class="mb-2">
                                                    <label for="Chapter_name" class="form-control-label">Chapter Name</label>
                                                    <input type="text" class="form-control" id="chapter_name" name="chapter_name">
                                                </div>

                                                <div class="mb-2">
                                                    <label for="chapter_description" class="form-control-label">Chapter Description</label>
                                                    <textarea class="form-control" name="chapter_description" id="chapter_description"></textarea>
                                                </div>

                                                <div class="mb-2 subject-dropdown">
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger  ml-auto" data-dismiss="modal">Close</button>
                                                    <input type="submit" class="btn btn-success" value="Edit Chapter">
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
        let courseTable = $('#chapter-list')
        courseTable.DataTable({
            processing: true,
            serverSide: true,
            ajax:  '/admin/admin-chapters/get-chapters',
            "columns":[
                {data : 'chapter_id'},
                {data : 'chapter_name'},
                {data : 'chapter_description'},
                {data : 'editChapter'},
                {data : 'delete'},
            ],
            language: {paginate: {previous: "<i class='fa fa-angle-left'>", next: "<i class='fa fa-angle-right'>"}}
        });

        courseTable.on('click' , '.deleteChapter' , function () {
            let chapter_id = $(this).attr('data-chapter-id');
            $('#delete_form').attr('action', '/admin/admin-chapters/delete-chapter/'+ chapter_id);
            console.log($('#delete_form').attr('action'));
        });

        //Function to feed data into edit course modal
        courseTable.on('click' , '.editChapter' , function () {
            let chapter_id = $(this).attr('data-chapter-id');
            $.ajax({
                type: 'GET',
                url: '/admin/admin-chapters/edit-chapter/' + chapter_id,
                success: function(data){
                    var result = $.parseJSON(data);
                    $('#chapter_name').val(result[0].chapter_name);
                    $('#chapter_description').val(result[0].chapter_description);
                    let select = "<label for=\"subject-list\" class=\"form-control-label\">Subject</label><select class='form-control' id='subject-list' name='subject'>";
                    let selected = "selected";
                    for (var i = 0 ; i < result[1].length ; i++)
                    {
                        if(result[1][i].subject_id == result[0].subject_id)
                            selected = "selected";
                        else
                            selected = "";
                        select += "<option value='"+result[1][i].subject_id+"'"+selected+">"+result[1][i].subject_name+"</option>"
                    }
                    select += "</select>";
                    $('.subject-dropdown').html(select);
                    console.log(select);
                    $('#edit-chapter-form').attr('action' , '/admin/admin-chapters/edit-chapter-query/'+chapter_id);
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


