<!-- Begin Page Content -->
<div class="container-fluid pt-4 mt-5">

    <!-- Page Heading -->
    <div class="d-sm-flex justify-content-between my-4 mx-4">
        <h1 class="h3 mb-0 text-primary font-weight-bold"><?= $title ?></h1>
    </div>

    <!-- Site Map -->
    <div class="row mb-3 mx-3">
        <div class="col-lg-2 mb-3">
            <div class="d-sm-flex text-justify">
                <h5 class="text-dark font-weight-bold">Webpage</h5>
            </div>
            <?php foreach ($webmenu as $wm) : ?>
                <div class="d-sm-flex text-justify mb-1">
                    <a href="<?= base_url($wm['url']) ?>" target="_blank" class="text-green"><?= $wm['title']; ?></a>
                </div>
            <?php endforeach; ?>
            <div class="d-sm-flex text-justify mb-1">
                <a href="<?= base_url('auth') ?>" target="_blank" class="text-green">Shop</a>
            </div>
        </div>
        <div class="col-lg-2 mb-3">
            <div class="d-sm-flex text-justify ">
                <h5 class="text-dark font-weight-bold">Products</h5>
            </div>
            <?php foreach ($products as $p) : ?>
                <div class="d-sm-flex text-justify mb-1">
                    <a href="<?= base_url($p['url']) ?>" target="_blank" class="text-green"><?= $p['title']; ?></a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-lg-2 mb-3">
            <div class="d-sm-flex text-justify ">
                <h5 class="text-dark font-weight-bold">Info</h5>
            </div>
            <div class="d-sm-flex text-justify mb-1">
                <a href="<?= base_url('web/lp1_quality') ?>" target="_blank" class="text-green">High Quality</a>
            </div>
            <div class="d-sm-flex text-justify mb-1">
                <a href="<?= base_url('web/lp2_eco') ?>" target="_blank" class="text-green">Eco-Mindful</a>
            </div>
            <div class="d-sm-flex text-justify mb-1">
                <a href="<?= base_url('web/lp3_guideline') ?>" target="_blank" class="text-green">Customization</a>
            </div>
        </div>
        <div class="col-lg-2 mb-3">
            <div class="d-sm-flex text-justify">
                <h5 class="text-dark font-weight-bold">Legal</h5>
            </div>
            <div class="d-sm-flex text-justify mb-1">
                <a href="<?= base_url('web/privacy_policy') ?>" target="_blank" class="text-green">Privacy policy</a>
            </div>
            <div class="d-sm-flex text-justify mb-1">
                <a href="<?= base_url('web/terms') ?>" target="_blank" class="text-green">Terms and Condition</a>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->