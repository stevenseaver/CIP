<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-dark font-weight-bold"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="card rounded shadow border-0 mb-3">
        <div class="card-body mb-0">
            <div class="row justify-content-left">
                <div class="col-lg-4">
                    <p class="text-dark mb-1">Product Name : </p>
                    <p class="text-dark font-weight-bold"> <?= $getID['name'] ?></p>
                    <p class="text-dark mb-1">Code : </p>
                    <p class="text-dark font-weight-bold"> <?= $getID['code'] ?></p>
                </div>
                <div class="col-lg-4">
                    <p class="text-dark mb-1">Lipatan : </p>
                    <p class="text-dark font-weight-bold"> <?= $getID['lipatan'] ?></p>
                    <p class="text-dark mb-1">Gramatur : </p>
                    <p class="text-dark font-weight-bold"> <?= $getID['weight'] ?></p>
                </div>
                <div class="col-lg-4">
                    <p class="text-dark mb-1">In Stock : </p>
                    <p class="text-dark font-weight-bold"> <?= number_format($getID['in_stock'], 2, ',', '.') . ' kg' ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- back button -->
    <a href="<?= base_url('inventory/prod_wh/') ?>" class="btn btn-white btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left text-dark"></i>
        </span>
        <span class="text text-dark">Back</span>
    </a>

    <a href="" data-toggle="modal" data-target="#newTransModal" data-name="<?= $getID['name'] ?>" data-code=" <?= $getID['code'] ?>" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newMaterial">
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
                                <th>Roll</th>
                                <th>Transaction ID</th>
                                <th>Date Created</th>
                                <th>Inbound(Kg)</th>
                                <th>Outbound(Kg)</th>
                                <th>Stock (Kg)</th>
                                <th>Price</th>
                                <th>Batch</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($rollStock as $rs) : ?>
                                <?php
                                if ($rs['code'] != $code) {
                                    continue;
                                } else {
                                }
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $rs['name']; ?></td>
                                    <td>
                                        <?php 
                                            if($rs['status'] == 3 or $rs['status'] == 9) { ?>
                                                <a href="<?= base_url('production/gbj_details/') . $rs['transaction_id']; ?>"><?= $rs['transaction_id']; ?></a>
                                        <?php } else {
                                                echo $rs['transaction_id'];
                                            };
                                        ?>
                                    </td>
                                    <td><?= date('d F Y H:i:s', $rs['date']); ?></td>
                                    <td><?= number_format($rs['incoming'], 2, ',', '.'); ?></td>
                                    <td><?= number_format($rs['outgoing'], 2, ',', '.'); ?></td>
                                    <td><?= number_format($rs['in_stock'], 2, ',', '.'); ?></td>
                                    <td><?= number_format($rs['price'], 2, ',', '.'); ?></td>
                                    <td><?= $rs['batch']; ?></td>
                                    <td><?= $rs['transaction_desc']; ?></td>
                                    <td><?= $rs['status_name']; ?></td>
                                    <td>
                                        <?php
                                        if ($rs['status_name'] == 'Saldo Awal' or $rs['status_name'] == 'Saldo Akhir') { ?>
                                            <a href="" class="badge badge-primary" data-toggle="modal" data-target="#adjustProdTrans" data-categories="<?= $rs['status_name'] ?>" data-id="<?= $rs['id'] ?>">Edit</a>
                                        <?php } else { ?>
                                            <?php if ($rs['status_name'] == 'Production') { ?>
                                                <a href="" class="badge badge-primary" data-toggle="modal" data-target="#adjustProdTrans" data-categories="<?= $rs['status_name'] ?>" data-id="<?= $rs['id'] ?>">Edit</a>
                                                <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteProdTransaction" data-cat="<?= $rs['status_name'] ?>" data-id="<?= $rs['id'] ?>" data-name="<?= $rs['name'] ?>" data-code="<?= $rs['code'] ?>" data-amount="<?= $rs['incoming'] ?>">Delete</a>
                                            <?php } else { ?>
                                                <a href="" class="badge badge-primary" data-toggle="modal" data-target="#adjustProdTrans" data-categories="<?= $rs['status_name'] ?>" data-id="<?= $rs['id'] ?>">Edit</a>
                                                <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteProdTransaction" data-cat="<?= $rs['status_name'] ?>" data-id="<?= $rs['id'] ?>" data-name="<?= $rs['name'] ?>" data-code="<?= $rs['code'] ?>" data-amount="<?= $rs['outgoing'] ?>">Delete</a>
                                            <?php } ?>
                                        <?php } ?>
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
            <form action="<?= base_url('inventory/add_trans_prod/') . $getID['id'] ?>" method="post">
                <div class="modal-body">
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
                                <?php if ($ts['status_id'] == 2) {
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
                        <!-- Amount transaction -->
                        <label for="url" class="col-form-label">Amount</label>
                        <input type="text" class="form-control mb-1" id="amount" name="amount" placeholder="Item amount">
                        <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Description -->
                        <label for="description" class="col-form-label">Description</label>
                        <input type="text" class="form-control mb-1" id="description" name="description" placeholder="Item description">
                        <?= form_error('description', '<small class="text-danger pl-2">', '</small>') ?>
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
<div class="modal fade" id="adjustProdTrans" tabindex="-1" aria-labelledby="adjustProdTransLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adjustProdTransLabel">Adjust Item Amount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/adjust_details_prod/') . $getID['id']  ?>" method="post">
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
<div class="modal fade" id="deleteProdTransaction" tabindex="-1" role="dialog" aria-labelledby="deleteProdTransactionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProdTransactionLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('inventory/delete_prod_trans/') . $getID['id']  ?>" method="post">
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