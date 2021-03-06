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
            <p class="text-dark mb-2">Price: <?php
                                                if ($getID['categories'] != '6') {
                                                    echo number_format($getID['price'], 0, ',', '.') . '/pack';
                                                } else {
                                                    echo number_format($getID['price'], 0, ',', '.') . '/kg';
                                                } ?></p>

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
                                        <td><?= number_format($fs['incoming'], 0, ',', '.') ?></td>
                                        <td><?= number_format($fs['outgoing'], 0, ',', '.') ?></td>
                                        <td><?php
                                            if ($fs['categories'] != '5') {
                                                echo number_format($fs['in_stock'], 0, ',', '.') . ' pack';
                                            } else {
                                                echo number_format($fs['in_stock'], 0, ',', '.') . ' kg';
                                            } ?></td>
                                        <td><?= $fs['warehouse_name'] ?></td>
                                        <td><?= $fs['status_name'] ?></td>
                                        <td>
                                            <?php
                                            if ($fs['status_name'] == 'Saldo Awal' or $fs['status_name'] == 'Saldo Akhir') { ?>
                                                <a href="" class="badge badge-primary" data-toggle="modal" data-target="#adjustGBJTrans" data-categories="<?= $fs['status_name'] ?>" data-id="<?= $fs['id'] ?>">Edit</a>
                                            <?php } else { ?>
                                                <?php if ($fs['status_name'] == 'Production' or $fs['status_name'] == 'Return Sales' or $fs['status_name'] == 'Purchasing') { ?>
                                                    <a href="" class="badge badge-primary" data-toggle="modal" data-target="#adjustGBJTrans" data-categories="<?= $fs['status_name'] ?>" data-id="<?= $fs['id'] ?>">Edit</a>
                                                    <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteTransaction" data-cat="<?= $fs['status_name'] ?>" data-id="<?= $fs['id'] ?>" data-name="<?= $fs['name'] ?>" data-code="<?= $fs['code'] ?>" data-amount="<?= $fs['incoming'] ?>">Delete</a>
                                                <?php } else { ?>
                                                    <a href="" class="badge badge-primary" data-toggle="modal" data-target="#adjustGBJTrans" data-categories="<?= $fs['status_name'] ?>" data-id="<?= $fs['id'] ?>">Edit</a>
                                                    <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteTransaction" data-cat="<?= $fs['status_name'] ?>" data-id="<?= $fs['id'] ?>" data-name="<?= $fs['name'] ?>" data-code="<?= $fs['code'] ?>" data-amount="<?= $fs['outgoing'] ?>">Delete</a>
                                                <?php } ?>
                                            <?php } ?>
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
                                <?php if ($ts['status_id'] != 1 and $ts['status_id'] != 7 and $ts['status_id'] != 6) {
                                ?> <option value="<?= $ts['status_id'] ?>"><?= $ts['status_name']; ?></option>
                                <?
                                } else {
                                    continue;
                                } ?>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-danger">Stock adjustment deduct Stock Akhir.</small>
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
<div class="modal fade" id="adjustGBJTrans" tabindex="-1" aria-labelledby="adjustGBJTransLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adjustGBJTransLabel">Adjust Item Amount</h5>
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
                        <label for="url" class="col-form-label">Amount Adjusted</label>
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

<!-- Modal For Delete Transaction -->
<div class="modal fade" id="deleteTransaction" tabindex="-1" role="dialog" aria-labelledby="deleteTransactionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTransactionLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('inventory/delete_gbj_trans/') . $getID['id']  ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- item id -->
                        <label for="url" class="col-form-label">ID</label>
                        <input type="text" class="form-control mb-1" id="delete_trans_id" name="delete_trans_id" readonly>
                        <!-- item name -->
                        <label for="url" class="col-form-label">Name</label>
                        <input type="text" class="form-control mb-1" id="delete_trans_name" name="delete_trans_name" readonly>
                        <!-- item code -->
                        <label for="url" class="col-form-label">Code</label>
                        <input type="text" class="form-control mb-1" id="delete_trans_code" name="delete_trans_code" readonly>
                        <!-- item categories -->
                        <label for="url" class="col-form-label">Transaction Categories</label>
                        <input type="text" class="form-control mb-1" id="delete_trans_cat" name="delete_trans_cat" readonly>
                        <!-- trans amount -->
                        <label for="url" class="col-form-label">Amount</label>
                        <input type="text" class="form-control mb-1" id="delete_amount" name="delete_amount" readonly>
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