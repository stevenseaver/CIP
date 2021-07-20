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
                <h5 class="text-center mt-2 mb-1">Rukun Jumbo Bag</h5>
                <h1 class="text-center mb-1">Strong and elastic</h1>
                <h5 class="text-center mb-3">Available in 5 coloful choises</h5>
                <a class="" href=" <?= base_url() ?>products/plasticbag">Learn more &rarr;</a>
                <img class="card-img my-3" src="<?= base_url('asset/') ?>img/undraw_posting_photo.svg" alt="Welcome Image" width="150" height="250">
            </div>
        </div>
    </div>
    <div class="no-gutter text-center">
        <div class="card rounded-0 border-0 mt-2 mx-auto bg-dark text-white">
            <div class="card-body">
                <h5 class="text-center mt-2 mb-1">Rukun Plastic Bag</h5>
                <h1 class="text-center mb-1">Transparent or white, you choose</h1>
                <h5 class="text-center mb-3">Comes with many sizes</h5>
                <a class="text-white" href=" <?= base_url() ?>products/plasticbag">Learn more &rarr;</a>
                <img class="card-img my-3" src="<?= base_url('asset/') ?>img/undraw_posting_photo.svg" alt="Welcome Image" width="150" height="250">
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->