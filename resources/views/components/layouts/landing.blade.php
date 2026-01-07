<!DOCTYPE html>
<html lang="en">

    <!-- Mirrored from live.themewild.com/mocart/index-10.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 Sep 2025 09:45:43 GMT -->

    <head>
        <!-- meta tags -->
        <meta charset="UTF-8">
        <meta
            http-equiv="X-UA-Compatible"
            content="IE=edge"
        >
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        >
        <meta
            name="description"
            content=""
        >
        <meta
            name="keywords"
            content=""
        >

        <!-- title -->
        <title>Mocart - Multipurpose eCommerce HTML5 Template</title>

        <!-- favicon -->
        <x-link
            rel="icon"
            type="image/x-icon"
            href="assets/img/logo/favicon.png"
        />

        <!-- css -->
        <x-link
            rel="stylesheet"
            href="assets/css/bootstrap.min.css"
        />
        <x-link
            rel="stylesheet"
            href="assets/css/all-fontawesome.min.css"
        />
        <x-link
            rel="stylesheet"
            href="assets/css/animate.min.css"
        />
        <x-link
            rel="stylesheet"
            href="assets/css/magnific-popup.min.css"
        />
        <x-link
            rel="stylesheet"
            href="assets/css/owl.carousel.min.css"
        />
        <x-link
            rel="stylesheet"
            href="assets/css/jquery-ui.min.css"
        />
        <x-link
            rel="stylesheet"
            href="assets/css/nice-select.min.css"
        />
        <x-link
            rel="stylesheet"
            href="assets/css/style.css"
        />

    </head>

    <body class="home-10">

        <!-- preloader -->
        <div class="preloader">
            <div class="loader-ripple">
                <div></div>
                <div></div>
            </div>
        </div>
        <!-- preloader end -->

        <!-- header area -->
        @include('__partials.landing.header')
        <!-- header area end -->

        <!-- popup search -->
        @include('__partials.landing.pop-search')
        <!-- popup search end -->

        <main class="main">
            {{ $slot }}
        </main>

        <!-- footer area -->
        @include('__partials.landing.footer')
        <!-- footer area end -->

        <!-- scroll-top -->
        <a
            href="#"
            id="scroll-top"
        ><i class="far fa-arrow-up-from-arc"></i></a>
        <!-- scroll-top end -->

        <!-- modal quick shop-->
        @include('__partials.landing.modal-quick-shop')
        <!-- modal quick shop end -->

        <x-script src="assets/js/jquery-3.7.1.min.js"></x-script>
        <x-script src="assets/js/modernizr.min.js"></x-script>
        <x-script src="assets/js/bootstrap.bundle.min.js"></x-script>
        <x-script src="assets/js/imagesloaded.pkgd.min.js"></x-script>
        <x-script src="assets/js/jquery.magnific-popup.min.js"></x-script>
        <x-script src="assets/js/isotope.pkgd.min.js"></x-script>
        <x-script src="assets/js/jquery.appear.min.js"></x-script>
        <x-script src="assets/js/jquery.easing.min.js"></x-script>
        <x-script src="assets/js/owl.carousel.min.js"></x-script>
        <x-script src="assets/js/counter-up.js"></x-script>
        <x-script src="assets/js/jquery-ui.min.js"></x-script>
        <x-script src="assets/js/jquery.nice-select.min.js"></x-script>
        <x-script src="assets/js/countdown.min.js"></x-script>
        <x-script src="assets/js/wow.min.js"></x-script>
        <x-script src="assets/js/main.js"></x-script>

    </body>


</html>
