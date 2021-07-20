<!-- Begin Page Content -->
<div class="container-fluid pt-2 mt-5">
    <div class="d-flex justify-content-center align-items-center mb-3">
        <?php foreach ($products as $pl) : ?>
            <a href="<?= base_url() . $pl['url'] ?>" class="nav-link strecthed text-dark text-center pt-4 pb-2 px-4">
                <figure class="nav-icon <?= $pl['image']; ?>  fa-2x mb-1"></figure>
                <span class="nav-label"><?= $pl['title']; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="row-fluid text-center">
        <div class="card border-0 bg-white text-grey mb-3 mx-auto">
            <img class="card-img my-3" src="<?= base_url('asset/') ?>img/undraw_posting_photo.svg" alt="Welcome Image" width="200" height="400">
            <div class="card-img-overlay d-flex flex-column justify-content-center">
                <!-- d-flex atur flexible positioning, justify content center/end/top atur posisi vertical object di dalam div ini -->
                <h1 class="card-title text-primary ml-3">Welcome</h1>
                <p class="card-text ml-3">Lorem ipsum dolores babi goreng tepung</p>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->