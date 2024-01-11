<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="VIC Admin">
    <meta name="description" content="VIC Admin">
    <meta name="author" content="VIC amin">
{{--    @include('components.partials.favicon_head_link')--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>VIC Admin</title>

    <!-- Custom fonts for this template -->
    <link href="{{asset('admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
     <link href="{{asset('admin/css/sb-admin-2.min.css')}}" rel="stylesheet">
{{--    @vite('public/admin/css/sb-admin-2.css')--}}

    <!-- Custom styles for this page -->
    <link href="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    @yield('css')
</head>
