<!-- Begin Page Content -->
<div class="no-gutter pt-4 mt-5 bg-light">
    <div class="row d-flex justify-content-center align-items-center bg-light">
        <?php foreach ($products as $pl) : ?>
            <a href="<?= base_url() . $pl['url'] ?>" class="nav-link strecthed text-dark text-center pt-3 pb-3 px-4">
                <figure class="nav-icon <?= $pl['image']; ?>  fa-2x mb-1"></figure>
                <span class="nav-label"><?= $pl['title']; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <!-- First Tier Products -->
    <div class="no-gutter text-center">
        <div class="card shadow rounded border-0 mx-3 mb-3 bg-gradient-primary text-white">
            <div class="card-body">
                <h5 class="mt-2 mb-1">Rukun&trade; Jumbo Bag</h5>
                <h1 class="mb-1">Strong and elastic</h1>
                <h5 class="mb-3">Strong enough for 18L of water</h5>
                <p class="mb-2">
                    <a class="text-white" href=" <?= base_url() ?>products/jumbobag">Learn more &rarr;</a>
                </p>
                <img class="img-fluid rounded my-3" src="<?= base_url('asset/') ?>img/products/coin.jpg" alt="Product Image #1" style="width: 20rem;">
            </div>
        </div>
    </div>
    <!-- Second Tier Product -->
    <div class="no-gutter text-center">
        <div class="card shadow rounded border-0 mx-3 mb-3 bg-white text-dark">
            <div class="card-body">
                <h5 class="text-center mt-2 mb-1">Shopping Bag</h5>
                <h1 class="text-center mb-1">Colorful. Splendid.</h1>
                <h5 class="text-center mb-3">Available in 6 colorful choices.</h5>
                <p class="mb-2">
                    <a class="" href=" <?= base_url() ?>products/shoppingbag">Learn more &rarr;</a>
                </p>
                <img class="img-fluid rounded my-3" src="<?= base_url('asset/') ?>img/products/coin.jpg" alt="Product Image #2" style="width: 20rem;">
            </div>
        </div>
    </div>
    <!-- Third Tier Items -->
    <div class="row text-center mx-1 mb-4">
        <div class="col-lg-6">
            <div class="card shadow border-0 bg-gradient-white text-dark">
                <div class="card-body">
                    <h5 class="text-center text-primary mt-2 mb-1">Rukun&trade; Plastic Bag</h5>
                    <h3 class="text-center mb-1">Many sizes and types.</h3>
                    <a class="text-primary mb-2" href=" <?= base_url() ?>products/plasticbag">Learn more &rarr;</a>
                </div>
                <div class="text-center mb-4">
                    <img class="img-fluid rounded" src="<?= base_url('asset/') ?>img/products/coin.jpg" alt="Product Image #3" style="width: 20rem;">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow border-0 bg-gradient-white text-dark">
                <div class="card-body">
                    <h5 class="text-center text-primary mt-2 mb-1">Inner Bag</h5>
                    <h3 class="text-center mb-1">Protects what is good inside.</h3>
                    <a class="text-primary" href=" <?= base_url() ?>products/inner">Learn more &rarr;</a>
                </div>
                <div class="text-center mb-4">
                    <img class="img-fluid rounded" src="<?= base_url('asset/') ?>img/products/coin.jpg" alt="Product Image #4" style="width: 20rem;">
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->