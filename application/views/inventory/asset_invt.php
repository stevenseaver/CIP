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

    <div class="card border-left-primary mb-3">
        <div class="row mx-4 my-3">
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Date Acquired</th>
                                <th>Position</th>
                                <th>Amount</th>
                                <th>Value (IDR)</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            ?>
                            <?php foreach ($inventory as $inv) : ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $inv['code'] ?></td>
                                    <td><?= $inv['name'] ?></td>
                                    <td><?= date('d F Y H:i:s', $inv['date_in']); ?></td>
                                    <td><?= $inv['room_name'] ?></td>
                                    <td><?= $inv['amount'] ?></td>
                                    <td><?= $inv['value'] ?></td>
                                    <td>
                                        <?php if ($inv['status'] == 1) {
                                            echo '<p class="badge badge-success">Active</p>';
                                        } else if ($inv['status'] == 0) {
                                            echo '<p class="badge badge-warning">Maintenance</p>';
                                        } else if ($inv['status'] == 2) {
                                            echo '<p class="badge badge-danger">Decomissioned</p>';
                                        } ?>
                                    </td>
                                    <td>
                                        <a href="" class="badge badge-primary">Transfer</a>
                                        <a href="" class="badge badge-secondary">Edit</a>
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
<div class="modal fade" id="newMaterial" tabindex="-1" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/add_asset') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Asset code -->
                        <label for="url" class="col-form-label">Item Code</label>
                        <input type="text" class="form-control mb-1" id="code" name="code" placeholder="Add new item">
                        <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset name -->
                        <label for="url" class="col-form-label">Item Name</label>
                        <input type="text" class="form-control mb-1" id="name" name="name" placeholder="Add new item">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- asset position -->
                        <label for="url" class="col-form-label">Position</label>
                        <div class="mb-1">
                            <select name="position" id="position" class="form-control" value="<?= set_value('position') ?>">
                                <option value="">--Select Type--</option>
                                <?php foreach ($room as $inv) : ?>
                                    <option value="<?= $inv['room_id'] ?>"><?= $inv['room_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('position', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Asset amount stock -->
                        <label for="url" class="col-form-label">Amount</label>
                        <input type="text" class="form-control mb-1" id="amount" name="amount" placeholder="Add Amount">
                        <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset value -->
                        <label for="url" class="col-form-label">Value</label>
                        <input type="text" class="form-control mb-1" id="amount" name="amount" placeholder="IDR">
                        <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- asset status -->
                        <label for="url" class="col-form-label">Status</label>
                        <div class="mb-1">
                            <select name="status" id="status" class="form-control" value="<?= set_value('status') ?>">
                                <option value="">--Select Type--</option>
                                <option value="1">Active</option>
                                <option value="0">Maintenance</option>
                                <option value="2">Decomissioned</option>
                            </select>
                            <?= form_error('status', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
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