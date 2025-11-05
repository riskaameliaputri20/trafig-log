@props(['title' => ''])
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default"
    data-layout-width="boxed">

<head>

    <meta charset="utf-8" />
    <title>{{ $title ?? 'Dashboard' }}</title>
    <!-- App favicon -->
    <x-link rel="shortcut icon" href="dashboard/assets/images/favicon.ico" />
    @stack('style')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Layout config Js -->
    <x-script src="dashboard/assets/js/layout.js"></x-script>
    <!-- Bootstrap Css -->
    <x-link href="dashboard/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <x-link href="dashboard/assets/css/icons.min.css" rel="stylesheet" type="text/css" />


    <!-- App Css-->
    <x-link href="dashboard/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <x-link href="dashboard/assets/css/custom.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('__partials.dashboard.header')
        @include('__partials.dashboard.sidebar')
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © Velzon.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by Themesbrand
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <x-script src="dashboard/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></x-script>
    <x-script src="dashboard/assets/libs/simplebar/simplebar.min.js"></x-script>
    <x-script src="dashboard/assets/libs/node-waves/waves.min.js"></x-script>
    <x-script src="dashboard/assets/libs/feather-icons/feather.min.js"></x-script>
    <x-script src="dashboard/assets/js/pages/plugins/lord-icon-2.1.0.js"></x-script>
    <x-script src="dashboard/assets/js/plugins.js"></x-script>

    {{-- 1. jQuery dulu --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    @stack('script')

    <!-- App js -->
    <x-script src="dashboard/assets/js/app.js"></x-script>
</body>

</html>
