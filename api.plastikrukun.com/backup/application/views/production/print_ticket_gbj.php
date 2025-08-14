<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
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

    <?php 
        // $params['data'] = $prod_id . $batch . $item . $net_weight;
        // $qr_image = $this->ciqrcode->generate($params);
    ?>

    <div class="col-lg-4 px-0" id="printableArea">
        <div class="card rounded shadow border-0 mb-3">
            <div class="card-body mb-0 pb-0">
                <div class="row">
                    <div class="col">
                        <p class="mb-0">Prod Order Ref : </p>
                        <p class="text-dark font-weight-bold"> <?= $prod_id ?></p>
                        <p class="mb-0">Batch : </p>
                        <p class="text-dark font-weight-bold"> <?= $batch ?></p>
                        <p class="mb-0">Item : </p>
                        <p class="text-dark font-weight-bold"> <?= $item ?></p>
                    </div>
                    <div class="col">
                        <p class="mb-0">Packing : </p>
                        <p class="text-dark font-weight-bold"> <?= $amount ?> pack</p>
                        <p class="mb-0 text-primary">Net Amount : </p>
                        <p class="text-dark font-weight-bold"> <?= $net_weight ?> kg</p>
                        <p class="mb-0">Description : </p>
                        <p class="text-dark font-weight-bold"><?= $desc ?> </p>
                    </div>
                </div>
                <?php 
                    // $base64Image =  'R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==' . $qr_image; 
                    // echo '<img src="data:image/png;base64,' . $base64Image . '" />';
                ?>
            </div>
        </div>
    </div>
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