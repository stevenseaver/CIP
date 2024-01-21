<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-dark"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newProdItem">
        <span class="icon text-white-50">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Item</span>
    </a>

    <a href="<?= base_url('inventory/pdf_prod') ?>" target="_blank" class="btn btn-success btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-file-earmark-pdf"></i>
        </span>
        <span class="text">View PDF</span>
    </a>

    <div class="card border-left-primary mb-3">
        <div class="row mx-4 my-3">
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Roll</th>
                                <th>Code</th>
                                <th>Gramature</th>
                                <th>Lip (cm)</th>
                                <th>Stock (Kg)</th>
                                <th>Price</th>
                                <th>Value</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            $temp = 0;
                            ?>
                            <?php foreach ($rollStock as $rs) : ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $rs['name'] ?></td>
                                    <td><?= $rs['code'] ?></td>
                                    <td><?= $rs['weight'] ?></td>
                                    <td><?= $rs['lipatan'] ?></td>
                                    <td><?= number_format($rs['in_stock'], 2, ',', '.') ?></td>
                                    <td><?= number_format($rs['price'], 2, ',', '.') ?></td>
                                    <?php $value = $rs['price'] * $rs['in_stock'];
                                    $temp = $temp + $value;  ?>
                                    <td><?= number_format($value, 0, ',', '.') ?></td>
                                    <td><?= $rs['status_name'] ?></td>
                                    <td>
                                        <a href="<?= base_url('inventory/prod_details/') . $rs['id'] ?>" class="badge badge-primary"><i class="bi bi-info-circle-fill"> </i>Details</a>
                                        <a data-toggle="modal" data-target="#editProdModal" data-name="<?= $rs['name'] ?>" data-code="<?= $rs['code'] ?>" data-weight="<?= $rs['weight'] ?>" data-cogs="<?= $rs['price'] ?>" data-lip="<?= $rs['lipatan'] ?>" class="badge badge-warning"><i class="bi bi-pencil-fill"> </i>Edit</a>
                                        <a data-toggle="modal" data-target="#deleteProdModal" data-name="<?= $rs['name'] ?>" data-code="<?= $rs['code'] ?>" class="badge badge-danger"><i class="bi bi-trash-fill"> </i>Delete</a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="align-items-center">
                                <td colspan="6"> </td>
                                <td class="text-right"><strong>Total</strong></td>
                                <?php $grandTotal = $temp; ?>
                                <td class="">IDR <?= $this->cart->format_number($grandTotal, '-', ',', '.'); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal For Add Data -->
<div class="modal fade" id="newProdItem" tabindex="-1" aria-labelledby="newProdItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newProdItemModalLabel">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/add_production') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Material name -->
                        <label for="url" class="col-form-label">Item Name</label>
                        <input type="text" class="form-control mb-1" id="name" name="name" placeholder="Add new item">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Material code -->
                        <label for="url" class="col-form-label">Code</label>
                        <input type="text" class="form-control mb-1" id="code" name="code" placeholder="Material code">
                        <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                        <small class="text-danger">Item code are permanent, make sure they are correct.</small>
                    </div>
                    <div class="form-group">
                        <!-- Material code -->
                        <label for="cogs" class="col-form-label">Production Cost</label>
                        <input type="text" class="form-control mb-1" id="cogs" name="cogs" placeholder="Production cost">
                        <?= form_error('cogs', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Material weight/m -->
                        <label for="url" class="col-form-label">Grammage</label>
                        <input type="text" class="form-control mb-1" id="weightperm" name="weightperm" placeholder="Add weight per unit">
                        <?= form_error('weightperm', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Lipatan -->
                        <label for="url" class="col-form-label">Folding</label>
                        <input type="text" class="form-control mb-1" id="lipatan" name="lipatan" placeholder="Add plastic folding">
                        <?= form_error('lipatan', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Material initial stock -->
                        <label for="url" class="col-form-label">Initial Stock</label>
                        <input type="text" class="form-control mb-1" id="initial_stock" name="initial_stock" placeholder="Add initial stock in kilograms">
                        <?= form_error('initial_stock', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Warehouse -->
                        <label for="url" class="col-form-label">Warehouse</label>
                        <input type="warehouse" class="form-control mb-1" id="warehouse" name="warehouse" placeholder="Production" value="2" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal For Edit Data -->
<div class="modal fade" id="editProdModal" tabindex="-1" aria-labelledby="editProdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProdModalLabel">Edit Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/edit_prod') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Material name -->
                        <label for="name" class="col-form-label">Item Name</label>
                        <input type="text" class="form-control mb-1" id="name" name="name">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Material code -->
                        <label for="code" class="col-form-label">Code</label>
                        <input type="text" class="form-control mb-1" id="code" name="code" readonly>
                        <small>You can't change item's code.</small>
                        <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Material code -->
                        <label for="cogs" class="col-form-label">Production Cost</label>
                        <input type="text" class="form-control mb-1" id="cogs" name="cogs" placeholder="Production cost">
                        <?= form_error('cogs', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Material weight/m -->
                        <label for="grammage" class="col-form-label">Grammage</label>
                        <input type="text" class="form-control mb-1" id="grammage" name="grammage">
                        <?= form_error('grammage', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Lipatan -->
                        <label for="lipatan" class="col-form-label">Folding</label>
                        <input type="text" class="form-control mb-1" id="lipatan" name="lipatan">
                        <?= form_error('lipatan', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal For Delete Data -->
<div class="modal fade" id="deleteProdModal" tabindex="-1" aria-labelledby="deleteProdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProdModalLabel">Delete Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/delete_prod') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Asset Name -->
                        <label for="url" class="col-form-label">Item Name</label>
                        <input type="text" class="form-control mb-1" readonly id="name" name="name" placeholder="Item Name">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset Code -->
                        <label for="url" class="col-form-label">Item Code</label>
                        <input type="text" readonly class="form-control mb-1" id="code" name="code" placeholder="Item Code">
                        <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
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