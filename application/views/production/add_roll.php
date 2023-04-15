<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <!-- back button -->
    <a href="<?= base_url('production/inputRoll') ?>" class="btn btn-white btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left text-dark"></i>
        </span>
        <span class="text text-dark">Back</span>
    </a>

    <form action="<?= base_url('production/add_roll_item/') . $po_id . '/2/2/' ?>" method="post">
        <div class="form-group">
            <!-- Item code -->
            <label for="po_id" class="col-form-label">Production Order ID</label>
            <input type="text" class="form-control mb-1" id="po_id" name="po_id" readonly value="<?= $po_id ?>">
            <?= form_error('po_id', '<small class="text-danger pl-2">', '</small>') ?>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <!-- Item categories -->
                    <label for="rollSelect" class="col-form-label">Add Roll</label>
                    <select name="rollSelect" id="rollSelect" class="form-control" value="<?= set_value('rollSelect') ?>">
                        <option value="">--Select Categories--</option>
                        <?php foreach ($rollSelect as $rt) : ?>
                            <option value="<?= $rt['name'] ?>" data-weight="<?= $rt['weight'] ?>" data-lipatan="<?= $rt['lipatan'] ?>" data-code="<?= $rt['code'] ?>"><?= $rt['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('rollSelect', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="weight" class="col-form-label">Weight</label>
                    <input type="text" class="form-control" id="weight" name="weight" value="<?= set_value('weight'); ?>" readonly>
                    <?= form_error('weight', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <!-- Material in stock -->
                    <label for="lipatan" class="col-form-label">Lipatan</label>
                    <input type="text" class="form-control" id="lipatan" name="lipatan" readonly value="<?= set_value('lipatan'); ?>">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Material in stock -->
                    <label for="code" class="col-form-label">Code</label>
                    <input type="text" class="form-control" id="code" name="code" readonly value="<?= set_value('code'); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="amount" class="col-form-label">Amount</label>
                    <input type="number" class="form-control mb-1" id="amount" name="amount" placeholder="Input amount in kg..">
                    <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="batch" class="col-form-label">Batch</label>
                    <input type="text" class="form-control mb-1" id="batch" name="batch" placeholder="Product name/batch number">
                    <?= form_error('batch', '<small class="text-danger pl-2">', '</small>') ?>
                    <small>Batch number. Mandatory</small>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="roll_no" class="col-form-label">Roll Number</label>
                    <input type="number" class="form-control mb-1" id="roll_no" name="roll_no" placeholder="Input roll number..">
                    <?= form_error('roll_no', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
        </div>
        <input class="btn-add-item btn btn-primary mb-3" type="submit"></input>
        <p class="align-items-center">Data input are automatically saved.</p>
    </form>


    <div class="table-responsive my-3">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <div class="h5 text-primary">Materials</div>
                    <th>No</th>
                    <th>Item</th>
                    <th>Amount Used (Kg)</th>
                    <th>Price (IDR)</th>
                    <th class="text-right">Subtotal (IDR)</th>
                    <th>Mix Amount</th>
                    <th>Formula</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $temp = 0;
                $temp_weight= 0;
                ?>
                <?php foreach ($inventory_selected as $ms) : ?>
                    <?php
                    if ($ms['transaction_id'] != $po_id) {
                        continue;
                    } else {
                    }
                    $formula = $ms['outgoing']/($ms['item_desc']*10)
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= number_format($ms['outgoing'], 2, ',', '.'); ?></td>
                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                        <?php $subtotal = $ms['outgoing'] * $ms['price'] ?>
                        <td class="text-right"><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><?= $ms['item_desc'] ?></td>
                        <td><?= $formula ?></td>
                    </tr>
                    <?php $temp = $temp + $subtotal; 
                    $temp_weight = $temp_weight + $ms['outgoing'] ?>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="1"> </td>
                    <td class="text-right"><strong>Total Weight</strong></td>
                    <?php $totalWeight = $temp_weight; ?>
                    <td class="text-left"><?= $this->cart->format_number($totalWeight, '2', ',', '.'); ?> kg</td>
                    <td class="text-right"><strong>Total</strong></td>
                    <?php $total = $temp; ?>
                    <td class="text-right">IDR <?= $this->cart->format_number($total, '2', ',', '.'); ?></td>
                    <td class="text-right"><strong>Cost of Materials</strong></td>
                    <?php $hpp = $total/$temp_weight; ?>
                    <td class="text-right">IDR <?= $this->cart->format_number($hpp, '2', ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="table-responsive my-3">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <div class="h5 text-primary">Rolls</div>
                    <th>No</th>
                    <th>Item</th>
                    <th>Code</th>
                    <th>Weight</th>
                    <th>Lipatan</th>
                    <th>Amount</th>
                    <th>Batch</th>
                    <th>Roll Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $temp = 0;
                $percent_waste = 0;
                ?>
                <?php foreach ($rollType as $ms) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= $ms['code'] ?></td>
                        <td><?= $ms['weight'] ?></td>
                        <td><?= $ms['lipatan'] ?></td>
                        <td><?= number_format($ms['incoming'], 2, ',', '.'); ?> kg</td>
                        <!-- <td><input id="materialAmount-<?= $ms['id'] ?>" class="material-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-prodID="<?= $ms['transaction_id'] ?>" value="<?= number_format($ms['incoming'], 2, ',', '.'); ?>"></td> -->
                        <td><?= $ms['batch'] ?></td>
                        <td><?= $ms['transaction_desc'] ?></td>
                        <td>
                            <a data-toggle="modal" data-target="#deleteItemProdOrder" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['incoming'] ?>" class="badge badge-danger clickable">Delete</a>
                        </td>
                    </tr>
                    <?php $temp = $temp + $ms['incoming'];
                    $i++;
                    ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="4"> </td>
                    <td class="text-left"><strong>Total Weight</strong></td>
                    <?php $total = $temp; ?>
                    <td class="text-left"><?= $this->cart->format_number($total, '2', ',', '.'); ?> kg</td>
                    <td class="text-left"><strong>Waste</strong></td>
                    <?php $waste = $temp-$totalWeight;
                    $percent_waste = ($waste / $totalWeight) * 100 ?>
                    <td class="text-left"><?= $this->cart->format_number($waste, '2', ',', '.'); ?> kg or <?= $this->cart->format_number($percent_waste, '2', ',', '.'); ?>%</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="footer text-right">
        <!-- <a href="<?= base_url('production/delete_all_po/') . $po_id ?>" class="btn text-danger">Close and delete data</a> -->
        <a data-toggle="modal" data-target="#deleteRollModal" data-po="<?= $po_id ?>" class="btn text-danger">Close and delete data</a>
        <a href="<?= base_url('production/inputRoll') ?>" class="btn btn-primary">Save Order</a>
    </div>
</div>
<!-- /.container-fluid -->

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
            <form action="<?= base_url('production/delete_item_roll') ?>" method="post">
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

<!-- Modal For Delete Data -->
<div class="modal fade" id="deleteRollModal" tabindex="-1" role="dialog" aria-labelledby="deleteRollModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRollModalLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">Closing this window will delete all production order data you've entered. Are you sure?</p>
            <form action="<?= base_url('production/delete_all_roll/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- item id -->
                        <label for="url" class="col-form-label">Production Order ID</label>
                        <input type="text" class="form-control" id="delete_roll_id" name="delete_roll_id" readonly>
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