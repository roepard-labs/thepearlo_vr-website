<!doctype html>
<html lang="en" data-bs-core="modern">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>template</title>

    <!-- Bootstrap.css -->
    <link rel="stylesheet" href="../dist/bootstrap/css/bootstrap.min.css">
    <!-- Boxicons.css -->
    <link href="../dist/boxicons/fonts/basic/boxicons.min.css" rel="stylesheet">
    <link href="../dist/boxicons/fonts/animations.min.css" rel="stylesheet">
    <link href="../dist/boxicons/fonts/brands/boxicons-brands.min.css" rel="stylesheet">
    <link href="../dist/boxicons/fonts/transformations.min.css" rel="stylesheet">
    <!-- FontAwesome Kit -->
    <script src="https://kit.fontawesome.com/c5f09bfc31.js" crossorigin="anonymous"></script>
    <!-- SweetAlert2.css -->
    <link href="../dist/sweetalert2/sweetalert2.min.css" rel="stylesheet">
    <!-- LoadingBar.css -->
    <link rel="stylesheet" type="text/css" href="../dist/loading-bar/loading-bar.min.css" />
    <!-- Glightbox.css -->
    <link rel="stylesheet" href="../dist/glightbox/dist/css/glightbox.min.css">
    <!-- AOS.css -->
    <link href="../dist/aos/aos.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="../dist/animate/css/animate.min.css">
    <!-- DataTables.css -->
    <link href="../dist/datatables/datatables.min.css" rel="stylesheet" />
    <!-- Notyf.css -->
    <link href="../dist/notyf/notyf.min.css" rel="stylesheet">
    <!-- Tippy.css -->
    <link href="../dist/tippy/animations/scale.css" rel="stylesheet">
    <!-- PhotoSwipe.css -->
    <link rel="stylesheet" href="../dist/photoswipe/dist/photoswipe.css">
    <!-- Video.css -->
    <link rel="stylesheet" href="../dist/video/video-js.css">
    <!-- TomSelect.css -->
    <link href="../dist/tom-select/tom-select.css" rel="stylesheet">
    <!-- Flatpickr.css -->
    <link href="../dist/flatpickr/flatpickr.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Template</h1>
        <p class="lead">This is a template file.</p>
    </div>



    <!-- Popper.js -->
    <script src="../dist/popper/popper.min.js"></script>
    <!-- Bootstrap.js -->
    <script src="../dist/bootstrap/js/bootstrap.min.js"></script>
    <!-- AOS.js -->
    <script src="../dist/aos/aos.js"></script>
    <!-- Anime.js -->
    <script src="../dist/anime/anime.iife.min.js"></script>
    <!-- SweetAlert2.js -->
    <script src="../dist/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- Chart.js -->
    <script src="../dist/chart/chart.min.js"></script>
    <!-- LoadingBar.js -->
    <script type="text/javascript" src="../dist/loading-bar/loading-bar.min.js"></script>
    <!-- Day.js -->
    <script src="../dist/day/dayjs.min.js"></script>
    <!-- Glightbox.js -->
    <script src="../dist/glightbox/dist/js/glightbox.min.js"></script>
    <!-- jQuery.js & Inputmask.js -->
    <script src="../dist/jquery/jquery.min.js"></script>
    <script src="../dist/inputmask/dist/jquery.inputmask.min.js"></script>
    <!-- DataTables.js -->
    <script src="../dist/datatables/datatables.min.js"></script>
    <!-- Notyf.js -->
    <script src="../dist/notyf/notyf.min.js"></script>
    <!-- Tippy.js -->
    <script src="../dist/tippy/tippy-bundle.umd.min.js"></script>
    <!-- PhotoSwipe.js -->
    <script type="module">
        import PhotoSwipeLightbox from '../dist/photoswipe/dist/photoswipe-lightbox.esm.min.js';
        const lightbox = new PhotoSwipeLightbox({
            gallery: '#my-gallery',
            children: 'a',
            pswpModule: () => import('../dist/photoswipe/dist/photoswipe.esm.min.js')
        });
        lightbox.init();
    </script>
    <!-- Video.js -->
    <script src="../dist/video/video.min.js"></script>
    <!-- TomSelect.js -->
    <script src="../dist/tom-select/tom-select.complete.min.js"></script>
    <!-- Flatpickr.js -->
    <script src="../dist/flatpickr/flatpickr.min.js"></script>
    <!-- Filepond.js -->
    <script src="../dist/filepond/filepond.min.js"></script>
    <script src="../dist/filepond/filepond.jquery.js"></script>
    <script src="../dist/filepond/filepond-plugin-file-encode.js"></script>

    <!-- Color Mode Toggler.js -->
    <script src="../js/color-mode-toggler.js"></script>
</body>

</html>