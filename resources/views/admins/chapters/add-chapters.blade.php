@extends('layouts.base')

@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/chapters"><i class="ni ni-ruler-pencil"></i></a></li>
    <li class="breadcrumb-item"><a href="/chapters">Chapters</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Chapters</li>
@endsection

@section('page-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Add Chapters</h3>
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
                    <form action="{{url('admin/admin-chapters/add-chapters-query')}}" method="post">
                        <div class="mb-2">
                            <label for="chapter_name" class="form-control-label">Chapter Name</label>
                            <input type="text" class="form-control" id="chapter_name" name="chapter_name">
                        </div>

                        <div class="mb-2">
                            <label for="chapter_description" class="form-control-label">Chapter Description</label>
                            <textarea class="form-control" name="chapter_description" id="chapter_description"></textarea>
                        </div>
                        <div class="mb-2 form-group">
                            <label for="subject-list">Select Subject:</label>
                            <select class="form-control" id="subject-list" name = "subject">
                                <option value="" selected hidden> Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->subject_id }}" >{{ $subject->subject_name }}</option>
                                    @endforeach
                            </select>
                        </div>
                        @csrf
                        <input type="submit" class="btn btn-primary" value="Add Chapter">

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


