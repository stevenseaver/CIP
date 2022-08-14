<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
                                <i class="bi bi-patch-check fa-3x mb-3 x-2 text-primary"></i>
                                <h4 class="text-primary mb-2 font-weight-bold">Verify Your Email</h4>
                                <p class="text-secondary mb-1">We're glad you join our extended family tree.</p>
                                <p class="text-secondary mb-1">Click this link below to activate your account. This link will self destruct in one (1) day.</p>
                                <!-- <a href="" class="btn btn-primary mt-3" target="_blank">Directions &rarr; </a> -->
                                <a href="<?= base_url() . 'auth/verify?email=' . $email . '&token=' . $token ?>" class="btn btn-primary mt-3">Activate Account</a>
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
                        <a href="<?= base_url('web/') ?>"><i class="fas fa-recycle mr-2"></i>UD. Cakra Inti Plastik</a>
                    </h6>
                    <p>
                        A plastic manufacturing company focused on recycled plastic bag and packaging products.
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto">
                    <!-- Links -->
                    <h6 class="text-primary fw-bold mb-3">
                        Legal
                    </h6>
                    <p>
                        <a href="<?= base_url('web/privacy_policy') ?>" class="text-dark">Privacy Policy</a>
                    </p>
                    <p>
                        <a href="<?= base_url('web/site_map') ?>" class="text-dark">Site Map</a>
                    </p>
                    <p>
                        <a href="<?= base_url('web/terms') ?>" class="text-dark">Terms and Condition</a>
                    </p>
                    <p>
                        <a href="<?= base_url('web/legal') ?>" class="text-dark">Legal Standing</a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0">
                    <!-- Links -->
                    <h6 class="text-small text-primary fw-bold mb-3">
                        Contact
                    </h6>
                    <p>
                        <a href="mailto:cs.sbplastik@gmail.com" class="text-dark" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-envelope mr-1"></i>
                            <span>cs.sbplastik@gmail.com</span>
                        </a>
                    </p>
                    <a href="https://instagram.com/sbplastik" class="text-dark" target="_blank" rel="noopener noreferrer">
                        <p>
                            <i class="bi bi-instagram mr-1"></i> sbplastik
                        </p>
                    </a>
                    <a href="https://wa.me/+6282232057755/?text=Halo,%20boleh%20minta%20informasi%20soal%20produk%20kresek%20anda?%20|%20Hello,%20can%20I%20have%20any%20information%20of%20your%20products?" class="text-dark" target="_blank" rel="noopener noreferrer">
                        <p>
                            <i class="bi bi-whatsapp mr-1"></i>+62822-3205-7755
                        </p>
                    </a>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center bg-white p-4">
        <div class="copyright">
            <span class="small">Copyright &copy; UD. Cakra Inti Plastik 2021</span>
        </div>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('asset/'); ?>js/sb-admin-2.min.js"></script>

</body>

</html>