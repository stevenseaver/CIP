<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <?php
    $date = time();
    $year = date('y');
    $month = date('m');
    $serial = rand(1000, 9990);
    //ref invoice
    $po_id = 'PO-' . $year . $month . '-' . $serial;
    ?>

    <a href="<?= base_url('purchasing/add_po/') . $po_id ?>" class="btn btn-primary btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Purchase Order</span>
    </a>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->