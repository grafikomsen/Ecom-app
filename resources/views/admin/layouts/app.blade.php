<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Laravel Shop :: Administrative Panel</title>

		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{ asset('assets-admin/fontawesome/css/all.min.css') }}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{ asset('assets-admin/bootstrap/css/bootstrap.min.css') }}">
        <!-- Dropzone -->
		<link rel="stylesheet" href="{{ asset('assets-admin/dropzone/min/dropzone.min.css') }}">
        <!-- Sweetalert -->
		<link rel="stylesheet" href="{{ asset('assets-admin/sweetalert2/sweetalert2.min.css') }}">
        <!-- Select2 -->
		<link rel="stylesheet" href="{{ asset('assets-admin/select2/css/select2.min.css') }}">
        <!-- Summernote -->
		<link rel="stylesheet" href="{{ asset('assets-admin/summernote/summernote.min.css') }}">
        <!-- Date Time -->
		<link rel="stylesheet" href="{{ asset('assets-admin/datetime/datetimepicker.css') }}">
        <!-- Main -->
		<link rel="stylesheet" href="{{ asset('assets-admin/css/main.css') }}">

    </head>
	<body>

        <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
            <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
                <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
              <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                </button>
              </li>
              <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                </button>
              </li>
              <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                    Auto
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                </button>
              </li>
            </ul>
        </div>

        <header class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap py-1 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-4 fw-bold" href="{{ route('admin.dashboard') }}">
                <img width="190" height="30" src="" alt="">
            </a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <input class="form-control form-control-dark w-100 rounded-1 border-0 py-2 mx-4" type="text" placeholder="Cherchez ici..." aria-label="Search">
            <div class="navbar-nav">
                <div class="nav-item">
                    <a class="btn btn-primary btn-sm border-0 fs-6 rounded-1 text-white mx-2" href="{{ route('admin.logout') }}">Déconnectez</a>
                </div>
            </div>
        </header>

        <div class="container-fluid">
            <div class="row">
                <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
                    @include('admin.layouts.sidebar')
                </div>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Dashboard</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                                This week
                            </button>
                        </div>
                    </div>

                    <div>
                        @yield('main')
                    </div>

                    <canvas class="my-0 w-100" id="myChart" width="900" height="100"></canvas>
                </main>
            </div>
        </div>

		<!-- jQuery -->
		<script src="{{ asset('assets-admin/jquery/jquery.min.js') }}"></script>
		<!-- Bootstrap 5 -->
		<script src="{{ asset('assets-admin/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Dropzone -->
        <script src="{{ asset('assets-admin/dropzone/min/dropzone.min.js') }}"></script>
        <!-- Sweetalert -->
        <script src="{{ asset('assets-admin/sweetalert2/sweetalert2.min.js') }}"></script>
        <!-- Select2 -->
        <script src="{{ asset('assets-admin/select2/js/select2.min.js') }}"></script>
        <!-- Summernote -->
        <script src="{{ asset('assets-admin/summernote/summernote.min.js') }}"></script>
        <!-- Date Time -->
        <script src="{{ asset('assets-admin/datetime/datetimepicker.js') }}"></script>
		<!-- Main -->
		<script src="{{ asset('assets-admin/js/main.js') }}"></script>

        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function(){
                $(".summernote").summernote({
                    height: 200
                });
            });
        </script>

        @yield('customJs')

    </body>
</html>
