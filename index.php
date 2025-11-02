<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>roepard labs</title>
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="./site.webmanifest">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="roepard-login">
    <meta name="apple-mobile-web-app-title" content="roepard-login">
    <meta name="theme-color" content="#efdbbf">
    <meta name="msapplication-navbutton-color" content="#efdbbf">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-starturl" content="./index.html">

    <!-- Halfmoon.css and Themes -->
    <link rel="stylesheet" href="./dist/halfmoon/css/halfmoon.min.css">
    <link rel="stylesheet" href="./dist/halfmoon/css/cores/halfmoon.cores.css">
    <!-- Boxicons.css -->
    <link href="./dist/boxicons/fonts/basic/boxicons.min.css" rel="stylesheet">
    <link href="./dist/boxicons/fonts/animations.min.css" rel="stylesheet">
    <link href="./dist/boxicons/fonts/brands/boxicons-brands.min.css" rel="stylesheet">
    <link href="./dist/boxicons/fonts/transformations.min.css" rel="stylesheet">
    <!-- FontAwesome Kit -->
    <script src="https://kit.fontawesome.com/c5f09bfc31.js" crossorigin="anonymous"></script>
    <!-- SweetAlert2.css -->
    <link href="./dist/sweetalert2/sweetalert2.min.css" rel="stylesheet">
    <!-- LoadingBar.css -->
    <link rel="stylesheet" type="text/css" href="./dist/loading-bar/loading-bar.min.css" />
    <!-- Glightbox.css -->
    <link rel="stylesheet" href="./dist/glightbox/dist/css/glightbox.min.css">
    <!-- AOS.css -->
    <link href="./dist/aos/aos.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="./dist/animate/css/animate.min.css">
    <!-- DataTables.css -->
    <link href="./dist/datatables/datatables.min.css" rel="stylesheet" />
    <!-- Notyf.css -->
    <link href="./dist/notyf/notyf.min.css" rel="stylesheet">
    <!-- Tippy.css -->
    <link href="./dist/tippy/animations/scale.css" rel="stylesheet">
    <!-- PhotoSwipe.css -->
    <link rel="stylesheet" href="./dist/photoswipe/dist/photoswipe.css">
    <!-- Video.css -->
    <link rel="stylesheet" href="./dist/video/video-js.css">
    <!-- TomSelect.css -->
    <link href="./dist/tom-select/tom-select.css" rel="stylesheet">
    <!-- Flatpickr.css -->
    <link href="./dist/flatpickr/flatpickr.min.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner de carga -->
    <main class="d-flex justify-content-center align-items-center vh-100">
        <button class="btn btn-primary" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
        </button>
    </main>

    <!-- Popper.js -->
    <script src="./dist/popper/popper.min.js"></script>
    <!-- Bootstrap.js -->
    <script src="./dist/bootstrap/js/bootstrap.min.js"></script>
    <!-- AOS.js -->
    <script src="./dist/aos/aos.js"></script>
    <!-- Anime.js -->
    <script src="./dist/anime/anime.iife.min.js"></script>
    <!-- SweetAlert2.js -->
    <script src="./dist/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- Chart.js -->
    <script src="./dist/chart/chart.min.js"></script>
    <!-- LoadingBar.js -->
    <script type="text/javascript" src="./dist/loading-bar/loading-bar.min.js"></script>
    <!-- Day.js -->
    <script src="./dist/day/dayjs.min.js"></script>
    <!-- Glightbox.js -->
    <script src="./dist/glightbox/dist/js/glightbox.min.js"></script>
    <!-- jQuery.js & Inputmask.js -->
    <script src="./dist/jquery/jquery.min.js"></script>
    <script src="./dist/inputmask/dist/jquery.inputmask.min.js"></script>
    <!-- DataTables.js -->
    <script src="./dist/datatables/datatables.min.js"></script>
    <!-- Notyf.js -->
    <script src="./dist/notyf/notyf.min.js"></script>
    <!-- Tippy.js -->
    <script src="./dist/tippy/tippy-bundle.umd.min.js"></script>
    <!-- PhotoSwipe.js -->
    <script type="module">
        import PhotoSwipeLightbox from './dist/photoswipe/dist/photoswipe-lightbox.esm.min.js';
        const lightbox = new PhotoSwipeLightbox({
            gallery: '#my-gallery',
            children: 'a',
            pswpModule: () => import('./dist/photoswipe/dist/photoswipe.esm.min.js')
        });
        lightbox.init();
    </script>
    <!-- Video.js -->
    <script src="./dist/video/video.min.js"></script>
    <!-- TomSelect.js -->
    <script src="./dist/tom-select/tom-select.complete.min.js"></script>
    <!-- Flatpickr.js -->
    <script src="./dist/flatpickr/flatpickr.min.js"></script>
    <!-- Filepond.js -->
    <script src="./dist/filepond/filepond.min.js"></script>
    <script src="./dist/filepond/filepond.jquery.js"></script>
    <script src="./dist/filepond/filepond-plugin-file-encode.js"></script>

    <!-- Color Mode Toggler.js -->
    <script src="./js/color-mode-toggler.js"></script>

    <!-- Index.js -->
    <script src="./js/index.js"></script>
</body>

</html>