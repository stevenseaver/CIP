<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-900"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <?php 
        $date = time();
        $year = date('y');
        $month = date('m');
        $time = date('s');
        $serial = rand(100, 999);
        //ref invoice
        $ref = 'INV-' . $year . $month . $time . '-' . $user['id'] . $serial;
    ?>

    <a href="<?= base_url('sales/add_salesorder/') . $ref  ?>" class="btn btn-primary btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Sales Order</span>
    </a>

    <?php if ($dataCart != null) {
        $i = 1;
        $temp = 0;
        $before = '';
    ?>
        <div class="card rounded border-0 shadow mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Invoice Number</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Delivery Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataCart as $items) : ?>
                                    <?php
                                    if ($items['status'] != '1') { //show only with status = 1
                                        continue;
                                    } else {
                                        if ($before != $items['ref']) { ?>
                                            <td><?= $i ?></td>
                                            <td><?= $items['ref']; ?></td>
                                            <td><?= date('d F Y H:i', $items['date']); ?></td>
                                            <td><?= $items['name']; ?></td>
                                            <td><?= $items['deliveryTo']; ?></td>
                                            <!-- <td>
                                                <img class="img-fluid rounded" src="<?= base_url('asset/img/payment/') . $items['img']  ?>" alt="Payment Invoice" style="width: 15rem;">
                                            </td> -->
                                            <td>
                                                <a href="<?= base_url('sales/sales_detail/') . $items['ref'] ?>" class="badge badge-primary">Details</a>
                                                <a href="<?= base_url('sales/add_salesorder/') . $items['ref'] ?>" class="badge badge-warning">Edit</a>
                                                <?php if($items['img']){ ?>
                                                    <a href="<?= base_url('sales/enlarge_image/') . $items['img'] ?>" class="badge badge-info">See Payment Proof</a>
                                                <?php } else {
                                                } ?>
                                                <a href="<?= base_url('sales/sales_status_change/') . $items['ref'] . '/' . '2' ?>" class="badge badge-success">Submit to Delivery</a>
                                                <!-- <a href="<?= base_url('sales/sales_status_change/') . $items['ref'] . '/' . '4' ?>" class="badge badge-danger">Decline and Delete</a> -->
                                                <a data-toggle="modal" data-target="#deleteSalesOrder" class="badge badge-danger text-white clickable" data-id="<?= $items['id'] ?>" data-name="<?= $items['ref'] ?>"><i class="bi bi-trash"> </i>Decline</a>
                                            </td>
                                            </tr>
                                    <?php
                                            $before = $items['ref'];
                                            $i++;
                                        } else {
                                        }
                                    }
                                    ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <?php
    } else { ?>
        <div class="alert alert-danger" role="alert">There's no transaction! </a></div>
    <?php }
    ?>
</div>

</div>
<!-- /.container-fluid -->

<!-- Modal For Delete Sales Order -->
<div class="modal fade" id="deleteSalesOrder" tabindex="-1" role="dialog" aria-labelledby="deleteSalesOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSalesOrderLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this sales order. Are you sure?</p>
            <form action="<?= base_url('sales/sales_status_change/1/4')?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- menu id -->
                        <label for="deletemenu" class="col-form-label" style="display:none">Menu ID</label>
                        <input type="text" class="form-control" style="display:none" id="delete_id" name="delete_id" readonly>
                        <!-- productmenu name -->
                        <label for="deletemenu" class="col-form-label">Invoice ID</label>
                        <input type="text" class="form-control" id="delete_ref" name="delete_ref" readonly>
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