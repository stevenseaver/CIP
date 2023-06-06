<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <?php $std_gramature = 18; ?>

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
        <!-- Card Content -->
        <div class="card-body">
            <div class="row">
                <div class="col text-center mx-2 my-1">
                    <table class="table table-striped table-sm">
                        <div class="h5">Cutting Guideline</div>
                        <thead>
                            <tr>
                            <th scope="col">Plastic Width (cm)</th>
                            <th scope="col">Handle Length (typical, cm)</th>
                            <th scope="col">Cutting Width (typical, cm)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th scope="row">15</th>
                            <td>9</td>
                            <td>7 and 7.5</td>
                            </tr>
                            <tr>
                            <th scope="row">21, 24</th>
                            <td>10</td>
                            <td>11 for 21 | 14 for 24 </td>
                            </tr>
                            <tr>
                            <th scope="row">28</th>
                            <td>12</td>
                            <td>16 and 18</td>
                            </tr>
                            <tr>
                            <th scope="row">35</th>
                            <td>13</td>
                            <td>21.5</td>
                            </tr>
                            <tr>
                            <th scope="row">40</th>
                            <td>14</td>
                            <td>23.5, 24, and 24.5</td>
                            </tr>
                            <tr>
                            <th scope="row">50</th>
                            <td>17</td>
                            <td>32</td>
                            </tr>
                            <tr>
                            <th scope="row">55</th>
                            <td>18</td>
                            <td>39</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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
                <div class="col-lg-3">
                    <label for="price" class="col-form-label">Price per Kg</label>
                    <div class="input-group">
                        <!-- Item packaging weight -->
                        <input type="number" step="1" class="form-control" id="price" name="price" value="<?= set_value('price'); ?>">
                        <div class="input-group-append">
                            <span class="input-group-text">gram</span>
                        </div>
                        <?= form_error('price', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
            </div>
            <button class="btn-add-item btn btn-primary mb-3" type="submit" onclick="javascript:calculate_gramature(obj('width').value, obj('folding').value, obj('thickness').value, obj('handle_length').value, obj('cut_width').value, obj('length').value, obj('pcsperpack').value, obj('ppweight').value, obj('price').value)">Calculate</button>
            <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="prod_grammature" class="col-form-label">Production Gramature</label>
                    <div class="input-group">
                        <!-- Product Grammature -->
                        <input type="text" class="form-control" id="gramature_result" name="gramature_result" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text">gram/m</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <label for="prod_grammature" class="col-form-label">Item Weight</label>
                    <div class="input-group">
                        <!-- Item Weight -->
                        <input type="text" class="form-control" id="item_weight" name="item_weight" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text">gram/pcs</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <label for="prod_grammature" class="col-form-label">Gross Packed Goods Weight</label>
                    <div class="input-group">
                        <!-- Item Weight -->
                        <input type="text" class="form-control" id="gross_weight" name="gross_weight" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text">gram/pack</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <label for="prod_grammature" class="col-form-label">Goods Price</label>
                    <div class="input-group">
                        <!-- Item Weight -->
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" class="form-control" id="total_price" name="total_price" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Calculating width -->
    <script>
        function calculate_gramature(width, folding, thickness, handle_length, cut_width, length, pcsperpack, ppweight, price){
            var std_gramature = 18;
            //calculate gramature
            gramature = ((+width)+(2*folding))*thickness*18;
            obj("gramature_result").value = gramature.toFixed(3);
            //calculate weight per pcs after cut
            percent_cut = (handle_length*cut_width)/(((+width)+(2*folding))*length)*100;
            uncut_weight = (gramature/100)*length;
            cut_weight = uncut_weight - (uncut_weight*(percent_cut/100))
            obj("item_weight").value = cut_weight.toFixed(3);
            //calculate weight/pack for packed goods
            net_weight = cut_weight * pcsperpack;
            gross_weight = (+net_weight) + (+ppweight);
            obj("gross_weight").value = gross_weight.toFixed(3);
            //calculate price
            total_price = price * (gross_weight/1000);
            obj("total_price").value = total_price.toFixed(2);
        }


        function calculate(gramatur, width, folding)
        {
            var std_gramatur = 18;
            total_width = (+width)+2*folding;
            thickness = gramatur/total_width/std_gramatur;
            obj("thickness_result").value = thickness.toFixed(6);
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
                <div class="col-lg-3">
                    <label for="gramatur2" class="col-form-label">Product Gramature</label>
                    <div class="input-group">
                        <!-- Item code -->
                        <input type="number" min="1" class="form-control" id="gramatur2" name="gramatur2">
                        <div class="input-group-append">
                            <span class="input-group-text">gr/m</span>
                        </div>
                        <?= form_error('gramatur2', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="col-lg-3">
                    <label for="width2" class="col-form-label">Width</label>
                    <div class="input-group">
                        <!-- Item code -->
                        <input type="number" class="form-control" id="width2" name="width2">
                        <div class="input-group-append">
                            <span class="input-group-text">cm</span>
                        </div>
                        <?= form_error('width2', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="col-lg-3">
                    <label for="folding2" class="col-form-label">Folding</label>
                    <div class="input-group">
                        <!-- Item code -->
                        <input type="number" class="form-control" id="folding2" name="folding2">
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
            <button class="btn-add-item btn btn-primary mb-3" type="submit" onclick="javascript:calculate(obj('gramatur2').value, obj('width2').value, obj('folding2').value)">Calculate</button>
            <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="folding2" class="col-form-label">Thickness</label>
                    <div class="input-group">
                        <!-- Item thickness -->
                        <input type="text" class="form-control" id="thickness_result" name="thickness_result" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text">mm</span>
                        </div>
                    </div>
                </div>
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