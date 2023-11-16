<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-dark font-weight-bold"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newMaterial">
        <span class="icon text-white-50">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Item</span>
    </a>

    <a href="<?= base_url('inventory/material_category') ?>" class="btn btn-light btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-gear-wide-connected"></i>
        </span>
        <span class="text">Material Category Setting</span>
    </a>


    <div class="card border-left-primary mb-3">
        <div class="row mx-4 my-3">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Materials</th>
                            <th>Code</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Value</th>
                            <th>Supplier</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $temp = 0;
                        ?>
                        <?php foreach ($materialStock as $ms) : ?>
                            <?php
                            if ($ms['status'] != 7) {
                                continue;
                            } else {
                            }
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $ms['name'] ?></td>
                                <td><?= $ms['code'] ?></td>
                                <td><?= $ms['categories_name'] ?></td>
                                <td><?= number_format($ms['in_stock'], 2, ',', '.') . ' '. $ms['unit_satuan']; ?></td>
                                <td><?= number_format($ms['price'], 0, ',', '.'); ?></td>
                                <?php $value = $ms['price'] * $ms['in_stock'];
                                $temp = $temp + $value;  ?>
                                <td><?= number_format($value, 0, ',', '.') ?></td>
                                <td><?= $ms['supplier_name'] ?></td>
                                <td>
                                    <a href="<?= base_url('inventory/material_details/') . $ms['id'] ?>" class="badge badge-primary">Details</a>
                                    <a data-toggle="modal" data-target="#editMaterial" data-name="<?= $ms['name'] ?>" data-code="<?= $ms['code'] ?>" data-price="<?= $ms['price'] ?>" data-cat="<?= $ms['categories'] ?>" data-supplier="<?= $ms['supplier'] ?>" class="badge badge-warning clickable">Edit</a>
                                    <a data-toggle="modal" data-target="#deleteMaterialItem" data-name="<?= $ms['name'] ?>" data-code="<?= $ms['code'] ?>" class="badge badge-danger clickable">Delete</a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="align-items-center">
                            <td colspan="5"> </td>
                            <td class="text-right "><strong>Total</strong></td>
                            <?php $grandTotal = $temp; ?>
                            <td class="">IDR <?= $this->cart->format_number($grandTotal, '-', ',', '.'); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal For Add Data -->
<div class="modal fade" id="newMaterial" tabindex="-1" aria-labelledby="newMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMaterialodalLabel">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/add_material') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Material name -->
                        <label for="name" class="col-form-label">Item Name</label>
                        <input type="text" class="form-control mb-1" id="name" name="name" placeholder="Add new item">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Material code -->
                        <label for="code" class="col-form-label">Code</label>
                        <input type="text" class="form-control mb-1" id="code" name="code" placeholder="Material code">
                        <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                        <small class="text-danger">Item code are permanent, make sure they are correct.</small>
                    </div>
                    <div class="form-group">
                        <!-- Supplier name -->
                        <label for="supplier" class="col-form-label">Supplier</label>
                        <div class="row  align-items-center">
                            <div class="col-lg-10 mb-xs-3">
                            <select name="supplier" id="supplier" class="form-control" value="<?= set_value('supplier') ?>">
                                <option value="">--Select Supplier--</option>
                                <?php foreach ($supplier as $sup) : ?>
                                    <option value="<?= $sup['id'] ?>"><?= $sup['supplier_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-lg-2 justify-content-center">
                                <a href="<?= base_url('purchasing/supplier')?>">
                                    <span class="icon text-primary">
                                        <i class="bi bi-person-plus-fill"></i>
                                        Add New Supplier
                                    </span>
                                </a>
                            </div>
                        </div>
                        <?= form_error('supplier', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Item price -->
                        <label for="url" class="col-form-label">Price</label>
                        <input type="text" class="form-control mb-1" id="price" name="price" placeholder="Add price">
                        <?= form_error('price', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Material initial stock -->
                        <label for="url" class="col-form-label">Initial Stock</label>
                        <input type="text" class="form-control mb-1" id="initial_stock" name="initial_stock" placeholder="Add initial stock">
                        <?= form_error('initial_stock', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Item categories -->
                        <label for="url" class="col-form-label">Categories</label>
                        <select name="category" id="category" class="form-control" value="<?= set_value('category') ?>">
                            <option value="">--Select Categories--</option>
                            <?php foreach ($cat as $fs) : ?>
                                <option value="<?= $fs['id'] ?>"><?= $fs['categories_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('category', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Item categories -->
                        <label for="url" class="col-form-label">Unit</label>
                        <select name="unit" id="unit" class="form-control" value="<?= set_value('unit') ?>">
                            <option value="">--Select unit--</option>
                            <?php $before = '';
                            foreach ($cat as $fs) : 
                                if($fs['unit'] != $before){ ?>
                                <option value="<?= $fs['unit'] ?>"><?= $fs['unit'] ?></option>
                                <?php $before = $fs['unit']; ?>
                            <?php } else { 
                                }
                            endforeach; ?>
                        </select>
                        <?= form_error('unit', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Warehouse -->
                        <label for="url" class="col-form-label">Warehouse</label>
                        <input type="warehouse" class="form-control mb-1" id="warehouse" name="warehouse" placeholder="Material" value="1" readonly>
                        <?= form_error('category', '<small class="text-danger pl-2">', '</small>') ?>
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
<div class="modal fade" id="editMaterial" tabindex="-1" aria-labelledby="editMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMaterialodalLabel">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/edit_material') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Material name -->
                        <label for="url" class="col-form-label">Item Name</label>
                        <input type="text" class="form-control mb-1" id="name" name="name" placeholder="Add new item">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Supplier name -->
                        <label for="supplier" class="col-form-label">Supplier</label>
                        <select name="supplier" id="supplier" class="form-control" value="<?= set_value('supplier') ?>">
                            <option value="">--Select Supplier--</option>
                            <?php foreach ($supplier as $sup) : ?>
                                <option value="<?= $sup['id'] ?>"><?= $sup['supplier_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('supplier', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Material code -->
                        <label for="url" class="col-form-label">Code</label>
                        <input type="text" class="form-control mb-1" id="code" name="code" placeholder="Material code" readonly>
                        <small>You can't change item's code.</small>
                        <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Item price -->
                        <label for="url" class="col-form-label">Price</label>
                        <input type="text" class="form-control mb-1" id="price" name="price" placeholder="Add price">
                        <?= form_error('price', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Item categories -->
                        <label for="category" class="col-form-label">Categories</label>
                        <select name="category" id="category" class="form-control" value="<?= set_value('category') ?>">
                            <option value="">--Select Categories--</option>
                            <?php foreach ($cat as $fs) : ?>
                                <option value="<?= $fs['id'] ?>"><?= $fs['categories_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('category', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Warehouse -->
                        <label for="url" class="col-form-label">Warehouse</label>
                        <input type="warehouse" class="form-control mb-1" id="warehouse" name="warehouse" placeholder="Material" value="1" readonly>
                        <?= form_error('warehouse', '<small class="text-danger pl-2">', '</small>') ?>
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
<div class="modal fade" id="deleteMaterialItem" tabindex="-1" aria-labelledby="deleteMaterialItemLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMaterialItemLabel">Delete Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/delete_material') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Asset Name -->
                        <label for="url" class="col-form-label">Item Name</label>
                        <input type="text" class="form-control mb-1" readonly id="delete_name" name="delete_name" placeholder="Item Name">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset Code -->
                        <label for="url" class="col-form-label">Item Code</label>
                        <input type="text" readonly class="form-control mb-1" id="delete_code" name="delete_code" placeholder="Item Code">
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