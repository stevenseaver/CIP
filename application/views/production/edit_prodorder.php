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
    <a href="<?= base_url('production/') ?>" class="btn btn-white btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left text-dark"></i>
        </span>
        <span class="text text-dark">Back</span>
    </a>

    <div class="card rounded shadow border-0 mb-3">
        <div class="card-body mb-0">
            <p class="text-dark mb-1">Prod Order Ref : </p>
            <p class="text-dark font-weight-bold"> <?= $getID['transaction_id'] ?></p>
            <p class="text-dark mb-1">Date : </p>
            <p class="text-dark font-weight-bold"> <?= date('d F Y H:i:s', $getID['date']) ?></p>
            <p class="text-dark mb-1">Batch : </p>
            <p class="text-dark font-weight-bold"> <?= $getID['description'] ?></p>
        </div>
    </div>

    <form action="<?= base_url('production/add_item_prod/') . $po_id . '/3/2' ?>" method="post">
        <div class="form-group">
            <!-- Item code -->
            <label for="po_id" class="col-form-label">Production Order ID</label>
            <input type="text" class="form-control mb-1" id="po_id" name="po_id" readonly value="<?= $po_id ?>">
            <?= form_error('po_id', '<small class="text-danger pl-2">', '</small>') ?>
        </div>

        <div class="row">
            <div class="col-lg-6">
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
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="price" class="col-form-label">Price</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="currency" class="form-control" id="price" name="price" value="<?= set_value('price'); ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Material in stock -->
                    <label for="stock" class="col-form-label">In Stock</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="stock" name="stock" readonly value="<?= set_value('stock'); ?>">
                        <div class="input-group-append">
                            <span class="input-group-text">kg</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Item amount -->
                    <label for="amount" class="col-form-label">Amount</label>
                    <div class="input-group">
                        <!-- Item code -->
                        <input type="number" step=".1" class="form-control" id="amount" name="amount" value="<?= set_value('amount'); ?>" placeholder="Use amount">
                        <div class="input-group-append">
                            <span class="input-group-text">kg</span>
                        </div>
                        <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <!-- Item desc -->
                    <label for="description" class="col-form-label">Description</label>
                    <input type="text" class="form-control mb-1" id="description" name="description" placeholder="Product name/batch number">
                    <?= form_error('description', '<small class="text-danger pl-2">', '</small>') ?>
                    <small>Product name and batch number. Mandatory</small>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <!-- Item mix amount -->
                    <label for="campuran" class="col-form-label">Mixing Formula</label>
                    <input type="number" min="1" max="100" class="form-control mb-1" id="campuran" name="campuran" placeholder="Mix amount">
                    <?= form_error('campuran', '<small class="text-danger pl-2">', '</small>') ?>
                    <small>Formula mixing number (x10 kg). Mandatory</small>
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
                    <th>No</th>
                    <th>Item</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th class="text-right">Subtotal</th>
                    <th>Mix Amount</th>
                    <th>Formula</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $temp = 0;
                $temp2 = 0;
                $isTax = 0;
                $tax = 0;
                ?>
                <?php foreach ($material_selected as $ms) : ?>
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
                        <!-- <td><?= number_format($ms['outgoing'], 2, ',', '.'); ?></td> -->
                        <td><input id="materialAmount-<?= $ms['id'] ?>" class="material-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-prodID="<?= $ms['transaction_id'] ?>" value="<?= number_format($ms['outgoing'], 2, ',', '.'); ?>"></td>
                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                        <?php $subtotal = $ms['outgoing'] * $ms['price'] ?>
                        <td class="text-right"><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><?= $ms['item_desc'] ?></td>
                        <td><?= $formula ?></td>
                        <td>
                            <a data-toggle="modal" data-target="#deleteItemProdOrder" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['outgoing'] ?>" class="badge badge-danger clickable">Delete</a>
                        </td>
                    </tr>
                    <?php $temp = $temp + $subtotal; 
                    $temp2 = $temp2 + $ms['outgoing'];
                    $i++; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="3"> </td>
                    <td class="right"><strong>Total</strong></td>
                    <?php $total = $temp; ?>
                    <td class="right">IDR <?= $this->cart->format_number($total, '2', ',', '.'); ?></td>
                    <?php if ($temp2 != 0) {
                            $hpp = $total/$temp2;
                        } else { 
                            $hpp = 0;
                        } ?>
                    <td class="right"><strong>Cost of Materials</strong></td>
                    <td class="text-left">IDR <?= $this->cart->format_number($hpp, '2', ',', '.'); ?></td>
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
            <form action="<?= base_url('production/delete_item_prod_order') ?>" method="post">
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
            <form action="<?= base_url('production/delete_all_prod_order/') ?>" method="post">
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