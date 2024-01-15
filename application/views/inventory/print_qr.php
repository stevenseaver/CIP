<!-- Begin Page Content -->
<div class="row justify-content-center">
    <div class="col-lg">
        <div class="container my-3">
            <div class="card border-left-primary my-3" style="width: 22rem;" id="itemToPrint" name="itemToPrint">
                <div class="row align-items-center">
                    <div class="col-4 ">
                        <img style=" width: 100px;" src="<?= base_url('asset/img/QRCode/') . $code . '.png'; ?>">
                    </div>
                    <div class="col-8">
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
            <!-- <button onClick="window.print()" class="btn btn-primary btn-icon-split mb-3" id="btnPrint">
                <span class="icon text-white-50">
                    <i class="bi bi-printer"></i>
                </span>
                <span class="text">Print</span>
            </button>
            <a href="<?= base_url('inventory/assets') ?>" class="btn btn-secondary btn-icon-split mb-3">
                <span class="icon text-white-50">
                    <i class="bi bi-arrow-left"></i>
                </span>
                <span class="text">Go Back</span>
            </a> -->
        </div>
    </div>
</div>

<script>
    // document.getElementById("btnPrint").onclick = function() {
    //     printElement(document.getElementById("itemToPrint"));

    //     window.print();
    // }

    // function printElement(elem) {
    //     var domClone = elem.cloneNode(true);

    //     var $printSection = document.getElementById("printSection");

    //     if (!$printSection) {
    //         var $printSection = document.createElement("div");
    //         $printSection.id = "printSection";
    //         document.body.appendChild($printSection);
    //     }

    //     $printSection.innerHTML = "";

    //     $printSection.appendChild(domClone);
    // }
</script>
</body>