<!-- Begin Page Content -->
<div class="container-fluid">
    <?php 
        $data['items'] = $this->db->get_where('settings', ['parameter' => 'header_color'])->row_array();
        $color = $data['items']['value'];
    ?>

    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-900"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="accordion" id="accordionPage">
        <?php 
        $i = 0; 
        foreach ($productCategory as $pc) : ?>
            <a class="dropdown-item"></a>
            <div class="card">
                <div class="card-header" id="heading-<?=$i?>">
                <div class="mb-0 ">
                    <p class="text-dark text-left font-weight-bold mb-0" type="button" data-toggle="collapse" data-target="#collapse-<?=$i?>" aria-expanded="true" aria-controls="collapse-<?=$i?>">
                        <?= $pc['title'];?>
                    </p>
                </div>
            </div>

            <div id="collapse-<?=$i?>" class="collapse show" aria-labelledby="heading-<?=$i?>?" data-parent="#accordionPage">
                <div class="card-body">
                    <?php $pc['id'];?>
                    <div class="row row-cols-1 row-cols-md-3">
                        <?php $j = 0; ?>
                        <?php foreach ($finishedStock as $fs) : ?>
                            <?php
                            if ($fs['status'] != 7 or $fs['categories'] != $pc['id']) {
                                continue;
                            } else {
                            } ?>
                                <div class="col mb-4">
                                    <div class="card rounded-lg border-0 shadow">
                                        <div class="card-body">
                                            <img class="img-fluid rounded mb-3" src="<?= base_url() . $fs['picture'] ?>" alt="Product Image" style="width: 15rem;">
                                            <h5 class="card-title text-primary font-weight-bold mb-1"><?= $fs['name'] ?></h5>
                                            <small class="mb-3"><?= $fs['code'] ?></small>
                                                <p class="card-text mt-3">Available stocks: <?= $fs['in_stock'] . ' '. $fs['unit_satuan'] ?></p>
                                            <form action="<?= base_url('customer/add_to_cart/') . $fs['id'] ?>" method="post">
                                                <div class="form-group">
                                                    <!-- Item name -->
                                                    <label for="amount" class="col-form-label small">Amount</label>
                                                    <input type="number" step="0.01" value="1" max="<?= $fs['in_stock'] ?>" min="1" class="form-control rounded-pill mb-1" id="amount" name="amount">
                                                    <!-- <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?> -->
                                                </div>
                                                <div class="">
                                                    <button type="submit" class="btn rounded-pill border-secondary btn-primary btn-icon-split mb-3">
                                                        <span class="icon text-white-50">
                                                            <i class="bi bi-cart"></i>
                                                        </span>
                                                        <span class="text">Add to Cart<span>
                                                    </button>
                                                    <!-- <a href="<?= base_url('customer/check_out/') ?>" class="btn rounded-pill btn-success btn-icon-split mb-3 mx-1">
                                                        <span class="icon text-white-50">
                                                            <i class="bi bi-currency-dollar"></i>
                                                        </span>
                                                        <span class="text">Buy<span>
                                                    </a> -->
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <?php $j++;
                        endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php $i++;
        endforeach; ?>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->