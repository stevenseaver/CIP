<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Forgot Password</title>

    <!-- Bootstrap CSS -->
    <link href="<?= base_url('asset/'); ?>css/bootstrap.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('asset/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('asset/'); ?>css/sb-admin-2.css" rel="stylesheet">

    <style>
        @media all and (max-width: 2880px) {
            .desktop {
                display: block;
            }

            .mobile {
                display: none;
            }
        }

        @media all and (max-width: 991px) {
            .desktop {
                display: none;
            }

            .mobile {
                display: block;
            }
        }

        .clickable {
            cursor: pointer;
        }
    </style>
</head>

<body id="page-top">
    <!-- Begin Page Content -->
    <div class="container-fluid bg-gradient-light">
        <!-- Content Row -->
        <div class="row mb-2">
            <div class="col">
                <div class="card shadow border-0 mx-2 my-5">
                    <div class="card-body">
                        <div class="row py-2 justify-content-center">
                            <div class="col-lg py-3 mx-2 text-left">
                                <i class="bi bi-key fa-3x mb-3 x-2 text-primary"></i>
                                <h4 class="text-primary mb-2 font-weight-bold">Forgot your password?</h4>
                                <p class="text-secondary mb-1">Don't worry, we know this would happen so we will help you.</p>
                                <p class="text-secondary mb-1">Click this link below to reset your password. This link will self destruct in one (1) day.</p>
                                <!-- <a href="" class="btn btn-primary mt-3" target="_blank">Directions &rarr; </a> -->
                                <a href="<?= base_url() . 'auth/resetpassword?email=' . $email . '&token=' . $token ?>" class="btn btn-primary mt-3">Reset Password</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Main Content -->
</body>
<!-- Footer -->
<footer class="text-center text-lg-start bg-white mx-3">
    <!-- Section: Links  -->
    <section class="">
        <div class="container text-left text-md-start mt-5">
            <!-- Grid row -->
            <div class="row mt-1">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto">
                    <!-- Content -->
                    <h6 class="text-dark fw-bold mb-3">
                        <a href="<?= base_url('web/') ?>"><i class="fas fa-recycle mr-2"></i>CV Rukun Gemilang Perkasa</a>
                    </h6>
                </div>

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0">
                    <!-- Links -->
                    <h6 class="text-small text-primary fw-bold mb-3">
                        Contact
                    </h6>
                    <p>
                        <a href="mailto:cs@plastikrukun.com" class="text-dark" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-envelope mr-1"></i>
                            <span>cs@plastikrukun.com</span>
                        </a>
                    </p>
                    <a href="https://wa.me/+6287862413070/?text=Halo,%20boleh%20minta%20informasi%20soal%20produk%20kresek%20anda?%20|%20Hello,%20can%20I%20have%20any%20information%20of%20your%20products?" class="text-dark" target="_blank" rel="noopener noreferrer">
                        <p>
                            <i class="bi bi-whatsapp mr-1"></i>+6287862413070
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </section>
</footer>
<script src="<?= base_url('asset/'); ?>js/sb-admin-2.min.js"></script>
</body>
</html>