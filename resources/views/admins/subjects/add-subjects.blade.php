@extends('layouts.base')

@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/subjects"><i class="ni ni-ruler-pencil"></i></a></li>
    <li class="breadcrumb-item"><a href="/subjects">Subjects</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Subjects</li>
@endsection

@section('page-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Add Subjects</h3>
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
                    <form action="{{url('admin/admin-subjects/add-subjects-query')}}" method="post">
                        <div class="mb-2">
                            <label for="subject_name" class="form-control-label">Subject Name</label>
                            <input type="text" class="form-control" id="subject_name" name="subject_name">
                        </div>

                        <div class="mb-2">
                            <label for="subject_description" class="form-control-label">Subject Description</label>
                            <textarea class="form-control" name="subject_description" id="subject_description"></textarea>
                        </div>

                        @csrf
                        <input type="submit" class="btn btn-primary" value="Add Subject">

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


