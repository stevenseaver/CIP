<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
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
                <div class="card rounded-lg h-100 border-0 shadow">
                    <div class="card-body">
                        <img class="img-fluid rounded mb-3" src="<?= base_url() . $fs['picture'] ?>" alt="Product Image" style="width: 25rem;">
                        <h5 class="card-title text-primary font-weight-bold mb-1"><?= $fs['name'] ?></h5>
                        <small class="mb-3"><?= $fs['code'] ?></small>
                        <p class="card-text mt-3">Available stocks: <?= $fs['in_stock'] ?></p>
                        <form action="<?= base_url('customer/add_to_cart/') . $fs['id'] ?>" method="post">
                            <div class="form-group">
                                <!-- Item name -->
                                <label for="amount" class="col-form-label small">Amount</label>
                                <input type="text" value="1" class="form-control rounded-pill mb-1" id="amount" name="amount">
                                <!-- <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?> -->
                            </div>
                            <div class="">
                                <button type="submit" class="btn rounded-pill border-secondary btn-white btn-icon-split mb-3">
                                    <span class="icon bg-gray-500 text-white-50">
                                        <i class="bi bi-cart"></i>
                                    </span>
                                    <span class="text">Add to Cart<span>
                                </button>
                                <a href="" class="btn rounded-pill btn-success btn-icon-split mb-3 mx-1">
                                    <span class="icon text-white-50">
                                        <i class="bi bi-currency-dollar"></i>
                                    </span>
                                    <span class="text">Buy<span>
                                </a>
                        </form>
                    </div>
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