<!-- Begin Page Content -->
<div class="no-gutter pt-4 mt-5 bg-light">
    <div class="row d-flex justify-content-center align-items-center bg-light">
        <?php foreach ($blog_type as $bt) : ?>
            <a href="<?= base_url() . $bt['url'] ?>" class="nav-link strecthed text-dark text-center pt-3 pb-3 px-4">
                <figure class="nav-icon <?= $bt['icon']; ?>  fa-2x mb-1"></figure>
                <span class="nav-label"><?= $bt['type_name']; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="row justify-content-center text-center my-2 mx-3">
        <div class="col-lg-8 card mb-3 border-0 shadow px-0">
            <div id="carouselBlog" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php $j = 0;
                    foreach ($blog_content as $bc) : ?>
                        <?php
                        if ($bc['parent_id'] != "1") {
                            continue;
                        } else {
                        }
                        ?>
                        <li data-target="#carouselBlog" data-slide-to="<?= $j ?>" class="<?php if ($j == 0) {
                                                                                                echo 'active';
                                                                                            } else {
                                                                                            }; ?>"></li>
                    <?php $j++;
                    endforeach ?>
                </ol>
                <div class="carousel-inner">
                    <?php $i = 0;
                    foreach ($blog_content as $bc) : ?>
                        <?php
                        if ($bc['parent_id'] != "1") {
                            continue;
                        } else {
                        }
                        ?>
                        <div class="carousel-item <?php if ($i == 0) {
                                                        echo 'active';
                                                    } else {
                                                    }; ?>">
                            <img src="<?= base_url('') . $bc["image"] ?>" class="img-fluid rounded" style="width: 60rem;" alt="Featured 1">
                            <div class="carousel-caption d-none d-md-block">
                                <h4 class="text-white"><?= $bc["title"] ?></h4>
                                <p><?= $bc["summary"] ?></p>
                                <a href="<?= base_url('blog/content/') . $bc["id"]  ?>" class="text-white">Baca lebih &rarr; </a>
                            </div>
                        </div>
                    <?php $i++;
                    endforeach ?>
                </div>
                <button class="carousel-control-prev border-0 bg-transparent" type="button" data-target="#carouselBlog" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </button>
                <button class="carousel-control-next border-0 bg-transparent" type="button" data-target="#carouselBlog" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </button>
            </div>
        </div>
    </div>
    <?php foreach ($blog_content as $bc) : ?>
        <?php
        if ($bc['parent_id'] == "1") {
            continue;
        } else {
        }
        ?>
        <div class="row justify-content-center my-2 mx-3">
            <div class="col-lg-8 align-items-center  mb-3 border-0 px-0">
                <div class="card-body text-left bg-white rounded shadow-sm">
                    <h5 class="card-title mb-1 text-primary font-weight-bold"><?= $bc["title"] ?></h5>
                    <p class="card-subtitle mb-4 text-muted"><?= date('d F Y', $bc["date_created"]); ?></p>
                    <h6 class="card-subtitle mb-2 text-muted"><?= $bc["summary"] ?></h6>
                    <a href="<?= base_url('blog/content/') . $bc["id"]  ?>" class="card-link">Baca lebih &rarr; </a>
                </div>
            </div>
        </div>
    <?php endforeach ?>

</div>
<!-- End of Main Content -->