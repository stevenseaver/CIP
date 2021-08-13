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
            <div class="col-lg-12 mb-1">
                <h1 class="h3 mb-0 text-primary font-weight-bold">Inner Bag</h1>
            </div>
        </div>
        <div class="row justify-content-left align-items-center my-1 mx-3">
            <div class="col-lg-12 card mb-3 border-0">
                <div class="row no-gutters align-items-center">
                    <div class="col-md-4 text-center">
                        <img src="<?= base_url('asset/') ?>img/LDPE_2.jpg" width="300" class="my-4 rounded">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h4 class="card-title text-primary font-weight-bold">Inner Bag</h4>
                            <p class="text-dark">Inner bag lining for your woven bag products, food container, or your other needs. Made from high-quality high-density polyethylene for strength and a little bit of low-density polyethylene for extra flexibility making it suitable for heavy-duty woven bag application.</p>
                            <h6 class="text-primary font-weight-bold">Specification Sheet</h6>
                            <?php foreach ($spec as $s) : ?>
                                <?php
                                if ($s['product_name'] != "Inner Bag") {
                                    continue;
                                } else {
                                }
                                ?>
                                <div class="row mt-3 mb-3">
                                    <div class="col-md-3 text-left">
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