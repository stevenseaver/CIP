<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h3 class="mb-4 text-dark font-weight-bold"><?= $title ?></h3>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="card rounded shadow border-0 mb-3">
        <div class="card-body mb-0">
            <div class="row">     
                <div class="col-lg-6">
                    <p class="text-dark mb-1">Product Name : </p>
                    <p class="text-dark font-weight-bold"> <?= $getID['name'] ?></p>
                    <p class="text-dark mb-1">Code : </p>
                    <p class="text-dark font-weight-bold"> <?= $getID['code'] ?></p>
                    <p class="text-dark mb-1">Price : </p>
                    <p class="text-dark font-weight-bold"> IDR <?= number_format($getID['price'], 0, ',', '.') ?></p>
                </div>
                <div class="col-lg-6">
                    <p class="text-dark mb-1">In Stock : </p>
                    <p class="text-dark font-weight-bold"> <?= number_format($getID['in_stock'], 2, ',', '.') . ' ' . $getID['unit_satuan'] ?></p>
                    <p class="text-dark mb-1">Minimal Stock : </p>
                    <p class="text-dark font-weight-bold"> <?= $getID['item_desc'] . ' ' . $getID['unit_satuan'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <a href="<?= base_url('inventory/material_wh/') ?>" class="btn btn-white btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left text-dark"></i>
        </span>
        <span class="text text-dark">Back</span>
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
                                <th>Materials</th>
                                <th>Transaction Ref</th>
                                <th>Date Created</th>
                                <th>Incoming</th>
                                <th>Outgouing</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Product Name</th>
                                <th>Weight Document/Batch</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            ?>
                            <?php foreach ($materialStock as $ms) : ?>
                                <?php
                                if ($ms['code'] == $code) { ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $ms['name'] ?></td>
                                        <td>
                                            <?php 
                                                if($ms['status'] == 8) { ?>
                                                    <a href="<?= base_url('purchasing/info_details/') . $ms['transaction_id'] . '/' . $ms['supplier'] . '/' . $ms['date']; ?>"><?= $ms['transaction_id']; ?></a>
                                                <?php } else if($ms['status'] == 3) { ?>
                                                    <a href="<?= base_url('production/gbj_details/') . $ms['transaction_id']; ?>"><?= $ms['transaction_id']; ?></a>
                                                <?php } else {
                                                    echo $ms['transaction_id'];
                                                };
                                            ?>
                                        </td>
                                        <td><?= date('d F Y H:i:s', $ms['date']); ?></td>
                                        <td><?= number_format($ms['incoming'], 2, ',', '.'); ?></td>
                                        <td><?= number_format($ms['outgoing'], 2, ',', '.'); ?></td>
                                        <td><?= number_format($ms['in_stock'], 2, ',', '.') . ' ' . $ms['unit_satuan']; ?></td>
                                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                                        <td><?= $ms['product_name']; ?></td>
                                        <td><?= $ms['description']; ?></td>
                                        <td><?= $ms['item_desc']; ?></td>
                                        <td><?= $ms['status_name']; ?>
                                        <?php
                                            if ($ms['status'] == 1 or $ms['status'] == 6 or $ms['status'] == 3 or $ms['status'] == 7)  {

                                            } else 
                                            {
                                                if ($ms['transaction_status'] == 2) {
                                                    echo '<p class="badge badge-success">Received</p>';
                                                }
                                                else if ($ms['transaction_status'] == 3) {
                                                    echo '<p class="badge badge-success mb-0">Received</p>';
                                                    echo '<p class="badge badge-danger">Returned</p>';
                                                }
                                                else {
                                                    echo '<p class="badge badge-danger">Not yet received</p>';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($ms['status'] == 1 or $ms['status'] == 7) { ?>
                                                <a href="" class="badge badge-primary" data-toggle="modal" data-target="#adjustMatTrans" data-categories="<?= $ms['status_name'] ?>" data-id="<?= $ms['id'] ?>" data-qty="<?= $ms['in_stock'];?>" data-price="<?= $ms['price'];?>" data-desc="<?= $ms['description'] ?>" data-desc2="<?= $ms['item_desc'];?>" data-label="<?= 'Reason'; ?>">Edit</a>
                                            <?php } else { ?>
                                                <?php if ($ms['status'] == '8' or $ms['status'] == '2') { //8 for purchasing and 2 for SA?> 
                                                    <a href="" class="badge badge-primary" data-toggle="modal" data-target="#adjustMatTrans" data-categories="<?= $ms['status_name']; ?>" data-qty="<?= $ms['incoming'];?>" data-id="<?= $ms['id']; ?>" data-price="<?= $ms['price'];?>" data-desc="<?= $ms['description']; ?>" data-desc2="<?= $ms['item_desc'];?>" data-label="<?= 'Reference'; ?>">Edit</a>
                                                    <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteMaterialTransaction" data-cat="<?= $ms['status_name']; ?>" data-id="<?= $ms['id']; ?>" data-name="<?= $ms['name']; ?>" data-code="<?= $ms['code'] ?>" data-amount="<?= $ms['incoming']; ?>">Delete</a>
                                                <?php } else { ?>
                                                    <a href="" class="badge badge-primary" data-toggle="modal" data-target="#adjustMatTrans" data-categories="<?= $ms['status_name']; ?>" data-qty="<?= $ms['outgoing'];?>" data-id="<?= $ms['id']; ?>" data-price="<?= $ms['price'];?>" data-desc="<?= $ms['description'];?>" data-desc2="<?= $ms['item_desc'];?>" data-label="<?= 'Batch'; ?>">Edit</a>
                                                    <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteMaterialTransaction" data-cat="<?= $ms['status_name']; ?>" data-id="<?= $ms['id']; ?>" data-name="<?= $ms['name']; ?>" data-code="<?= $ms['code'] ?>" data-amount="<?= $ms['outgoing'] ?>">Delete</a>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                            <?php } else {
                                    continue;
                                }
                                $i++;
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
            <form action="<?= base_url('inventory/add_trans_material/') . $getID['id'] ?>" method="post">
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
                        <label for="url" class="col-form-label">Transaction Categories</label>
                        <select name="status" id="status" class="form-control" value="<?= set_value('status') ?>">
                            <option value="">--Select Transactions--</option>
                            <?php foreach ($transactionStatus as $ts) : ?>
                                <?php if ($ts['status_id'] == 2 or $ts['status_id'] == 6) {
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
                        <!-- Trans amount -->
                        <label for="amount" class="col-form-label">Amount</label>
                        <input type="text" class="form-control mb-1" id="amount" name="amount" placeholder="Item amount">
                        <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Weighing Doc -->
                        <label for="info" class="col-form-label">Weight Document</label>
                        <input type="text" class="form-control mb-1" id="info" name="info" placeholder="Description">
                        <?= form_error('info', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <!-- <div class="form-group"> -->
                        <!-- Description -->
                        <!-- <label for="info2" class="col-form-label">Description</label>
                        <input type="text" class="form-control mb-1" id="info2" name="info2" placeholder="Additional description">
                        <?= form_error('info2', '<small class="text-danger pl-2">', '</small>') ?>
                    </div> -->
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
<div class="modal fade" id="adjustMatTrans" tabindex="-1" aria-labelledby="adjustMatTransLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adjustMatTransLabel">Adjust Item Amount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/adjust_details_material/') . $getID['id']  ?>" method="post">
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
                    <div class="form-group">
                        <!-- price -->
                        <label for="adjust_price" class="col-form-label">Price</label>
                        <input type="text" class="form-control mb-1" id="adjust_price" name="adjust_price" placeholder="Item Price">
                        <?= form_error('adjust_price', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Description 1 -->
                        <label for="adjust_desc" id="adjust_desc_label" class="col-form-label"></label>
                        <input type="text" class="form-control mb-1" id="adjust_desc" name="adjust_desc" placeholder="">
                        <?= form_error('adjust_desc', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Description 2 -->
                        <label for="adjust_desc2" class="col-form-label">Item Description</label>
                        <input type="text" class="form-control mb-1" id="adjust_desc2" name="adjust_desc2" placeholder="Item description">
                        <?= form_error('adjust_desc2', '<small class="text-danger pl-2">', '</small>') ?>
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
<div class="modal fade" id="deleteMaterialTransaction" tabindex="-1" role="dialog" aria-labelledby="deleteMaterialTransactionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMaterialTransactionLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('inventory/delete_material_trans/') . $getID['id']  ?>" method="post">
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