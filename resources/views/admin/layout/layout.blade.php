<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="POS - Bootstrap Admin Template">
        <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>__(Inventory Management System)</title>

        <link rel="shortcut icon" type="image/x-icon" href="{{ url('assets/img/favicon.jpg') }}">

        <!-- <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}"> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <link rel="stylesheet" href="{{ url('assets/css/animate.css') }}">

        <link rel="stylesheet" href="{{ url('assets/css/dataTables.bootstrap4.min.css') }}">

        <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ url('assets/plugins/select2/css/select2.min.css') }}">

        <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    </head>
    <body>
        <div id="global-loader">
            <div class="whirly-loader"> </div>
        </div>

        <div class="main-wrapper">

            @include('admin.layout.header')

            @include('admin.layout.sidebar')

            @yield('content')

            @include('admin.layout.footer')
        </div>

