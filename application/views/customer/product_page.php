<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row row-cols-1 row-cols-md-3">
        <?php $i = 0; ?>
        <?php foreach ($finishedStock as $fs) : ?>
            <?php
            if ($fs['status'] != 7) {
                continue;
            } else {
            }
            ?>
            <div class="col mb-4">
                <div class="card h-100">
                    <img class="img-fluid rounded" src="<?= base_url() . $fs['picture'] ?>" alt="Product Image" style="width: 30rem;">
                    <div class="card-body">
                        <h5 class="card-title text-primary font-weight-bold mb-0"><?= $fs['name'] ?></h5>
                        <small class="mb-3"><?= $fs['code'] ?></small>
                        <p class="card-text mt-3">Available stocks: <?= $fs['in_stock'] ?></p>
                    </div>
                    <div class="ml-3">
                        <span class="input-group mb-2">
                            <button type="button" class="quantity-left-minus btn btn-danger btn-circle" data-type="minus" data-field="">
                                <span class="bi bi-dash-lg"></span>
                            </button>
                            <div class="form-group mx-1">
                                <input type="text" class="form-control" id="quantity <?= $i ?>" name=" quantity <?= $i ?>" value="1" min="1" max="100">
                                <?= form_error('campuran', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <button type="button" class="quantity-right-plus btn btn-success btn-circle" data-type="plus" data-field="">
                                <span class="bi bi-plus-lg"></span>
                            </button>
                        </span>
                        <a href="" class="btn border-secondary btn-white btn-icon-split mb-3" data-toggle="modal" data-target="#newGBJ">
                            <span class="icon text-white-50">
                                <i class="bi bi-cart"></i>
                            </span>
                            <span class="text">Add to Cart<span>
                        </a>
                        <a href="" class="btn btn-success btn-icon-split mb-3 mx-1" data-toggle="modal" data-target="#newGBJ">
                            <span class="icon text-white-50">
                                <i class="bi bi-cart"></i>
                            </span>
                            <span class="text">Buy<span>
                        </a>
                    </div>
                </div>
            </div>
            <?php $i++ ?>
        <? endforeach; ?>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->