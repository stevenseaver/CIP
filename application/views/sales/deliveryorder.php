<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

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
                                    <!-- <th>Payment Upload</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataCart as $items) : ?>
                                    <?php
                                    if ($items['status'] != '2') { //show only with status = 1
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
                                                <a href="<?= base_url('sales/delivery_detail/') . $items['ref'] ?>" class="badge badge-primary">Delivery Detail</a>
                                                <a href="<?= base_url('sales/sales_status_change/') . $items['ref'] . '/' . '3' ?>" class="badge badge-success">Confirm Delivery</a>
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