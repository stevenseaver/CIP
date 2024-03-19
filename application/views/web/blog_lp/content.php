<!-- Begin Page Content -->
<!-- Page Heading -->
<div class="no-gutter pt-4 mt-5 bg-light">
    <div class="row d-flex justify-content-center align-items-center bg-light">
        <?php foreach ($post_type as $bt) : ?>
            <a href="<?= base_url() . $bt['url'] ?>" class="nav-link strecthed text-dark text-center pt-3 pb-3 px-4">
                <figure class="nav-icon <?= $bt['icon']; ?>  fa-2x mb-1"></figure>
                <span class="nav-label"><?= $bt['type_name']; ?></span>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="row justify-content-center align-items-center text-left pt-1">
        <!-- Page Heading -->
        <div class="col-lg-10">
            <?php foreach ($blogdata as $bc) : ?>
                <?php
                if ($bc['id'] != $contentToLoad) {
                    continue;
                } else {
                } ?>
                <h2 class="ml-3 mb-2 mt-2 text-primary font-weight-bold text-left"><?= $bc["title"] ?></h2>
                <p class="ml-3 mb-4 text-left"><?= date('d F Y', $bc["updated_at"]); ?></p>
                <div class="row justify-content-center my-2 mx-3">
                    <div class="col-lg-12 align-items-center card mb-3 border-0 shadow px-0">
                        <div class="card-body text-center">
                            <img src="<?= base_url('') . $bc["image"] ?>" class="img-fluid rounded mb-4" style="width: 40rem;" alt="Image Content">
                            <p class="card-subtitle mb-2 text-muted  text-left"><?= $bc["content"] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>

    <div class="text-center mb-4">
        <a class="small" href="<?= base_url('web/blogs') ?>"> &larr; Kembali</a>
    </div>
</div>
<!-- End of Main Content -->