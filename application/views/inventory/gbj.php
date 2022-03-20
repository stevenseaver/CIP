<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-dark font-weight-bold"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
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
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Finished Good</th>
                                <th>Code</th>
                                <th>Date</th>
                                <th>Stock(Kg)</th>
                                <th>Warehouse</th>
                                <th>Status</th>
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
                                    <td><?= date('d F Y H:i:s', $fs['date']); ?></td>
                                    <td><?= $fs['in_stock'] ?></td>
                                    <td><?= $fs['warehouse_name'] ?></td>
                                    <td><?= $fs['status_name'] ?></td>
                                    <td>
                                        <img class="img-fluid rounded" src="<?= base_url() . $fs['picture'] ?>" alt="Product Image #2" style="width: 15rem;">
                                    <td>
                                        <a href="<?= base_url('inventory/gbj_details/') . $fs['id'] ?>" class="badge badge-primary">Details</a>
                                        <a href="" class="badge badge-success">Adjust</a>
                                        <a data-toggle="modal" data-target="#editItemModal" class="badge badge-warning text-white clickable" data-name="<?= $fs['name'] ?>" data-code="<?= $fs['code'] ?>">Edit</a>
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
                    <!-- Material name -->
                    <label for="url" class="col-form-label">Item Name</label>
                    <input type="text" class="form-control mb-1" id="name" name="name" placeholder="Add new item">
                    <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class="form-group">
                    <!-- Material code -->
                    <label for="url" class="col-form-label">Code</label>
                    <input type="text" class="form-control mb-1" id="code" name="code" placeholder="Material code">
                    <small>Item code are permanent, make sure they are correct.</small>
                    <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class="form-group">
                    <!-- Material initial stock -->
                    <label for="url" class="col-form-label">Initial Stock</label>
                    <input type="text" class="form-control mb-1" id="initial_stock" name="initial_stock" placeholder="Add initial stock">
                    <?= form_error('initial_stock', '<small class="text-danger pl-2">', '</small>') ?>
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