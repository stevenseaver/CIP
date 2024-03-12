<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="col-lg-4 px-0" id="printableArea">
        <div class="card rounded shadow border-0 mb-3">
            <div class="card-body mb-0 pb-0">
                <p class="mb-0">Prod Order Ref : </p>
                <p class="text-dark font-weight-bold"> <?= $prod_id ?></p>
                <p class="mb-0">Batch : </p>
                <p class="text-dark font-weight-bold"> <?= $batch ?></p>
                <p class="mb-0">Item : </p>
                <p class="text-dark font-weight-bold"> <?= $item ?></p>
                <p class="mb-0">Net Amount : </p>
                <p class="text-dark font-weight-bold"> <?= $net_weight ?> kg</p>
            </div>
        </div>
    </div>

    <div>
        <?php 
            $params['data'] = 'This is a text to encode become QR Code';
            $this->ciqrcode->generate($params);
        ?>
    </div>

    <a href="<?= base_url('production/') . $roll_back . '/' . $prod_id ?>" class="btn btn-light btn-icon-split mb-3">
        <span class="icon text-dark">
            <i class="bi bi-arrow-left"></i>
        </span>
        <span class="text">Go Back</span>
    </a>
    <button onclick="printDiv('printableArea')" class="btn btn-primary btn-icon-split mb-3" id="btnPrint">
        <span class="icon text-white">
            <i class="bi bi-printer"></i>
        </span>
        <span class="text">Print</span>
    </button>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>
    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>