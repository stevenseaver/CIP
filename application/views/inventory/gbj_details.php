<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-dark font-weight-bold"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <div class="card rounded border-0 mb-3">
        <div class="card-body mb-0">
            <p class="text-dark mb-2">Product Name : <?= $getID['name'] ?></p>
            <p class="text-dark mb-2">Product Code : <?= $getID['code'] ?></p>
        </div>
    </div>

    <!-- back button -->
    <a href="<?= base_url('inventory/gbj_wh/') ?>" class="btn btn-primary btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left"></i>
        </span>
        <span class="text">Back</span>
    </a>

    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newTransModal" data-name="<?= $getID['name'] ?>" data-code=" <?= $getID['code'] ?>">
        <span class="icon text-white-50">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Transaction</span>
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
                                <th>Transaction Date</th>
                                <th>Inbound(Kg)</th>
                                <th>Outbound(Kg)</th>
                                <th>Stock</th>
                                <th>Warehouse</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($finishedStock as $fs) : ?>
                                <?php
                                if ($fs['code'] == $code) { ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $fs['name'] ?></td>
                                        <td><?= date('d F Y H:i:s', $fs['date']); ?></td>
                                        <td><?= $fs['incoming'] ?></td>
                                        <td><?= $fs['outgoing'] ?></td>
                                        <td><?php
                                            if ($fs['categories'] != '5') {
                                                echo number_format($fs['in_stock'], 0, ',', '.') . ' pack';
                                            } else {
                                                echo number_format($fs['in_stock'], 0, ',', '.') . ' kg';
                                            } ?></td>
                                        <td><?= $fs['warehouse_name'] ?></td>
                                        <td><?= $fs['status_name'] ?></td>
                                        <td>
                                            <a href="" class="badge badge-success" data-toggle="modal" data-target="#adjustStock" data-categories="<?= $fs['status_name'] ?>" data-id="<?= $fs['id'] ?>">Edit</a>
                                        </td>
                                    </tr>
                                <?
                                } else {
                                    continue;
                                }
                                ?>
                            <?php $i++;
                            endforeach; ?>
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

<!-- Modal For Add Transaction -->
<div class="modal fade" id="newTransModal" tabindex="-1" aria-labelledby="newTransModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newTransModalLabel">Add New Transactions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/add_trans_gbj/') . $getID['id'] ?>" method="post">
                <div class="modal-body">
                    <!-- <?= form_open_multipart(base_url('inventory/add_trans_gbj/' . $getID['id']));  ?> -->
                    <div class="form-group">
                        <!-- Item name -->
                        <label for="url" class="col-form-label">Item Name</label>
                        <input type="text" class="form-control mb-1" id="name" name="name" placeholder="Add new item" readonly>
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Item code -->
                        <label for="url" class="col-form-label">Code</label>
                        <input type="text" class="form-control mb-1" id="code" name="code" placeholder="Item code" readonly>
                        <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Item categories -->
                        <label for="url" class="col-form-label">Categories</label>
                        <select name="status" id="status" class="form-control" value="<?= set_value('status') ?>">
                            <option value="">--Select Transactions--</option>
                            <?php foreach ($transactionStatus as $ts) : ?>
                                <?php if ($ts['status_id'] != 1 and $ts['status_id'] != 2 and $ts['status_id'] != 7) {
                                ?> <option value="<?= $ts['status_id'] ?>"><?= $ts['status_name']; ?></option>
                                <?
                                } else {
                                    continue;
                                } ?>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('status', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Item initial stock -->
                        <label for="url" class="col-form-label">Amount</label>
                        <input type="text" class="form-control mb-1" id="amount" name="amount" placeholder="Item amount">
                        <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Transaction</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal For Adjust Data -->
<div class="modal fade" id="adjustStock" tabindex="-1" aria-labelledby="adjustStockLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adjustStockLabel">Adjust Item Amount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/adjust_details_gbj/') . $getID['id']  ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- ID -->
                        <label for="url" class="col-form-label">ID</label>
                        <input type="text" readonly class="form-control mb-1" id="id" name="id">
                        <?= form_error('id', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Categories -->
                        <label for="url" class="col-form-label">Categories</label>
                        <input type="text" readonly class="form-control mb-1" id="categories" name="categories">
                        <?= form_error('categories', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Stock -->
                        <label for="url" class="col-form-label">Item Amount Adjusted</label>
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