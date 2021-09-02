<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-dark font-weight-bold"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-6 mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newProdItem">
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
                                <th>Roll</th>
                                <th>Code</th>
                                <th>Date Created</th>
                                <th>Weight (Kg)</th>
                                <th>Lip (cm)</th>
                                <th>Stock (Kg)</th>
                                <th>Warehouse</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($rollStock as $rs) : ?>
                                <?php
                                if ($rs['status'] != 7) {
                                    continue;
                                } else {
                                }
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $rs['name'] ?></td>
                                    <td><?= $rs['code'] ?></td>
                                    <td><?= date('d F Y H:i:s', $rs['date']); ?></td>
                                    <td><?= $rs['weight'] ?></td>
                                    <td><?= $rs['lipatan'] ?></td>
                                    <td><?= $rs['in_stock'] ?></td>
                                    <td><?= $rs['warehouse_name'] ?></td>
                                    <td><?= $rs['status_name'] ?></td>
                                    <td>
                                        <a href="<?= base_url('inventory/prod_details/') . $rs['id'] ?>" class="badge badge-primary">Details</a>
                                        <a href="" class="badge badge-success">Adjust</a>
                                        <a href="" class="badge badge-warning">Edit</a>
                                        <a href="" class="badge badge-danger">Delete</a>
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
<div class="modal fade" id="newProdItem" tabindex="-1" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Add New Item</h5>
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
                    </div>
                    <div class="form-group">
                        <!-- Material weight/m -->
                        <label for="url" class="col-form-label">Weight/M</label>
                        <input type="text" class="form-control mb-1" id="weightperm" name="weightperm" placeholder="Add weight per meter">
                        <?= form_error('initial_stock', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Lipatan -->
                        <label for="url" class="col-form-label">Lipatan</label>
                        <input type="text" class="form-control mb-1" id="lipatan" name="lipatan" placeholder="Add lipatan">
                        <?= form_error('initial_stock', '<small class="text-danger pl-2">', '</small>') ?>
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