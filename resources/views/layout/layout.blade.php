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

        <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">

        <link rel="stylesheet" href="{{ url('assets/css/animate.css') }}">

        <link rel="stylesheet" href="{{ url('assets/css/dataTables.bootstrap4.min.css') }}">

        <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/all.min.css') }}">

        <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    </head>
    <body>
        <div id="global-loader">
            <div class="whirly-loader"> </div>
        </div>

        <div class="main-wrapper">

            @include('layout.header')

            @include('layout.sidebar')

            @yield('content')

            @include('layout.footer')
        </div>

