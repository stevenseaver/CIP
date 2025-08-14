<!-- Begin Page Content -->
<div class="container-fluid pt-4 mt-5">

    <div class="container">
        <!-- Page Heading -->
        <div class="d-sm-flex justify-content-between my-4 mx-4">
            <h1 class="h3 mb-0 text-primary font-weight-bold"><?= $title ?></h1>
        </div>

        <!-- Site Map -->
        <div class="row mb-3 mx-3">
            <div class="col-lg-2 mb-3">
                <div class="d-sm-flex text-left">
                    <h5 class="text-dark font-weight-bold">Laman Web</h5>
                </div>
                <?php foreach ($webmenu as $wm) : ?>
                    <div class="d-sm-flex text-left mb-2">
                        <a href="<?= base_url($wm['url']) ?>" target="_blank" class="text-primary"><?= $wm['title']; ?></a>
                    </div>
                <?php endforeach; ?>
                <div class="d-sm-flex text-left mb-2">
                    <a href="<?= base_url('auth') ?>" target="_blank" class="text-primary">Belanja</a>
                </div>
            </div>
            <div class="col-lg-2 mb-3">
                <div class="d-sm-flex text-left ">
                    <h5 class="text-dark font-weight-bold">Produk</h5>
                </div>
                <?php foreach ($products as $p) : ?>
                    <div class="d-sm-flex text-left mb-2">
                        <a href="<?= base_url($p['url']) ?>" target="_blank" class="text-primary"><?= $p['title']; ?></a>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-lg-2 mb-3">
                <div class="d-sm-flex text-left ">
                    <h5 class="text-dark font-weight-bold">Prinsip</h5>
                </div>
                <div class="d-sm-flex text-left mb-2">
                    <a href="<?= base_url('web/lp0_circulatry') ?>" target="_blank" class="text-primary">Ekonomi Sirkular</a>
                </div>
                <div class="d-sm-flex text-left mb-2">
                    <a href="<?= base_url('web/lp1_quality') ?>" target="_blank" class="text-primary">Kualitas Tinggi</a>
                </div>
                <div class="d-sm-flex text-left mb-2">
                    <a href="<?= base_url('web/lp2_eco') ?>" target="_blank" class="text-primary">Peduli Lingkungan</a>
                </div>
                <div class="d-sm-flex text-left mb-2">
                    <a href="<?= base_url('web/lp3_guideline') ?>" target="_blank" class="text-primary">Personalisasi</a>
                </div>
            </div>
            <div class="col-lg-2 mb-3">
                <div class="d-sm-flex text-left">
                    <h5 class="text-dark font-weight-bold">Legal</h5>
                </div>
                <div class="d-sm-flex text-left mb-2">
                    <a href="<?= base_url('web/privacy_policy') ?>" target="_blank" class="text-primary">Kebijakan Privasi</a>
                </div>
                <div class="d-sm-flex text-left mb-2">
                    <a href="<?= base_url('web/terms') ?>" target="_blank" class="text-primary">Syarat dan Ketentuan</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
</div>
<!-- End of Main Content -->