<!-- Footer -->
<footer class="text-center text-lg-start bg-white">
    <!-- Section: Social media -->
    <section class="d-flex align-items-center justify-content-center justify-content-lg-between p-4 border-bottom mx-2">
        <div class="container text-left text-md-start mt-1">
            <p class="small">Jemblung &trade; and Rukun &trade; are trademark of UD. Cakra Inti Plastik.</p>
            <p class="small">Our products are made from select recycled materials, hence some minor differences in characteristic (such as color or clearness) may occur between production batches. This does not affect product's quality and reliability. </p>
        </div>
        <!-- Right -->
    </section>
    <!-- Section: Social media -->
    <!-- Section: Links  -->
    <section class="">
        <div class="container text-left text-md-start mt-5">
            <!-- Grid row -->
            <div class="row mt-1">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto">
                    <!-- Content -->
                    <h6 class="text-dark fw-bold mb-3">
                        <i class="fas fa-recycle mr-2"></i>UD. Cakra Inti Plastik
                    </h6>
                    <p>
                        A plastic manufacturing company focused on recycled plastic bag and packaging products.
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto">
                    <!-- Links -->
                    <h6 class="text-primary fw-bold mb-3">
                        Products
                    </h6>
                    <?php foreach ($products as $p) : ?>
                        <p>
                            <a href="<?= base_url($p['url']) ?>" class="text-dark"><?= $p['title']; ?></a>
                        </p>
                    <?php endforeach; ?>
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
                        <a href="https://goo.gl/maps/zRBAk5gr9dujTFc48" target="_blank">
                            <i class="bi bi-house mr-1"></i>
                            <span class="text-dark">Sidoarjo, Indonesia 61254</span>
                        </a>
                    </p>
                    <p>
                        <a href="mailto:cs.sbplastik@gmail.com" class="text-dark" target="_blank">
                            <i class="bi bi-envelope mr-1"></i>
                            <span>cs.sbplastik@gmail.com</span>
                        </a>
                    </p>
                    <a href="https://instagram.com/sbplastik" class="text-dark" target="_blank">
                        <p>
                            <i class="bi bi-instagram mr-1"></i> sbplastik
                        </p>
                    </a>
                    <a href="https://wa.me/+6282232057755" class="text-dark" target="_blank">
                        <p>
                            <i class="bi bi-whatsapp mr-1"></i>+62822-3205-7755
                        </p>
                    </a>
                    <p>
                        <i class="bi bi-telephone mr-1"></i>+6232-701-1529
                    </p>
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
            <span>Copyright &copy; UD. Cakra Inti Plastik 2021</span>
        </div>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!-- Bootstrap core JavaScript
 <script src="<?= base_url('asset/'); ?>vendor/jquery/jquery.min.js"></script>
 <script src="<?= base_url('asset/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

<!-- Core plugin JavaScript-->
<script src="<?= base_url('asset/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('asset/'); ?>js/sb-admin-2.min.js"></script>

<!-- Page level datatables plugins -->
<script src="<?= base_url('asset/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('asset/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level datatables custom scripts -->
<script src="<?= base_url('asset/') ?>js/demo/datatables-demo.js"></script>

<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });


    $('.form-check-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        $.ajax({
            url: "<?= base_url('admin/changeaccess'); ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('admin/roleaccess/')  ?>" + roleId;
            }
        });
    });
</script>

</body>

</html>