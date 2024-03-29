<!-- Footer -->
<footer class="text-center text-lg-start bg-white">
    <!-- Section: Social media -->
    <section class="d-flex align-items-center justify-content-center justify-content-lg-between p-4 border-bottom mx-2">
        <div class="container text-left text-md-start mt-1">
            <p class="small">1. Rukun&reg;, and Gemah&reg; are registered trademark of UD. Cakra Inti Plastik.</p>
            <p class="small">2. Our products are made from select recycled materials, hence some minor differences in characteristic (such as color or clearness) may occur between production batches. This does not affect product's quality and reliability. </p>
            <p class="small">3. We may change the product's specification and price according to market situations without prior notice. Product specifications and actual products may slightly vary depending on production processes and quality enhancement. </p>
            <p class="small">4. Custom order are available with a minimum order of 500 kg. </p>
            <p class="small">5. Product images are for illustration purpose only, actual products may or may not vary. </p>
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
                        Why Us?
                    </h6>
                    <p>
                        <a href="<?= base_url('web/lp0_circulatry') ?>" target="_blank" class="text-dark">Circular Economy</a>
                    </p>
                    <p>
                        <a href="<?= base_url('web/lp1_quality') ?>" target="_blank" class="text-dark">High Quality</a>
                    </p>
                    <p>
                        <a href="<?= base_url('web/lp2_eco') ?>" target="_blank" class="text-dark">Eco-Mindful</a>
                    </p>
                    <p>
                        <a href="<?= base_url('web/lp3_guideline') ?>" target="_blank" class="text-dark">Customization</a>
                    </p>
                </div>

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
                        <a href="<?= base_url('web/terms') ?>" class="text-dark">Terms and Conditions</a>
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
                        <a href="https://goo.gl/maps/zRBAk5gr9dujTFc48" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-house mr-1"></i>
                            <span class="text-dark">Sidoarjo, Indonesia 61254</span>
                        </a>
                    </p>
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
                    <a href="https://wa.me/+6287862413070/?text=Halo,%20boleh%20minta%20informasi%20soal%20produk%20kresek%20anda?%20|%20Hello,%20can%20I%20have%20any%20information%20of%20your%20products?" class="text-dark" target="_blank" rel="noopener noreferrer">
                        <p>
                            <i class="bi bi-whatsapp mr-1"></i>+62878-6241-3070
                        </p>
                    </a>
                    <p>
                        <i class="bi bi-telephone mr-1"></i>+6232-801-1529
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
            <span class="small">Copyright &copy; UD. Cakra Inti Plastik 2021</span>
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

<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->

<!-- Bootstrap core JavaScript -->
<script src="<?= base_url('asset/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('asset/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('asset/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('asset/'); ?>js/sb-admin-2.min.js"></script>

<!-- Pie chart -->
<script src="<?= base_url('asset/'); ?>vendor/chart.js/Chart.min.js"></script>
<script src="<?= base_url('asset/'); ?>js/demo/chart-pie-demo.js"></script>

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