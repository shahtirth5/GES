@extends('layouts.base')

@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
{{--    <li class="breadcrumb-item"><a href="/enquiry"><i class="ni ni-controller"></i> Dashboard </a></li>--}}
@endsection

@section('page-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <h1>Dashboard Yet To Be Done !!</h1>
                </div>
            </div>

            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h4 class="mb-0">Your Institute Code is : </h4>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <h1 class="d-inline-block" id="institute_code">{{$institute_code}}</h1>
                    <button class="btn btn-lg p-1 m-2 inline" data-toggle="tooltip" data-placement="top" title="Copy to clipboard" onclick="copyToClipboard(event)"><i class="far fa-copy fa-lg"></i></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(event) {
            btn = event.target;
            let text = document.getElementById('institute_code').innerText;
            var $tempElement = $("<input>");
            $("body").append($tempElement);
            $tempElement.val(text).select();
            document.execCommand("Copy");
            $tempElement.remove();
        }
    </script>
@endsection
