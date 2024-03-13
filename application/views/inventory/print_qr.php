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
                <div class="row align-items-center">
                    <div class="col-3 mb-4">
                        <img style=" width: 100px;" src="<?= base_url('asset/img/QRCode/') . $code . '.png'; ?>">
                    </div>
                    <div class="col-9 mb-4">
                        <div class="row">
                            <label class="font-weight-bold mx-0 my-0"><?= $code; ?></label>
                        </div>
                        <div class="row">
                            <?= $name; ?>
                        </div>
                        <div class="row">
                            <?= $date; ?>
                        </div>
                        <div class="row">
                            <?= $pos; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="<?= base_url('inventory/assets'); ?>" class="btn btn-light btn-icon-split mb-3">
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