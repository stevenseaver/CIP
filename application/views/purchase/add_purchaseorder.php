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
    <a href="<?= base_url('purchasing/') ?>" class="btn btn-white btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left text-dark"></i>
        </span>
        <span class="text text-dark">Back</span>
    </a>

    <!-- Button to add Item -->
    <a href="" class="btn btn-primary btn-icon-split mb-3 mx-1" data-toggle="modal" data-target="#newItem">
        <span class="icon text-white-50">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Item</span>
    </a>

    <!-- Button to add customer -->
    <a href="" class="btn btn-light btn-icon-split mb-3" data-toggle="modal" data-target="#newSupplier">
        <span class="icon text-white-50">
            <i class="fas fa-fw fa-user-plus"></i>
        </span>
        <span class="text">Select Supplier</span>
    </a>

    <form action="<?= base_url('purchasing/add_item_po/') . $po_id . '/8/1' ?>" method="post">
        <div class="row">
            <?php if($existing_date){ ?>
                <div class="col-lg-12">
                    <div class="form-group">
                        <!-- Item code -->
                        <label for="po_id" class="col-form-label">Purchase Order ID</label>
                        <input type="text" class="form-control mb-1" id="po_id" name="po_id" readonly value="<?= $po_id ?>">
                        <?= form_error('po_id', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="col-lg-6" style="display:none">
                    <div class="form-group">
                        <label for="po_date" class="col-form-label">Date</label>
                        <input readonly type="text" class="form-control" id="po_date" name="po_date" value="<?= $existing_date ?>">
                        <?= form_error('po_date', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-lg-6">
                    <div class="form-group">
                        <!-- Item code -->
                        <label for="po_id" class="col-form-label">Purchase Order ID</label>
                        <input type="text" class="form-control mb-1" id="po_id" name="po_id" readonly value="<?= $po_id ?>">
                        <?= form_error('po_id', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="po_date" class="col-form-label">Date</label>
                        <input type="datetime-local" class="form-control" id="po_date" name="po_date" value="<?= set_value('po_date'); ?>">
                        <?= form_error('po_date', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
            <?php };?>
        </div>
        <!-- <div class="form-group">
            <label for="supplier" class="col-form-label">Supplier</label>
            <select name="supplier" id="supplier" class="form-control" value="<?= set_value('supplier') ?>">
                <option value="">--Select Supplier--</option>
                <?php foreach ($supplier as $sup) : ?>
                    <option value="<?= $sup['id'] ?>" data-term="<?= $sup['multiplier'] ?>"><?= $sup['supplier_name'] ?></option>
                <?php endforeach; ?>
            </select>
            <?= form_error('supplier', '<small class="text-danger pl-2">', '</small>') ?>
        </div> -->
        <div class="row">
            <div class="col-lg-10">
                <div class="form-group">
                    <!-- Customer Name -->
                    <label for="sup_name" class="col-form-label">Supplier</label>
                    <?php if ($input_sup_name) { ?>
                        <input type="text" class="form-control" id="sup_name" name="sup_name" readonly value="<?= $input_sup_name; ?>">
                    <?php } else { ?>
                        <input type="text" class="form-control" id="sup_name" name="sup_name" readonly value="<?= set_value('sup_name'); ?>">
                    <?php } ?>
                    <?= form_error('sup_name', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-1">
                <div class="form-group">
                    <!-- customer ID -->
                    <label for="sup_id" class="col-form-label">ID</label>
                    <?php if ($input_sup_id) { ?>
                        <input type="text" class="form-control" id="sup_id" name="sup_id" readonly value="<?= $input_sup_id ?>">
                    <?php } else { ?>
                        <input type="text" class="form-control" id="sup_id" name="sup_id" readonly value="<?= set_value('sup_id'); ?>">
                    <?php } ?>
                    <?= form_error('sup_id', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-1">
                <div class="form-group">
                    <!-- customer address -->
                    <label for="term" class="col-form-label">Term</label>
                    <?php if ($input_sup_term) { ?>
                        <input type="text" class="form-control" id="term" name="term" readonly value="<?= $input_sup_term ?>">
                    <?php } else { ?>
                        <input type="text" class="form-control" id="term" name="term" readonly value="<?= set_value('term'); ?>">
                    <?php } ?>
                    <?= form_error('term', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <!-- Item categories -->
                    <label for="materialName" class="col-form-label">Material Name</label>
                    <input type="text" class="form-control" id="materialName" name="materialName" readonly value="<?= set_value('materialName'); ?>">
                    <?= form_error('materialName', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-0" style="display:none">
                <div class="form-group">
                    <!-- Item categories -->
                    <label for="material" class="col-form-label">ID</label>
                    <input type="text" class="form-control" id="material" name="material" readonly value="<?= set_value('material'); ?>">
                    <?= form_error('material', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="price" class="col-form-label">Price</label>
                    <input type="currency" class="form-control mb-1" id="price" name="price" placeholder="Input price">
                    <?= form_error('price', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="amount" class="col-form-label">Amount</label>
                    <!-- <input type="text" class="form-control mb-1" id="amount" name="amount" placeholder="Input amount.."> -->
                    <div class="input-group">
                        <input type="number" class="form-control" id="amount" name="amount" step=".01">
                        <div class="input-group-append">
                            <span class="input-group-text" id="unit_amount"></span>
                        </div>
                    </div>
                    <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Transaction with tax? -->
                    <label for="tax" class="col-form-label">Tax</label>
                    <select name="tax" id="tax" class="form-control" value="<?= set_value('tax') ?>">
                        <option value="">--Select Categories--</option>
                        <option value="0">No Tax</option>
                        <option value="1">With Tax</option>
                    </select>
                    <?= form_error('tax', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <!-- <div class="col-lg-1">
                <div class="form-group"> -->
                    <!-- Terms -->
                    <!-- <label for="term" class="col-form-label">Terms</label>
                    <input type="text" class="form-control mb-1" id="term" name="term" readonly>
                    <?= form_error('term', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div> -->
            <div class="col-lg-6">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="description" class="col-form-label">Reference</label>
                    <i type="button" class="small text-primary bi bi-question-circle" data-toggle="tooltip" data-placement="right" title="Isi dengan nomor dokumen AM">
                    </i>
                    <input type="text" class="form-control mb-1" id="description" name="description" placeholder="Input description..">
                    <?= form_error('description', '<small class="text-danger pl-2">', '</small>') ?>
                    <small>Weighting Document Number. Optional</small>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="item_desc" class="col-form-label">Item Description</label>
                    <i type="button" class="small text-primary bi bi-question-circle" data-toggle="tooltip" data-placement="right" title="Fill with sack amount">
                    </i>
                    <input type="text" class="form-control mb-1" id="item_desc" name="item_desc" placeholder="Input item description..">
                    <?= form_error('item_desc', '<small class="text-danger pl-2">', '</small>') ?>
                    <small>Sack amount. Optional</small>
                </div>
            </div>
        </div>
        <input class="btn-add-item btn btn-primary mb-3" type="submit"></input>
        <p class="align-items-center">Data input are automatically saved.</p>
    </form>

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
                                    <?php foreach ($inventory_wh as $fs) : ?>
                                        <tr>
                                            <td style="display:none" class="id"><?= $fs['id'] ?></td>
                                            <td class="name"><?= $fs['name'] ?></td>
                                            <td class="code"><?= $fs['code'] ?></td>
                                            <td class="in_stock"><?= number_format($fs['in_stock'], 3, ',', '.');?></td>
                                            <td class="unit"><?= $fs['unit_satuan']; ?></td>
                                            <td class="price"><?= $fs['price']; ?></td>
                                            <td>
                                                <!-- link this with a javascript -->
                                                <a data-dismiss="modal" type="button" class="select-item-po badge badge-primary"><i class="bi bi-plus"> </i>Add</a> 
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

    <div class="table-responsive my-3">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th class="text-right">Subtotal</th>
                    <th>Reference</th>
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
                <?php foreach ($inventory_selected as $ms) : ?>
                    <?php
                    if ($ms['transaction_id'] != $po_id) {
                        continue;
                    } else {
                    }
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $ms['name'] ?></td>
                        <!-- <td><?= number_format($ms['incoming'], 2, ',', '.'); ?></td> -->
                        <td style="width: 150px"><input id="receiveAmount-<?= $ms['id'] ?>" class="edit-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-transID="<?= $ms['transaction_id']; ?>" value="<?= number_format($ms['incoming'], 2, ',', '.'); ?>"></td>
                        <!-- <td><?= number_format($ms['price'], 2, ',', '.'); ?></td> -->
                        <td style="width: 200px"><input id="editPriceOrder-<?= $ms['id'] ?>" class="edit-POprice text-left form-control" data-id="<?= $ms['id']; ?>" data-transID="<?= $ms['transaction_id']; ?>" value="<?= number_format($ms['price'], 2, ',', '.'); ?>"></td>
                        <?php $subtotal = $ms['incoming'] * $ms['price']; ?>
                        <td class="text-right"><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td style="width: 200px"><input id="editPOrder-<?= $ms['id'] ?>" class="edit-po text-left form-control" data-id="<?= $ms['id']; ?>" data-transID="<?= $ms['transaction_id']; ?>" value="<?= $ms['description']; ?>"></td>
                        <td><?= $ms['item_desc']; ?></td>
                        <td>
                            <a data-toggle="modal" data-target="#deleteItemPOModal" data-po="<?= $po_id ?>" data-id="<?= $ms['id']; ?>" data-name="<?= $ms['name']; ?>" data-amount="<?= $ms['incoming']; ?>" class="badge badge-danger clickable"><i class="bi bi-trash-fill"> </i>Delete</a>
                        </td>
                    </tr>
                    <?php $temp = $temp + $subtotal;
                    $i++;

                    $data['purchase_tax'] = $this->db->get_where('settings', ['parameter' => 'purchase_tax'])->row_array();
                    $purchase_tax = $data['purchase_tax']['value'];

                    if ($ms['tax'] == 1) {
                        $tax = $purchase_tax;
                    } else {
                        $tax = 0;
                    } ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="3"> </td>
                    <td class="right"><strong>Total</strong></td>
                    <?php $total = $temp; ?>
                    <td class="right">IDR <?= number_format($total, '2', ',', '.'); ?></td>
                </tr>
                <tr class="align-items-center">
                    <td colspan="3"> </td>
                    <td class="right"><strong>Tax <?= $tax ?>%</strong></td>
                    <?php
                    $total_tax = $tax / 100 * $total;
                    $grandTotal = $total + $total_tax; ?>
                    <td class="right">IDR <?= number_format($total_tax, '2', ',', '.'); ?></td>
                </tr>
                <tr class="align-items-center">
                    <td colspan="3"> </td>
                    <td class="right"><strong>Grand Total</strong></td>
                    <td class="right">IDR <?= number_format($grandTotal, '2', ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="footer text-right mb-3">
        <!-- <a href="<?= base_url('purchasing/delete_all_po/') . $po_id ?>" class="btn text-danger">Close and delete data</a> -->
        <a data-toggle="modal" data-target="#deletePOModal" data-po="<?= $po_id ?>" class="btn text-danger">Close and delete data</a>
        <a href="<?= base_url('purchasing/') ?>" class="btn btn-primary">Save PO</a>
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
            <form action="<?= base_url('purchasing/delete_item') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- item id -->
                        <label for="url" class="col-form-label">PO ID</label>
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
            <p class="mx-3 mt-3 mb-0">Closing this window will delete all PO data you've entered. Are you sure?</p>
            <form action="<?= base_url('purchasing/delete_all_po/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- item id -->
                        <label for="url" class="col-form-label">PO ID</label>
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

<!-- Modal for supplier -->
<div class="modal fade" id="newSupplier" tabindex="-1" aria-labelledby="newSupplierLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSupplierLabel">Add New Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table2 table-responsive">
                    <div class="table-responsive">
                        <table class="table table-hover" id="table2" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Supplier</th>
                                    <th>ID</th>
                                    <th>Term</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                $temp = 0; ?>
                                <?php foreach ($supplier as $cd) : ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td class="supplier_name"><?= $cd['supplier_name'] ?></td>
                                        <td class="supplier_id"><?= $cd['id'] ?></td>
                                        <td class="supplier_term"><?= $cd['multiplier'] ?></td>
                                        <td>
                                            <!-- link this with a javascript -->
                                            <a data-dismiss="modal" type="button" class="select-supplier badge badge-primary">Add</a> 
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


<script>
    //js for setting purchase tax input onchange
    function change_purchase_tax($amount){
        window.location.href = "<?= site_url('admin/update_purchase_tax/');?>"+amount;
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    var table2 = $('#table2').DataTable({
        paging: false,
        select: {
            style: 'single'
        },
        columnDefs: [
            {
                targets:[0,1,2,3],
                orderable: true,
                searchable: true
            }
        ]

    });
</script>