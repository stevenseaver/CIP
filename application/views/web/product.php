<!-- Begin Page Content -->
<div class="no-gutter pt-2 mt-5 bg-light">
    <div class="row d-flex justify-content-center align-items-center bg-light">
        <?php foreach ($products as $pl) : ?>
            <a href="<?= base_url() . $pl['url'] ?>" class="nav-link strecthed text-dark text-center pt-3 pb-3 px-4">
                <figure class="nav-icon <?= $pl['image']; ?>  fa-2x mb-1"></figure>
                <span class="nav-label"><?= $pl['title']; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="no-gutter text-center">
        <div class="card rounded-0 border-0 mx-auto bg-white text-dark">
            <div class="card-body">
                <h5 class="text-center mt-2 mb-1">Rukun&trade; Jumbo Bag</h5>
                <h1 class="text-center mb-1">Strong and elastic</h1>
                <h5 class="text-center mb-3">Strong enough for 18L of water</h5>
                <a class="" href=" <?= base_url() ?>products/jumbobag">Learn more &rarr;</a>
                <img class="card-img my-3" src="<?= base_url('asset/') ?>img/undraw_posting_photo.svg" alt="Product Image #1" width="150" height="250">
            </div>
        </div>
    </div>
    <!-- First Tier Product -->
    <div class="no-gutter text-center">
        <div class="card rounded-0 border-0 mt-2 mx-auto bg-dark text-white">
            <div class="card-body">
                <h5 class="text-center mt-2 mb-1">Shopping Bag</h5>
                <h1 class="text-center mb-1">Colorful. Splendid.</h1>
                <h5 class="text-center mb-3">Available in 6 colorful choices.</h5>
                <a class="text-white" href=" <?= base_url() ?>products/shoppingbag">Learn more &rarr;</a>
                <img class="card-img my-3" src="<?= base_url('asset/') ?>img/undraw_posting_photo.svg" alt="Product Image #2" width="150" height="250">
            </div>
        </div>
    </div>
    <!-- Second Tier Items -->
    <div class="row text-center justify-content-center align-items-center mb-3">
        <div class="col-lg-6">
            <div class="card border-0 mt-3 mx-auto bg-gradient-white text-dark">
                <div class="card-body">
                    <h5 class="text-center text-green mt-2 mb-1">Rukun&trade; Plastic Bag</h5>
                    <h3 class="text-center mb-1">Many sizes and types.</h3>
                    <a class="text-green" href=" <?= base_url() ?>products/plasticbag">Learn more &rarr;</a>
                </div>
                <img class="rounded mx-auto d-block mt-0 mb-4" src="<?= base_url('asset/') ?>img/undraw_posting_photo.svg" alt="Product Image #3" height="200" width="350">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 mt-3 mx-auto bg-gradient-white text-dark">
                <div class="card-body">
                    <h5 class="text-center text-green mt-2 mb-1">Inner Bag</h5>
                    <h3 class="text-center mb-1">Protects what is good inside.</h3>
                    <a class="text-green" href=" <?= base_url() ?>products/inner">Learn more &rarr;</a>
                </div>
                <img class="rounded mx-auto d-block mt-0 mb-4" src="<?= base_url('asset/') ?>img/undraw_posting_photo.svg" alt="Product Image #4" height="200" width="350">
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->