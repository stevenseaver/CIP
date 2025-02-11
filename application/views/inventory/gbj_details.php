<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-dark font-weight-bold"><?= $title ?></h1>
    <!-- back button -->
    <a href="<?= base_url('inventory/gbj_wh/') ?>" class="btn btn-white btn-icon-split mb-3">
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
    <div class="row ">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <div class="card rounded shadow border-0 mb-3">
        <div class="card-body mb-0">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <p class="text-dark mb-1">Product Name : </p>
                    <p class="text-dark font-weight-bold"> <?= $getID['name'] ?></p>
                    <p class="text-dark mb-1">Code : </p>
                    <p class="text-dark font-weight-bold"> <?= $getID['code'] ?></p>
                    <p class="text-dark mb-1">Stock : </p>
                    <p class="text-dark font-weight-bold"> 
                        <?php
                            if ($getID['categories'] == '6' or $getID['categories'] == '7') {
                                if($getID['conversion'] != 0){
                                    echo number_format($getID['in_stock'], 2, ',', '.') . ' ' . $getID['unit_satuan'] . ' or ' . number_format(($getID['in_stock'] / $getID['conversion']), 2, ',', '.') . ' sack';
                                } else {
                                    echo number_format($getID['in_stock'], 2, ',', '.') . ' ' . $getID['unit_satuan'];
                                }
                            } else {
                                if($getID['packpersack'] != 0){
                                    echo number_format($getID['in_stock'], 2, ',', '.') . ' ' . $getID['unit_satuan'] . ' or ' . number_format(($getID['in_stock'] / $getID['packpersack']), 2, ',', '.') . ' sack' ;
                                } else {
                                    echo number_format($getID['in_stock'], 2, ',', '.') . ' ' . $getID['unit_satuan'];
                                }
                            } 
                        ?>
                    </p>
                    <p class="text-dark mb-2">Minimum Stock: </p>
                    <p class="text-dark font-weight-bold"> 
                        <?= number_format((float)$getID['description'], 2, ',', '.') . ' ' . $getID['unit_satuan'] ?>
                    </p>
                </div>
                <div class="col-lg-4">
                    <?php if ($getID['categories'] != 6) { ?>
                        <p class="text-dark mb-1">Quantity/pack:</p>
                        <p class="text-dark font-weight-bold"><?= $getID['pcsperpack'] . ' pcs' ?></p>
                        <p class="text-dark mb-1">Pack/sack:</p>
                        <p class="text-dark font-weight-bold"><?= $getID['packpersack'] . ' packs' ?></p>
                    <?php } else { ?>
                        <p class="text-dark mb-1">Pack/sack:</p>
                        <p class="text-dark font-weight-bold"><?= 25 . ' packs' ?></p>
                    <?php } ?>
                    <?php if ($getID['categories'] == 7) { ?>
                        <p class="text-dark mb-1">Conversion:</p>
                        <p class="text-dark font-weight-bold"><?= $getID['conversion'] . ' kg/sack' ?></p>
                    <?php } else {
                    }
                    ?>
                    <p class="text-dark mb-2">Price: </p>
                    <p class="text-dark font-weight-bold">IDR 
                        <?= number_format($getID['price'], 2, ',', '.') . '/' . $getID['unit_satuan'] ?>
                    </p>
                </div>
                <div class="col-lg-4 d-flex align-items-start justify-content-center">
                    <img src="<?= base_url($getID['picture']) ?>" alt="" style="width: 10rem;">
                </div>
            </div>
        </div>
    </div>


    <div class="card border-left-primary mb-3">
        <div class="row mx-4 my-3">
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Finished Good</th>
                                <th>Transaction Ref.</th>
                                <th>Transaction Date</th>
                                <th>Inbound</th>
                                <th>Outbound</th>
                                <th>Stock</th>
                                <th>Weight/Pack</th>
                                <th>Price</th>
                                <th>Batch</th>
                                <th>Description</th>
                                <!-- <th>Customer</th> -->
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
                                        <td>
                                            <?php 
                                                if($fs['status'] == 3 or $fs['status'] == 9) { ?>
                                                    <a href="<?= base_url('production/gbj_details/') . $fs['transaction_id']; ?>"><?= $fs['transaction_id']; ?></a>
                                                <?php } else if($fs['status'] == 4) { ?>
                                                    <a href="<?= base_url('sales/invoice_detail/') . $fs['transaction_id']; ?>"><?= $fs['transaction_id']; ?></a>
                                                <?php } else {
                                                    echo $fs['transaction_id'];
                                                };
                                            ?>
                                        </td>
                                        <td><?= date('d F Y H:i:s', $fs['date']); ?></td>
                                        <td>
                                            <?php 
                                                if ($fs['status'] == 3 and ($fs['categories'] != 6 and $fs['categories'] != 7)){
                                                    if ($fs['transaction_status'] != 2) {
                                                        echo number_format($fs['incoming'], 2, ',', '.') .' kg(s)';
                                                    }
                                                    else {
                                                        echo number_format($fs['incoming'], 2, ',', '.') .' '. $fs['unit_satuan'] . '(s)';
                                                    }
                                                } else {
                                                    echo number_format($fs['incoming'], 2, ',', '.') .' '. $fs['unit_satuan'] . '(s)';
                                                }
                                            ?> 
                                        </td>
                                        <td><?= number_format($fs['outgoing'], 2, ',', '.') .' '. $fs['unit_satuan'] . '(s)'; ?> </td>
                                        <td><?= number_format($fs['in_stock'], 2, ',', '.') .' '. $fs['unit_satuan'] . '(s)'; ?> </td>
                                        <td>
                                            <?php 
                                                if ($fs['outgoing'] != 0){
                                                    $calculate_weight_persack = $fs['before_convert']/$fs['outgoing'];
                                                } else if ($fs['incoming'] != 0) {
                                                    $calculate_weight_persack = $fs['before_convert']/$fs['incoming'];
                                                }else {
                                                    $calculate_weight_persack = '0';
                                                };
                                                echo number_format($calculate_weight_persack, 2, ',', '.') . ' kg/pack'; 
                                            ?> 
                                        </td>
                                        <td><?= number_format($fs['price'], 2, ',', '.') ?> </td>
                                        <td><?= $fs['batch'] ?> </td>
                                        <td><?= $fs['description'] ?> </td>
                                        <!-- <td><?= $fs['customer_id'] ?> </td> -->
                                        <td><?php echo $fs['status_name'];
                                            if($fs['status'] == 4){ 
                                                if ($fs['transaction_status'] == 0) {
                                                    echo ' <p class="badge badge-warning">Sales Order</p>';
                                                } else {
                                                    echo ' <p class="badge badge-success">Delivered</p>';
                                                } 
                                            } else {
                                                if ($fs['status'] == 3 and ($fs['categories'] != 6 and $fs['categories'] != 7))  {
                                                    if ($fs['transaction_status'] != 2) {
                                                        echo '<p class="badge badge-danger">Still in weight</p>';
                                                    }
                                                    else {
                                                        echo '<p class="badge badge-success">Converted to pack</p>';
                                                    }
                                                } else {
                                                    
                                                }
                                            };
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($fs['status'] == '1' or $fs['status'] == '7') { ?>
                                                <a href="" class="badge badge-primary" data-toggle="modal" data-target="#adjustGBJTrans" data-id="<?= $fs['id']; ?>" data-categories="<?= $fs['status_name']; ?>" data-amount="<?= $fs['in_stock'];?>" data-desc1="<?= $fs['batch'];?>" data-desc2="<?= $fs['description'];?>">Edit</a>
                                            <?php } else { ?>
                                                <?php if ($fs['status'] == '2' or $fs['status'] == '3' or $fs['status'] == '5' or $fs['status'] == '8') { ?>
                                                    <a href="" class="badge badge-primary" data-toggle="modal" data-target="#adjustGBJTrans" data-categories="<?= $fs['status_name']; ?>" data-id="<?= $fs['id']; ?>" data-amount="<?= $fs['incoming'];?>" data-desc1="<?= $fs['batch'];?>" data-desc2="<?= $fs['description'];?>">Edit</a>
                                                    <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteTransaction" data-cat="<?= $fs['status_name']; ?>" data-id="<?= $fs['id']; ?>" data-name="<?= $fs['name']; ?>" data-code="<?= $fs['code'] ?>" data-amount="<?= $fs['incoming'] ?>">Delete</a>
                                                <?php } else { ?>
                                                    <a href="" class="badge badge-primary" data-toggle="modal" data-target="#adjustGBJTrans" data-categories="<?= $fs['status_name']; ?>" data-id="<?= $fs['id']; ?>" data-amount="<?= $fs['outgoing'];?>" data-desc1="<?= $fs['batch'];?>" data-desc2="<?= $fs['description'];?>">Edit</a>
                                                    <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteTransaction" data-cat="<?= $fs['status_name'] ?>" data-id="<?= $fs['id'] ?>" data-name="<?= $fs['name'] ?>" data-code="<?= $fs['code'] ?>" data-amount="<?= $fs['outgoing'] ?>">Delete</a>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php
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
                        <label for="name" class="col-form-label">Item Name</label>
                        <input type="text" class="form-control mb-1" id="name" name="name" placeholder="Add new item" readonly>
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Item code -->
                        <label for="code" class="col-form-label">Code</label>
                        <input type="text" class="form-control mb-1" id="code" name="code" placeholder="Item code" readonly>
                        <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Item categories -->
                        <label for="status" class="col-form-label">Categories</label>
                        <select name="status" id="status" class="form-control" value="<?= set_value('status') ?>">
                            <option value="">--Select Transactions--</option>
                            <?php foreach ($transactionStatus as $ts) : ?>
                                <?php if ($ts['status_id'] != 1 and $ts['status_id'] != 7 and $ts['status_id'] != 6 and $ts['status_id'] != 9 and $ts['status_id'] != 10) {
                                ?> <option value="<?= $ts['status_id'] ?>"><?= $ts['status_name']; ?></option>
                                <?
                                } else {
                                    continue;
                                } ?>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-danger">Stock adjustment deduct Stock Akhir.</small>
                        <?= form_error('status', '<small class="text-danger">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Trans amount -->
                        <label for="amount" class="col-form-label">Amount</label>
                        <input type="text" class="form-control mb-1" id="amount" name="amount" placeholder="Item amount">
                        <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Item description -->
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
                        <!-- Amount -->
                        <label for="url" class="col-form-label">Amount Adjusted</label>
                        <input type="text" class="form-control mb-1" id="adjust_amount" name="adjust_amount" placeholder="Item Amount">
                        <?= form_error('adjust_amount', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Desc 1 -->
                        <label for="url" class="col-form-label">Batch/Reference</label>
                        <input type="text" class="form-control mb-1" id="edit_desc1" name="edit_desc1" placeholder="Production batch">
                        <small>Not compulsory.</small>
                        <?= form_error('edit_desc1', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Desc 2  -->
                        <label for="url" class="col-form-label">Description</label>
                        <input type="text" class="form-control mb-1" id="edit_desc2" name="edit_desc2" placeholder="Cutting line/operator or invoice reference">
                        <?= form_error('edit_desc2', '<small class="text-danger pl-2">', '</small>') ?>
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