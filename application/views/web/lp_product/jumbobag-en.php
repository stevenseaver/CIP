<!-- Begin Page Content -->
<div class="no-gutter pt-4 mt-5">
    <!-- sub nav bar -->
    <div class="row d-flex justify-content-center align-items-center">
        <?php foreach ($products as $pl) : ?>
            <a href="<?= base_url() . $pl['url'] ?>" class="nav-link strecthed text-dark text-center pt-3 pb-3 px-4">
                <figure class="nav-icon <?= $pl['image']; ?>  fa-2x mb-1"></figure>
                <span class="nav-label"><?= $pl['title']; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <!-- Page Heading -->
    <div class="container">
        <div class="row mt-3 mx-1">
            <div class="col-6 mb-1">
                <h1 class="h3 mb-0 text-primary font-weight-bold">Rukun Jumbo Bag</h1>
            </div>
            <div class="col-6 mb-1 d-flex justify-content-end align-items-center">
                <a href="https://wa.me/+6282232057755/?text=Halo,%20boleh%20minta%20informasi%20soal%20produk%20kresek%20jumbo%20anda?%20|%20Hello,%20can%20I%20have%20any%20information%20of%20your%20jumbo%20plastic%20bag%20products?" class="badge badge-success" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-whatsapp mr-1"></i>Contact Us Now</a>
            </div>
        </div>
        <div class="row justify-content-left my-1 mx-3">
            <div class="col-lg-12 card mb-3 border-0">
                <div class="row no-gutters align-items-top">
                    <div class="col-md-4 text-center">
                        <!-- <img src="<?= base_url('asset/') ?>img/products/coin.jpg" class="my-4 rounded img-fluid"> -->
                        <div id="carouselJumbo" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselJumbo" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselJumbo" data-slide-to="1"></li>
                                <li data-target="#carouselJumbo" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="<?= base_url('asset/img/webpage/5. Jumbo RK 40X65/1.png') ?>" class="my-4 rounded img-fluid">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= base_url('asset/img/webpage/5. Jumbo RK 40X65/merah.png') ?>" class="my-4 rounded img-fluid">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= base_url('asset/img/webpage/5. Jumbo RK 40X65/putih.png') ?>" class="my-4 rounded img-fluid">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= base_url('asset/img/webpage/5. Jumbo RK 40X65/hitam.png') ?>" class="my-4 rounded img-fluid">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= base_url('asset/img/webpage/5. Jumbo RK 40X65/kuning.png') ?>" class="my-4 rounded img-fluid">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= base_url('asset/img/webpage/5. Jumbo RK 40X65/hijau.png') ?>" class="my-4 rounded img-fluid">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= base_url('asset/img/webpage/5. Jumbo RK 40X65/biru.png') ?>" class="my-4 rounded img-fluid">
                                </div>
                            </div>
                            <button class="carousel-control-prev border-0 bg-transparent" type="button" data-target="#carouselJumbo" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </button>
                            <button class="carousel-control-next border-0 bg-transparent" type="button" data-target="#carouselJumbo" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <!-- <h4 class="card-title text-primary font-weight-bold">Jumbo Bag</h4> -->
                            <p class="text-dark text-justify">Rukun&reg; jumbo bags are suitable for your shopping and packaging needs. Jumbo bag's size range from 40 cm to as large as 55 cm in width, made with a blend of HDPE and LDPE to ensure strength for heavy items.</p>
                            <h6 class="text-primary font-weight-bold">Specification Sheet</h6>
                            <?php foreach ($spec as $s) : ?>
                                <?php
                                if ($s['product_name'] != "Jumbo Bag") {
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
            <div class="col-6 mb-1">
                <h1 class="h3 mb-0 text-primary font-weight-bold">Gemah Super Jumbo Bag</h1>
            </div>
            <div class="col-6 mb-1 d-flex justify-content-end align-items-center">
                <a href="https://wa.me/+6282232057755/?text=Halo,%20boleh%20minta%20informasi%20soal%20produk%20kresek%20super%20jumbo%20anda?%20|%20Hello,%20can%20I%20have%20any%20information%20of%20your%20super%20jumbo%20plastic%20bag%20products?" class="badge badge-success" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-whatsapp mr-1"></i>Contact Us Now</a>
            </div>
        </div>
        <div class="row justify-content-left my-1 mx-3">
            <div class="col-lg-12 card mb-3 border-0">
                <div class="row no-gutters align-items-top">
                    <div class="col-md-4 text-center">
                        <!-- <img src="<?= base_url('asset/') ?>img/products/coin.jpg" class="my-4 rounded img-fluid"> -->
                        <div id="carouselGemah" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselGemah" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselGemah" data-slide-to="1"></li>
                                <li data-target="#carouselGemah" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="<?= base_url('asset/img/webpage/3. Gemah 55X80/12.png') ?>" class="my-4 rounded img-fluid">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= base_url('asset/img/webpage/3. Gemah 55X80/merah.png') ?>" class="my-4 rounded img-fluid">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= base_url('asset/img/webpage/3. Gemah 55X80/hijau.png') ?>" class="my-4 rounded img-fluid">
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= base_url('asset/img/webpage/3. Gemah 55X80/kuning.png') ?>" class="my-4 rounded img-fluid">
                                </div>
                            </div>
                            <button class="carousel-control-prev border-0 bg-transparent" type="button" data-target="#carouselGemah" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </button>
                            <button class="carousel-control-next border-0 bg-transparent" type="button" data-target="#carouselGemah" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <!-- <h4 class="card-title text-primary font-weight-bold">Jumbo Bag</h4> -->
                            <p class="text-dark">Gemah&reg; super jumbo bags are high quality plastic bags with vivid color and smooth surface quality. Derrived from ancient Javanese word of fertility, Gemah&reg;'s colorful hue and superior plastic quality would satisfy your need for high-end super jumbo plastic bag.</p>
                            <h6 class="text-primary font-weight-bold">Specification Sheet</h6>
                            <?php foreach ($spec as $s) : ?>
                                <?php
                                if ($s['product_name'] != "Super Jumbo Bag") {
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