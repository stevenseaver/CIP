<!-- Footer -->
<footer class="text-center text-lg-start bg-white">
    <!-- Section: Social media -->
    <section class="d-flex align-items-center justify-content-center justify-content-lg-between p-4 border-bottom mx-2">
        <div class="container text-left text-md-start mt-1">
            <p class="small">1. Kualitas lebih tinggi dari barang bermerk lain yang berharga mirip berdasarkan spesifikasi produk atau tampilan fisik.</p>
            <p class="small">2. Rukun&reg; dan Gemah&reg; adalah merk dagang terdaftar dari CV. Rukun Gemilang Perkasa.</p>
            <p class="small">3. Produk kami terbuat dari bahan daur ulang pilihan, perubahan warna dan karakteristik bahan plastik dapat terjadi antar batch produksi. Hal ini tidak mempengaruhi kualitas dan keandalan produk.</p>
            <p class="small">4. Kami dapat mengganti spesifikasi dan harga produk sesuai kondisi pasar tanpa pemberitahuan lebih dahulu. Spesifikasi produk dan kenyataannya dapat sedikit berbeda tergantung dari proses produksi dan peningkatan kualitas.</p>
            <p class="small">5. Order khusus tersedia dengan kuantitas order minimum (MOQ) 500 kg.</p>
            <p class="small">6. Gambar produk adalah untuk ilustrasi semata. Produk sesungguhnya mungkin berbeda.</p>
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
                        <i class=""></i>CV. Rukun Gemilang Perkasa
                    </h6>
                    <p>
                        Produsen plastik yang berfokus pada produk kemasan plastik daur ulang.
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto">
                    <!-- Links -->
                    <h6 class="text-primary fw-bold mb-3">
                        Produk
                    </h6>
                    <?php foreach ($products as $p) : ?>
                        <p>
                            <a href="<?= base_url($p['url']) ?>" class="text-dark"><?= $p['title']; ?></a>
                        </p>
                    <?php endforeach; ?>
                </div>
                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto">
                    <!-- Links -->
                    <h6 class="text-primary fw-bold mb-3">
                        Kenapa kami?
                    </h6>
                    <p>
                        <a href="<?= base_url('web/lp0_circulatry') ?>" target="_blank" class="text-dark">Ekonomi Sirkular</a>
                    </p>
                    <p>
                        <a href="<?= base_url('web/lp1_quality') ?>" target="_blank" class="text-dark">Kualitas Tinggi</a>
                    </p>
                    <p>
                        <a href="<?= base_url('web/lp2_eco') ?>" target="_blank" class="text-dark">Peduli Lingkungan</a>
                    </p>
                    <p>
                        <a href="<?= base_url('web/lp3_guideline') ?>" target="_blank" class="text-dark">Personalisasi</a>
                    </p>
                </div>

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto">
                    <!-- Links -->
                    <h6 class="text-primary fw-bold mb-3">
                        Legal
                    </h6>
                    <p>
                        <a href="<?= base_url('web/privacy_policy') ?>" class="text-dark">Kebijakan Privasi</a>
                    </p>
                    <p>
                        <a href="<?= base_url('web/site_map') ?>" class="text-dark">Peta Situs</a>
                    </p>
                    <p>
                        <a href="<?= base_url('web/terms') ?>" class="text-dark">Syarat dan Ketentuan</a>
                    </p>
                    <p>
                        <a href="<?= base_url('web/legal') ?>" class="text-dark">Legal</a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0">
                    <!-- Links -->
                    <h6 class="text-small text-primary fw-bold mb-3">
                        Kontak
                    </h6>
                    <p>
                        <a href="https://goo.gl/maps/zRBAk5gr9dujTFc48" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-house mr-1"></i>
                            <span class="text-dark">Sidoarjo, Indonesia 61254</span>
                        </a>
                    </p>
                    <p>
                        <a href="mailto:info@plastikrukun.com" class="text-dark" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-envelope mr-1"></i>
                            <span>info@plastikrukun.com</span>
                        </a>
                    </p>
                    <a href="https://instagram.com/ciplastik.id" class="text-dark" target="_blank" rel="noopener noreferrer">
                        <p>
                            <i class="bi bi-instagram mr-1"></i>@ciplastik.id
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
            <span>Copyright &copy; CV. Rukun Gemilang Perkasa 2024</span>
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