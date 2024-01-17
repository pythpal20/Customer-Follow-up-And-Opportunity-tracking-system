<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" type="image/png" href="<?= base_url('assets/') ?>img/gallery/favicon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--<link href="<?= base_url('assets/css/') ?>board.css" rel="stylesheet" />-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="<?= base_url('assets/'); ?>font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?= base_url('assets/'); ?>css/animate.css" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>css/style.css" rel="stylesheet">
    <title>Daily FU</title>
    <style>
        .carousel-inner {
            cursor: grab;
        }
    </style>
</head>

<body>
    <nav class="navbar bg-body-tertiary bg-danger" style="font-family: 'Poppins', sans-serif;">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="<?= base_url('/dashboard') ?>" >
                <img src="<?= base_url('upload/'); ?>logo/logo.png" alt="Logo" height="30" class="d-inline-block align-text-top">
                Sistem Informasi Followup Customer
            </a>
        </div>
    </nav>
    <div class="boards max-vh-100">
        <div class="container-fluid">
            <!--<div class="row align-items-center">-->
            <!--    <div class="col col-lg-12">-->
            <!--        <h2 class="fw-bold text-center">Today's achievement ~ Customer Followup</h2>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="row align-items-center" style="margin-top:17px">
                <h2 class="text-center" style="padding:18px; font-weight: bold; color: white;">Today's achievement ~ Customer Followup</h2>
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">

                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="<?= base_url('assets/'); ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url('assets/'); ?>js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?= base_url('assets/'); ?>js/plugins/touchpunch/jquery.ui.touch-punch.min.js"></script>
    <!--<script src="<?= base_url('node_modules') ?>/axios/dist/axios.min.js"></script>-->
    <script>
        $(document).ready(function() {
            // Function to update slider content
            function updateSlider() {
                $.ajax({
                    url: "<?= base_url('master/slider_sse') ?>",
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        var total = response.html.countData;
                        var time = total*9500;
                        // Update the carousel content with the new data
                        document.querySelector("#carouselExampleAutoplaying .carousel-inner").innerHTML = response.html.html;

                        totalTimeout = time;
                        // $("#slider-content").html(response.html);
                        console.log(response.html.html);
                    },
                    error: function(error) {
                        console.error('Error fetching slider data:', error);
                    },
                    complete: function() {
                        // Schedule the next update after a short delay
                        setTimeout(updateSlider, totalTimeout); // 5000 milliseconds (5 seconds)
                    }
                });
            }

            // Initial call to start the updating process
            updateSlider();
        });
    </script>
</body>

</html>