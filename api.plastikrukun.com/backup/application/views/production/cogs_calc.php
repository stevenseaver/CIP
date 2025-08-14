<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    
    <!-- delete button -->
    <a href="<?= base_url('production/delete_cogs_data') ?>" class="btn btn-danger btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-eraser"></i>
        </span>
        <span class="text">Clear Data</span>
    </a>

    <!-- Button to add Item -->
    <a href="" class="btn btn-primary btn-icon-split mb-3 mx-3" data-toggle="modal" data-target="#newItem">
        <span class="icon text-white-50">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Item</span>
    </a>

    <!-- Modal for add items -->
    <div class="modal fade" id="newItem" tabindex="-1" aria-labelledby="newItemLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newItemLabel">Add New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="display:none">ID</th>
                                        <th>Material Item</th>
                                        <th>Code</th>
                                        <th>Stock</th>
                                        <th>Unit</th>
                                        <th>Unit Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    $temp = 0; ?>
                                    <?php foreach ($material as $fs) : ?>
                                        <tr>
                                            <td style="display:none" class="id"><?= $fs['id'] ?></td>
                                            <td class="name"><?= $fs['name'] ?></td>
                                            <td class="code"><?= $fs['code'] ?></td>
                                            <td class="in_stock"><?= number_format($fs['in_stock'], 2, ',', '.');?></td>
                                            <td class="unit"><?= $fs['unit_satuan']; ?></td>
                                            <td class="price"><?= $fs['price']; ?></td>
                                            <td>
                                                <!-- link this with a javascript -->
                                                <a data-dismiss="modal" type="button" class="select-item-cogs badge badge-primary">Add</a> 
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="<?= base_url('production/cogs_calculator/') ?>" method="post">
        <div class="row">
            <!-- <div class="col-lg-6"> -->
                <!-- <div class="form-group"> -->
                    <!-- Item categories -->
                    <label for="materialSelect" class="col-form-label"  style="display:none">Material ID</label>
                    <input type="text" class="form-control" id="materialSelect" name="materialSelect" readonly value="<?= set_value('materialSelect'); ?>"  style="display:none">
                    <?= form_error('materialSelect', '<small class="text-danger pl-2">', '</small>') ?>
                <!-- </div> -->
            <!-- </div> -->
            <div class="col-lg-6">
                <div class="form-group">
                    <!-- Item categories -->
                    <label for="materialName" class="col-form-label">Material Name</label>
                    <input type="text" class="form-control" id="materialName" name="materialName" readonly value="<?= set_value('materialName'); ?>">
                    <?= form_error('materialName', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="price" class="col-form-label">Price</label>
                    <input type="currency" class="form-control" id="price" name="price" value="<?= set_value('price'); ?>" readonly>
                    <?= form_error('price', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Material in stock -->
                    <label for="stock" class="col-form-label">In Stock</label>
                    <input type="text" class="form-control" id="stock" name="stock" readonly value="<?= set_value('stock'); ?>">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="amount" class="col-form-label">Amount</label>
                    <div class="input-group">
                        <input type="number" step=".01" min="0" max="10" class="form-control" id="amount" name="amount" placeholder="Input amount in kg..">
                        <div class="input-group-append">
                            <span class="input-group-text">kg</span>
                        </div>
                    </div>
                    <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
        </div>
        <input class="btn-add-item btn btn-primary mb-3" type="submit"></input>
    </form>
    
    <div class="table-responsive my-3">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th>Subtotal</th>
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
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><input id="materialAmount-<?= $ms['id'] ?>" class="cogs-qty text-left form-control" data-id="<?= $ms['id']; ?>" value="<?= number_format($ms['amount_used'], 2, '.', ','); ?>"></td>
                        <td><input id="materialPrice-<?= $ms['id'] ?>" class="cogs-price text-left form-control" data-id="<?= $ms['id']; ?>" value="<?= number_format($ms['price_per_unit'], 0, '.', ','); ?>"></td>
                        <?php $subtotal = $ms['amount_used'] * $ms['price_per_unit'] ?>
                        <td class=" text-right"><?= number_format($subtotal, 2, '.', ','); ?></td>
                        <td><a href="<?= base_url('production/delete_cogs_item/') . $ms['id'] ?>" class="badge badge-danger clickable">Delete</a></td>
                    </tr>
                    <?php $temp = $temp + $subtotal;
                    $i++;
                    ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="4"> </td>
                    <td class="right"><strong>Total Price</strong></td>
                    <?php $total = $temp; ?>
                    <td class="right">IDR <?= $this->cart->format_number($total, '2', '.', ','); ?></td>
                </tr>
                <tr class="align-items-center text-primary font-weight-bold">
                    <td colspan="4"> </td>
                    <td class="right"><strong>COGS/Kg</strong></td>
                    <?php $cogs = $total / 10; ?>
                    <td class="right">IDR <?= $this->cart->format_number($cogs, '2', '.', ','); ?></td>
                </tr>
            </tfoot>
        </table>
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