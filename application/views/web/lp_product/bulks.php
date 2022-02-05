<!-- Begin Page Content -->
<div class="no-gutter pt-2 mt-5">
    <!-- sub nav bar -->
    <div class="row d-flex justify-content-center align-items-center">
        <?php foreach ($products as $pl) : ?>
            <a href="<?= base_url() . $pl['url'] ?>" class="nav-link strecthed text-dark text-center pt-3 pb-1 px-4">
                <figure class="nav-icon <?= $pl['image']; ?>  fa-2x mb-1"></figure>
                <span class="nav-label"><?= $pl['title']; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <!-- Page Heading -->
    <div class="container">
        <div class="row align-items-center mt-3 mx-3">
            <div class="col-lg-6 mb-1">
                <h1 class="h3 mb-0 text-primary font-weight-bold">Loss Ori TM</h1>
            </div>
            <div class="col-lg-6 mb-1 d-flex justify-content-end align-items-center">
                <a href="#" class="badge badge-primary">Buy Now</a>
            </div>
        </div>
        <div class="row justify-content-left my-1 mx-3">
            <div class="col-lg-12 card mb-3 border-0">
                <div class="row no-gutters align-items-top">
                    <div class="col-md-4 text-center">
                        <img src="<?= base_url('asset/') ?>img/products/coin.jpg" width="300" class="my-4 rounded">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <!-- <h4 class="card-title text-primary font-weight-bold">Jumbo Bag</h4> -->
                            <p class="text-dark">We also provides option for you to buy our bulk products. Our Loss Ori TM are virgin and high-quality plastic bag with a glass-like properties no other company can immitate. That is because HDPE are matte colored, but with our secret materials, we can make it glass-like.</p>
                            <h6 class="text-primary font-weight-bold">Specification Sheet</h6>
                            <?php foreach ($spec as $s) : ?>
                                <?php
                                if ($s['product_name'] != "Original TM") {
                                    continue;
                                } else {
                                }
                                ?>
                                <div class="row mt-3 mb-3">
                                    <div class="col-md-3 text-left mb-2">
                                        <?= $s["specification"] ?>
                                    </div>
                                    <div class="col-md-10 text-dark">
                                        <?= $s["items"] ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center mt-3 mx-3">
            <div class="col-lg-6 mb-1">
                <h1 class="h3 mb-0 text-primary font-weight-bold">Loss Warna</h1>
            </div>
            <div class="col-lg-6 mb-1 d-flex justify-content-end align-items-center">
                <a href="#" class="badge badge-primary">Buy Now</a>
            </div>
        </div>
        <div class="row justify-content-left my-1 mx-3">
            <div class="col-lg-12 card mb-3 border-0">
                <div class="row no-gutters align-items-top">
                    <div class="col-md-4 text-center">
                        <img src="<?= base_url('asset/') ?>img/products/coin.jpg" width="300" class="my-4 rounded">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <!-- <h4 class="card-title text-primary font-weight-bold">Jumbo Bag</h4> -->
                            <p class="text-dark">Loss Warna is high-volume colored plastic bag for every-day farmer's market usage. Loss warna is made from fully recycled plastic pellets for low-cost usage.</p>
                            <h6 class="text-primary font-weight-bold">Specification Sheet</h6>
                            <?php foreach ($spec as $s) : ?>
                                <?php
                                if ($s['product_name'] != "Original TM") {
                                    continue;
                                } else {
                                }
                                ?>
                                <div class="row mt-3 mb-3">
                                    <div class="col-md-3 text-left mb-2">
                                        <?= $s["specification"] ?>
                                    </div>
                                    <div class="col-md-10 text-dark">
                                        <?= $s["items"] ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->