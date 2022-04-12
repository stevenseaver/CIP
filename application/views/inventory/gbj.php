<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-dark font-weight-bold"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message_adjust'); ?>
            <?= $this->session->flashdata('msg_failed_gbj'); ?>
        </div>
    </div>

    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newGBJ">
        <span class="icon text-white-50">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Item</span>
    </a>

    <div class="card border-left-primary mb-3">
        <div class="row mx-4 my-3">
            <h5 class="mx-0 mb-3 font-weight-bold text-primary">Product List</h5>
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Finished Good</th>
                                <th>Code</th>
                                <th>Pcs/Pack</th>
                                <th>Pack/Sack</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Warehouse</th>
                                <th>Picture</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($finishedStock as $fs) : ?>
                                <?php
                                if ($fs['status'] != 7) {
                                    continue;
                                } else {
                                }
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $fs['name'] ?></td>
                                    <td><?= $fs['code'] ?></td>
                                    <td><?= $fs['pcsperpack'] . ' pcs' ?></td>
                                    <td><?= $fs['packpersack'] . ' pack' ?></td>
                                    <td><?= number_format($fs['price'], 0, ',', '.'); ?></td>
                                    <td><?= $fs['categories_name'] ?></td>
                                    <td><?php
                                        if ($fs['categories_name'] != 'Bulk Products') {
                                            echo $fs['in_stock'] . ' pack';
                                        } else {
                                            echo $fs['in_stock'] . ' kg';
                                        } ?></td>
                                    <td><?= $fs['warehouse_name'] ?></td>
                                    <td>
                                        <img class="img-fluid rounded" src="<?= base_url() . $fs['picture'] ?>" alt="Product Image #2" style="width: 15rem;">
                                    <td>
                                        <a href="<?= base_url('inventory/gbj_details/') . $fs['id'] ?>" class="badge badge-primary">Details</a>
                                        <a data-toggle="modal" data-target="#adjustItemModal" class="badge badge-success text-white clickable" data-name="<?= $fs['name'] ?>" data-code="<?= $fs['code'] ?>" class="badge badge-success">Adjust</a>
                                        <a data-toggle="modal" data-target="#editItemModal" class="badge badge-warning text-white clickable" data-name="<?= $fs['name'] ?>" data-code="<?= $fs['code'] ?>" data-pcs="<?= $fs['pcsperpack'] ?>" data-pack="<?= $fs['packpersack'] ?>" data-price="<?= $fs['price'] ?>">Edit</a>
                                        <a data-toggle="modal" data-target="#deleteItemModal" data-name="<?= $fs['name'] ?>" data-code="<?= $fs['code'] ?>" class="badge badge-danger clickable">Delete</a>
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
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal For Add Data -->
<div class="modal fade" id="newGBJ" tabindex="-1" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <form action="<?= base_url('inventory/add_gbj') ?>" method="post"> -->
            <div class="modal-body">
                <?= form_open_multipart('inventory/add_gbj'); ?>
                <div class="form-group">
                    <!-- Item name -->
                    <label for="url" class="col-form-label">Item Name</label>
                    <input type="text" class="form-control mb-1" id="name" name="name" placeholder="Add new item">
                    <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class="form-group">
                    <!-- Item code -->
                    <label for="url" class="col-form-label">Code</label>
                    <input type="text" class="form-control mb-1" id="code" name="code" placeholder="Item code">
                    <small>Item code are permanent, make sure they are correct.</small>
                    <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <!-- Item code -->
                            <label for="url" class="col-form-label">Amount per pack</label>
                            <input type="text" class="form-control mb-1" id="pcsperpack" name="pcsperpack" placeholder="Amount per pack">
                            <?= form_error('pcsperpack', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <!-- Item code -->
                            <label for="url" class="col-form-label">Pack per sack</label>
                            <input type="text" class="form-control mb-1" id="packpersack" name="packpersack" placeholder="Pack per sack">
                            <?= form_error('packpersack', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <!-- Item initial stock -->
                    <label for="url" class="col-form-label">Initial Stock</label>
                    <input type="text" class="form-control mb-1" id="initial_stock" name="initial_stock" placeholder="Add initial stock">
                    <?= form_error('initial_stock', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class="form-group">
                    <!-- Item price -->
                    <label for="url" class="col-form-label">Price</label>
                    <input type="text" class="form-control mb-1" id="price" name="price" placeholder="Add price">
                    <?= form_error('price', '<small class="text-danger pl-2">', '</small>') ?>
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
                    <!-- Warehouse -->
                    <label for="url" class="col-form-label">Warehouse</label>
                    <input type="warehouse" class="form-control mb-1" id="warehouse" name="warehouse" placeholder="Material" value="3" readonly>
                </div>
                <div class="form-group">
                    <label for="image" class="col-form-label">Image</label>
                    <div class="custom-file">
                        <!-- Image -->
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                        <small class="text-primary">Maximum 5 MB</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Item</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal For Adjust Data -->
<div class="modal fade" id="adjustItemModal" tabindex="-1" aria-labelledby="adjustItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adjustItemModalLabel">Adjust Item Amount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/adjust_gbj') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Name -->
                        <label for="url" class="col-form-label">Item Name</label>
                        <input type="text" readonly class="form-control mb-1" id="adjust_name" name="adjust_name" placeholder="Item Name">
                        <?= form_error('adjust_name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Code -->
                        <label for="url" class="col-form-label">Item Code</label>
                        <input type="text" readonly class="form-control mb-1" id="adjust_code" name="adjust_code" placeholder="Item Code">
                        <?= form_error('adjust_code', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Stock -->
                        <label for="url" class="col-form-label">Item Stock</label>
                        <input type="text" class="form-control mb-1" id="adjust_amount" name="adjust_amount" placeholder="Item Amount">
                        <?= form_error('adjust_amount', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Adjust</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal For Edit Data -->
<div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editItemModalLabel">Edit Item Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <form action="<?= base_url('inventory/edit_gbj') ?>" method="post"> -->
            <div class="modal-body">
                <?= form_open_multipart('inventory/edit_gbj'); ?>
                <div class="form-group">
                    <!-- Asset Name -->
                    <label for="url" class="col-form-label">Item Name</label>
                    <input type="text" class="form-control mb-1" id="name" name="name" placeholder="Item Name">
                    <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class="form-group">
                    <!-- Asset Code -->
                    <label for="url" class="col-form-label">Item Code</label>
                    <input type="text" readonly class="form-control mb-1" id="code" name="code" placeholder="Item Code">
                    <small>You can only change item's name.</small>
                    <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <!-- Item code -->
                            <label for="url" class="col-form-label">Amount per pack</label>
                            <input type="text" class="form-control mb-1" id="pcsperpack" name="pcsperpack" placeholder="Amount per pack">
                            <?= form_error('pcsperpack', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <!-- Item code -->
                            <label for="url" class="col-form-label">Pack per sack</label>
                            <input type="text" class="form-control mb-1" id="packpersack" name="packpersack" placeholder="Pack per sack">
                            <?= form_error('packpersack', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <!-- Item price -->
                    <label for="url" class="col-form-label">Price</label>
                    <input type="text" class="form-control mb-1" id="price" name="price" placeholder="Add price">
                    <?= form_error('price', '<small class="text-danger pl-2">', '</small>') ?>
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
                    <label for="image" class="col-form-label">Image</label>
                    <div class="custom-file">
                        <!-- Image -->
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                        <small class="text-primary">Maximum 5 MB</small>
                    </div>
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
<div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteItemModalLabel">Delete Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/delete_gbj') ?>" method="post">
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