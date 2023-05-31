<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <?php $std_gramature = 18;
    $gramatur = 0;
    $uncut_gramatur = 0;
    $weightafterplong = 0;
    $weightbeforeplong = 0;
    $weightpackaged = 0;
    $thickness = 0; ?>

    <!-- clear data button -->
    <a href="<?= base_url('production/gramatur') ?>" class="btn btn-danger btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-eraser"></i>
        </span>
        <span class="text">Clear Data</span>
    </a>

    <!-- Calculating width -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Calculating Gramatur</h6>
        </div>
        <!-- Card Content - Collapse -->
        <div class="card-body">
            <form action="<?= base_url('production/gramatur') ?>" method="post">
                <div class="row mb-3">
                    <div class="col-lg-3">
                        <label for="width" class="col-form-label">Width</label>
                        <div class="input-group">
                            <!-- Item width -->
                            <input type="number" step=".1" class="form-control" id="width" name="width" value="<?= set_value('width'); ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                            <?= form_error('width', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="folding" class="col-form-label">Folding</label>
                        <div class="input-group">
                            <!-- Item folding -->
                            <input type="number" step=".1" class="form-control" id="folding" name="folding" value="<?= set_value('folding'); ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                            <?= form_error('folding', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="thickness" class="col-form-label">Thickness</label>
                        <div class="input-group">
                            <!-- Item thickness -->
                            <input type="number" step=".0001" class="form-control" id="thickness" name="thickness" value="<?= set_value('thickness'); ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                            <?= form_error('thickness', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="gramature" class="col-form-label">Standard Gramature</label>
                        <div class="input-group">
                            <!-- Item std gramature -->
                            <input type="number" class="form-control" id="gramature" name="gramature" value="<?= $std_gramature ?>" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">gram/cm</span>
                            </div>
                            <?= form_error('gramature', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="handle_length" class="col-form-label">Handle Length</label>
                        <div class="input-group">
                            <!-- Item handle length -->
                            <input type="number" step=".1" class="form-control" id="handle_length" name="handle_length" value="<?= set_value('handle_length'); ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                            <?= form_error('handle_length', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="cut_width" class="col-form-label">Cutting Width</label>
                        <div class="input-group">
                            <!-- Item cut width -->
                            <input type="number" step=".1" class="form-control" id="cut_width" name="cut_width" value="<?= set_value('cut_width'); ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                            <?= form_error('cut_width', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="length" class="col-form-label">Bag Length</label>
                        <div class="input-group">
                            <!-- Item length -->
                            <input type="number" step=".1" class="form-control" id="length" name="length" value="<?= set_value('length'); ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                            <?= form_error('length', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="pcsperpack" class="col-form-label">Amount per pack</label>
                        <div class="input-group">
                            <!-- Item pcs per pack -->
                            <input type="number" step="1" class="form-control" id="pcsperpack" name="pcsperpack" value="<?= set_value('pcsperpack'); ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">pcs</span>
                            </div>
                            <?= form_error('pcsperpack', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="ppweight" class="col-form-label">Packaging Weight (PP)</label>
                        <div class="input-group">
                            <!-- Item packaging weight -->
                            <input type="number" step="1" class="form-control" id="ppweight" name="ppweight" value="<?= set_value('ppweight'); ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">gram</span>
                            </div>
                            <?= form_error('ppweight', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                </div>
                <input class="btn-add-item btn btn-primary mb-3" type="submit"></input>
            </form>
            <p>Uncut Grammature : <?= $uncut_gramatur?> gram/m </p>
            <p>Grammature : <?= $gramatur?> gram/m </p>
            <p>Bag weight before cutting : <?= $weightbeforeplong?> gram/pcs</p>
            <p>Bag weight after cutting : <?= $weightafterplong?> gram/pcs</p>
            <p>Packaged goods weight : <?= $weightpackaged?> kg/pack</p>    
        </div>
    </div>
    <!-- Calculating width -->
    <script>
        function calculate(gramatur, width, folding)
        {
            var std_gramatur = 18;
            thickness = gramatur/(40+(2*folding))/std_gramatur;
            obj("thickness_result").value = thickness.toFixed(6);
            obj("gramatur_show").value = gramatur;
            obj("width_show").value = width;
            obj("folding_show").value = folding;
        }
        function obj(id)
        {
            return document.getElementById(id);
        }
    </script>

    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Calculating Thickness</h6>
        </div>
        <!-- Card Content - Collapse -->
        <div class="card-body">
            <!-- <form action="" method="post"> -->
            <div class="row mb-3">
                <div class="col-3">
                    <label for="gramatur2" class="col-form-label">Product Gramature</label>
                    <div class="input-group">
                        <!-- Item code -->
                        <input type="number" class="form-control" id="gramatur2" name="gramatur2" onkeyup="javascript:calculate(this.value, obj('width2').value, obj('folding2').value)">
                        <div class="input-group-append">
                            <span class="input-group-text">gr/m</span>
                        </div>
                        <?= form_error('gramatur2', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="col-3">
                    <label for="width2" class="col-form-label">Width</label>
                    <div class="input-group">
                        <!-- Item code -->
                        <input type="number" class="form-control" id="width2" name="width2" onkeyup="javascript:calculate(obj('gramatur2').value, this.value, obj('folding2').value)">
                        <div class="input-group-append">
                            <span class="input-group-text">cm</span>
                        </div>
                        <?= form_error('width2', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="col-3">
                    <label for="folding2" class="col-form-label">Folding</label>
                    <div class="input-group">
                        <!-- Item code -->
                        <input type="number" class="form-control" id="folding2" name="folding2" onkeyup="javascript:calculate(obj('gramatur2').value, obj('width2').value, this.value)">
                        <div class="input-group-append">
                            <span class="input-group-text">cm</span>
                        </div>
                        <?= form_error('folding2', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="col-3">
                    <label for="std_gram2" class="col-form-label">Gramature</label>
                    <div class="input-group">
                        <!-- Item code -->
                        <input type="currency" class="form-control" id="std_gram2" name="std_gram2" value="<?= $std_gramature ?>" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text">gram/cm</span>
                        </div>
                        <?= form_error('std_gram2', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
            </div>
            <!-- <button class="btn-add-item btn btn-primary mb-3" type="submit" onclick="javascript:calculate(obj('gramatur2').value, obj('width2').value, obj('folding2').value)">Calculate</button> -->
            <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="folding2" class="col-form-label">Thickness</label>
                    <div class="input-group">
                        <!-- Item thickness -->
                        <input type="text" class="form-control" id="thickness_result" name="thickness_result" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text">mm</span>
                        </div>
                        <?= form_error('thickness_result', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    Gramatur<input type="text" class="form-control" id="gramatur_show" name="gramatur_show" readonly>
                    Width<input type="text" class="form-control" id="width_show" name="width_show" readonly>
                    Folding<input type="text" class="form-control" id="folding_show" name="folding_show" readonly>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Main Content -->

<!-- Modal For Delete Data -->
<div class="modal fade" id="deleteItemProdOrder" tabindex="-1" role="dialog" aria-labelledby="deleteItemProdOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteItemProdOrderLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('production/delete_item') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- prod id -->
                        <label for="url" class="col-form-label">Production Order ID</label>
                        <input type="text" class="form-control" id="delete_po_id" name="delete_po_id" readonly>
                        <!-- item id -->
                        <label for="url" class="col-form-label" style="display:none">ID</label>
                        <input type="text" class="form-control" id="delete_id" name="delete_id" style="display:none" readonly>
                        <!-- item name -->
                        <label for="url" class="col-form-label">Item</label>
                        <input type="text" class="form-control" id="delete_name" name="delete_name" readonly>
                        <!-- item amount -->
                        <label for="url" class="col-form-label">Amount</label>
                        <input type="text" class="form-control" id="delete_amount" name="delete_amount" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>