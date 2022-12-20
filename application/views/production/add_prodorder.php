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
    <a href="<?= base_url('production/') ?>" class="btn btn-secondary btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left"></i>
        </span>
        <span class="text">Back</span>
    </a>

    <form action="<?= base_url('production/add_item_prod/') . $po_id . '/3/1' ?>" method="post">
        <div class="form-group">
            <!-- Item code -->
            <label for="po_id" class="col-form-label">Purchase Order ID</label>
            <input type="text" class="form-control mb-1" id="po_id" name="po_id" readonly value="<?= $po_id ?>">
            <?= form_error('po_id', '<small class="text-danger pl-2">', '</small>') ?>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <!-- Item categories -->
                    <label for="materialSelect" class="col-form-label">Add Material</label>
                    <select name="materialSelect" id="materialSelect" class="form-control" value="<?= set_value('materialSelect') ?>">
                        <option value="">--Select Categories--</option>
                        <?php foreach ($material as $mt) : ?>
                            <option value="<?= $mt['id'] ?>" data-price="<?= $mt['price'] ?>" data-stock="<?= $mt['in_stock'] ?>"><?= $mt['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('materialSelect', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="price" class="col-form-label">Price</label>
                    <input type="currency" class="form-control" id="price" name="price" value="<?= set_value('price'); ?>" readonly>
                    <?= form_error('price', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <!-- Material in stock -->
                    <label for="stock" class="col-form-label">In Stock</label>
                    <input type="text" class="form-control" id="stock" name="stock" readonly value="<?= set_value('stock'); ?>">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="amount" class="col-form-label">Amount</label>
                    <input type="text" class="form-control mb-1" id="amount" name="amount" placeholder="Input amount in kg..">
                    <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="description" class="col-form-label">Description</label>
                    <input type="text" class="form-control mb-1" id="description" name="description" placeholder="Product name/batch number">
                    <?= form_error('description', '<small class="text-danger pl-2">', '</small>') ?>
                    <small>Product name and batch number. Mandatory</small>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="item_desc" class="col-form-label">Item Description</label>
                    <input type="text" class="form-control mb-1" id="item_desc" name="item_desc" placeholder="Input description such as mix amount etc..">
                    <?= form_error('item_desc', '<small class="text-danger pl-2">', '</small>') ?>
                    <small>Optional</small>
                </div>
            </div>
        </div>

        <!-- <div class="row input-group mx-3 mt-3">
            <div class="form-group col-lg-5 mr-2">
                <text class="mb-1" for="roll-type">Goods</text>
                <select name="rolltype" id="rolltype" class="form-control">
                    <option value="">--Select [ROLL] Product--</option>
                    <?php foreach ($rollType as $rt) : ?>
                        <?php if ($rt['status'] != 7) {
                            continue;
                        } else {
                        }
                        ?>
                        <option class="#rolltype" value="<?= $rt['id'] ?>" data-code="<?= $rt['code'] ?>" data-weight="<?= $rt['weight'] ?>" data-lipatan="<?= $rt['lipatan'] ?>"><?= $rt['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-lg-2 mr-3">
                <text class="mb-1" for="code">Code</text>
                <input type="text" class="form-control" id="code" name="code" readonly>
            </div>
            <div class="form-group col-lg-2 mr-3">
                <text class="mb-1" for="weight">Weight</text>
                <input type="text" class="form-control" id="weight" name="weight" readonly>
            </div>
            <div class="form-group col-lg-2 mr-3">
                <text class="mb-1" for="lipatan">Lip</text>
                <input type="text" class="form-control" id="lipatan" name="lipatan" readonly>
            </div>
        </div> -->

        <input class="btn-add-item btn btn-primary mb-3" type="submit"></input>
        <p class="align-items-center">Data input are automatically saved.</p>
    </form>

    <div class="table-responsive my-3">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th class="text-right">Subtotal</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $temp = 0;
                $isTax = 0;
                $tax = 0;
                ?>
                <?php foreach ($material_selected as $ms) : ?>
                    <?php
                    if ($ms['transaction_id'] != $po_id) {
                        continue;
                    } else {
                    }
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= number_format($ms['outgoing'], 2, ',', '.'); ?></td>
                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                        <?php $subtotal = $ms['outgoing'] * $ms['price'] ?>
                        <td class="text-right"><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><?= $ms['item_desc'] ?></td>
                        <td>
                            <a data-toggle="modal" data-target="#deleteItemPOModal" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['outgoing'] ?>" class="badge badge-danger clickable">Delete</a>
                        </td>
                    </tr>
                    <?php $temp = $temp + $subtotal;
                    $i++;
                    ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="3"> </td>
                    <td class="right"><strong>Total</strong></td>
                    <?php $total = $temp; ?>
                    <td class="right">IDR <?= $this->cart->format_number($total, '2', ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="footer text-right">
        <!-- <a href="<?= base_url('production/delete_all_po/') . $po_id ?>" class="btn text-danger">Close and delete data</a> -->
        <a data-toggle="modal" data-target="#deletePOModal" data-po="<?= $po_id ?>" class="btn text-danger">Close and delete data</a>
        <a href="<?= base_url('production/') ?>" class="btn btn-primary">Save Order</a>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal For Delete Data -->
<div class="modal fade" id="deleteItemPOModal" tabindex="-1" role="dialog" aria-labelledby="deleteItemPOModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteItemPOModalLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('production/delete_item') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- item id -->
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
<div class="modal fade" id="deletePOModal" tabindex="-1" role="dialog" aria-labelledby="deletePOModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePOModalLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">Closing this window will delete all production order data you've entered. Are you sure?</p>
            <form action="<?= base_url('production/delete_all_po/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- item id -->
                        <label for="url" class="col-form-label">Production Order ID</label>
                        <input type="text" class="form-control" id="delete_po_id" name="delete_po_id" readonly>
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