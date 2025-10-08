<!doctype html>
<html
    lang="en"
    data-layout="vertical"
    data-topbar="light"
    data-sidebar="dark"
    data-sidebar-size="lg"
    data-sidebar-image="none"
    data-preloader="disable"
    data-theme="default"
    data-theme-colors="default"
>

    <head>

        <meta charset="utf-8" />
        <title>{{ $title ?? 'Authentication' }}</title>
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        >

        <x-link
            rel="shortcut icon"
            href="dashboard/assets/images/favicon.ico"
        />

        <!-- Layout config Js -->
        <x-script src="dashboard/assets/js/layout.js"></x-script>
        <!-- Bootstrap Css -->
        <x-link
            href="dashboard/assets/css/bootstrap.min.css"
            rel="stylesheet"
            type="text/css"
        />
        <!-- Icons Css -->
        <x-link
            href="dashboard/assets/css/icons.min.css"
            rel="stylesheet"
            type="text/css"
        />
        <!-- App Css-->
        <x-link
            href="dashboard/assets/css/app.min.css"
            rel="stylesheet"
            type="text/css"
        />
        <!-- custom Css-->
        <x-link
            href="dashboard/assets/css/custom.min.css"
            rel="stylesheet"
            type="text/css"
        />

    </head>

    <body>

        <div class="auth-page-wrapper pt-5">
            <!-- auth page bg -->
            <div
                class="auth-one-bg-position auth-one-bg"
                id="auth-particles"
            >
                <div class="bg-overlay"></div>

                <div class="shape">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        version="1.1"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 1440 120"
                    >
                        <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z">
                        </path>
                    </svg>
                </div>
            </div>

            <!-- auth page content -->
            <div class="auth-page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mt-sm-5 text-white-50 mb-4 text-center">
                                <div>
                                    <a
                                        href="index.html"
                                        class="d-inline-block auth-logo"
                                    >
                                        <img
                                            src="dashboard/assets/images/logo-light.png"
                                            alt=""
                                            height="20"
                                        >
                                    </a>
                                </div>
                                <p class="fs-15 fw-medium mt-3">Premium Admin & Dashboard Template</p>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                   {{ $slot }}
                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
            <!-- end auth page content -->

            <!-- footer -->
            <footer class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <p class="text-muted mb-0">&copy;
                                    <x-script>
                                        document.write(new Date().getFullYear())
                                    </x-script> Velzon. Crafted with <i
                                        class="mdi mdi-heart text-danger"></i> by Themesbrand
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->
        </div>
        <!-- end auth-page-wrapper -->

        <!-- JAVASCRIPT -->
        <x-script src="dashboard/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></x-script>
        <x-script src="dashboard/assets/libs/simplebar/simplebar.min.js"></x-script>
        <x-script src="dashboard/assets/libs/node-waves/waves.min.js"></x-script>
        <x-script src="dashboard/assets/libs/feather-icons/feather.min.js"></x-script>
        <x-script src="dashboard/assets/js/pages/plugins/lord-icon-2.1.0.js"></x-script>
        <x-script src="dashboard/assets/js/plugins.js"></x-script>

        <!-- particles js -->
        <x-script src="dashboard/assets/libs/particles.js/particles.js"></x-script>
        <!-- particles app js -->
        <x-script src="dashboard/assets/js/pages/particles.app.js"></x-script>
        <!-- password-addon init -->
        <x-script src="dashboard/assets/js/pages/password-addon.init.js"></x-script>
    </body>

</html>
