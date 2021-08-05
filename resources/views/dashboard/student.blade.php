@extends('layouts.base')

@section('page-content')
<div class="row">
    <div class="col-xl-6 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text mb-0">Scholarship</h5>
                    <span class="h2 font-weight-bold mb-0">{{$user->student->scholarship->count()}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                            <i class="ni ni-book-bookmark "></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
                    <a href="/student-courses/create">
                        <span class="text-success "><i class="ni ni-fat-add"></i></span>
                        <span class="text-nowrap">Add Course</span></a>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text mb-0">Internship</h5>
                        <span class="h2 font-weight-bold mb-0">{{$user->student->internship->count()}}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                            <i class="ni ni-briefcase-24  "></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
                    <a href="/student-internship/create">
                        <span class="text-success "><i class="ni ni-fat-add"></i></span>
                        <span class="text-nowrap">Add Internship</span></a>
                </p>
            </div>
        </div>
    </div>


</div>
@endsection

@section('custom-script')
<!-- Optional JS -->
@if(session()->has('type'))
<script>
    $.notify({
        // options
        title: '<h4 style="color:white">{{ session('
        title ') }}</h4>',
        message: '{{ session('
        message ') }}',
    }, {
        // settings
        type: '{{ session('
        type ') }}',
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
