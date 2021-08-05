@extends('layouts.base')

@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/courses"><i class="ni ni-ruler-pencil"></i></a></li>
    <li class="breadcrumb-item"><a href="/courses">Courses</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Courses</li>
@endsection

@section('page-content')
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
                    <form action="{{url('admin/admin-courses/add-course-query')}}" method="post">
                        <div class="mb-2">
                            <label for="course_name" class="form-control-label">Course Name</label>
                            <input type="text" class="form-control" id="course_name" name="course_name">
                        </div>

                        <div class="mb-2">
                            <label for="course_description" class="form-control-label">Course Description</label>
                            <textarea class="form-control" name="course_description" id="course_description"></textarea>
                        </div>

                        @csrf
                        <div class="mb-2 " style="border: 1px solid #e0e0e0 ; border-radius: 5px ; padding: 5px">
                            <label for="subjects" class="form-control-label">Subjects</label>
                            @foreach($subjects as $subject)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="{{$subject->subject_id}}" id="subject{{$subject->subject_id}}" name="subject_id[]">
                                    <label class="custom-control-label" for="subject{{$subject->subject_id}}">{{$subject->subject_name}}</label>
                                </div>
                            @endforeach

                        </div>
                        <div class="mb-2 " style="border: 1px solid #e0e0e0 ; border-radius: 5px ; padding: 5px">
                            <label for="institutes" class="form-control-label">Institutes</label>
                            @foreach($institutes as $institute)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="{{$institute->institute_id}}" id="institute{{$institute->institute_id}}" name="institute_id[]">
                                    <label class="custom-control-label" for="institute{{$institute->institute_id}}">{{$institute->name}}</label>
                                </div>
                            @endforeach

                        </div>
                        <input type="submit" class="btn btn-primary" value="Add Course">

                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection


@section ('custom-script')
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


