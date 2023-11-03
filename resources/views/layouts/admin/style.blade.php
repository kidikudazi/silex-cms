<link rel="shortcut icon" href="{{ asset('assets/frontend/images/logos/logo.png') }}" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
<link href="{{ asset('assets/backend/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/backend/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/backend/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/backend/plugins/custom/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/plugins/custom/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/plugins/custom/toastr/toastr.min.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('assets/backend/plugins/custom/summernote/summernote-bs4.css') }}"> --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/backend/js/fancy/jquery.fancybox.min.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .bounce {
        display: inline-block;
        position: relative;
        -moz-animation: bounce 0.5s infinite linear;
        -o-animation: bounce 0.5s infinite linear;
        -webkit-animation: bounce 0.5s infinite linear;
        animation: bounce 0.5s infinite linear;
        colr:000;
    }

    @-webkit-keyframes bounce {
        0% { top: 0; }
        50% { top: -0.2em; }
        70% { top: -0.3em; }
        100% { top: 0; }
    }

    @-moz-keyframes bounce {
        0% { top: 0; }
        50% { top: -0.2em; }
        70% { top: -0.3em; }
        100% { top: 0; }
    }

    @-o-keyframes bounce {
        0% { top: 0; }
        50% { top: -0.2em; }
        70% { top: -0.3em; }
        100% { top: 0; }
    }

    @-ms-keyframes bounce {
        0% { top: 0; }
        50% { top: -0.2em; }
        70% { top: -0.3em; }
        100% { top: 0; }
    }

    @keyframes bounce {
        0% { top: 0; }
        50% { top: -0.2em; }
        70% { top: -0.3em; }
        100% { top: 0; }
    }
</style>