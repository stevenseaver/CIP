<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900"><?= $title ?></h1>
    <!-- back button -->
    <a href="<?= base_url('sales/') ?>" class="btn btn-secondary btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left"></i>
        </span>
        <span class="text">Back</span>
    </a>

    <div class="row">
        <div class="col-lg text-center">
            <img class="img-fluid rounded" src="<?= base_url('asset/img/payment/') . $image_name  ?>" alt="Payment Invoice" style="width: 40rem;">
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->