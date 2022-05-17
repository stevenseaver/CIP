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
        <div class="col-lg-8">
            <h1 class="h3 mb-3 ml-1 font-weight-bold text-primary"><?= $title ?></h1>
        </div>
    </div>

    <?php foreach ($blogdata as $bc) : ?>
        <?php
        if ($bc['parent_id'] != "2") {
            continue;
        } else {
        } ?> <div class="row justify-content-center my-2 mx-3">
            <div class="col-lg-8 align-items-center mb-3 border-0 shadow px-0">
                <div class="card-body text-left  bg-white">
                    <h5 class="card-title mb-1 font-weight-bold"><?= $bc["title"] ?></h5>
                    <p class="card-subtitle mb-4 text-muted"><?= date('d F Y', $bc["date_created"]); ?></p>
                    <h6 class="card-subtitle mb-2 text-muted"><?= $bc["summary"] ?></h6>
                    <a href="<?= base_url('blog/content/') . $bc["id"]  ?>" class="card-link">Read more &rarr; </a>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <div class="text-center mb-4">
        <a class="small" href="<?= base_url('web/blogs') ?>"> &larr; Back to Blog</a>
    </div>
</div>
<!-- End of Main Content -->