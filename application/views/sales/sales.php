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
                                    <th>Payment Upload</th>
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
                                            <td>
                                                <img class="img-fluid rounded" src="<?= base_url('asset/img/payment/') . $items['img']  ?>" alt="Payment Invoice" style="width: 15rem;">
                                            <td>
                                                <a href="<?= base_url('sales/sales_detail/') . urldecode($items['name']) . '/' . $items['ref'] . '/' . $items['date'] . '/' . $items['status'] ?>" class="badge badge-primary">Details</a>
                                                <a href="<?= base_url('sales/sales_status_change/') . $items['ref'] . '/' . '2' ?>" class="badge badge-success">Submit to Delivery</a>
                                                <a href="<?= base_url('sales/sales_status_change/') . $items['ref'] . '/' . '0' ?>" class="badge badge-danger">Decline</a>
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

                <!-- <div class="row text-left">
                                <div class="col-1 d-flex mx-2">
                                    <h1 class=""> <?= $i ?></h1>
                                </div>
                                <div class="col d-flex flex-column justify-content-center mb-0">
                                    <div class="">
                                        <h5 class="text-primary font-weight-bold mb-1"><?= $items['ref']; ?></h5>
                                    </div>
                                    <div class="">
                                        <p class="small mb-0"><?= date('d F Y H:i', $items['date']);  ?></p>
                                    </div>
                                </div>
                                <div class="col-1 d-flex justify-content-center align-items-center mx-3">
                                    <a href="<?= base_url('sales/sales_detail/') . $items['ref'] . '/' . $items['date'] . '/' . $items['status'] ?>">
                                        <i class="bi bi-list-check" style="font-size: 2rem;"></i>
                                    </a>
                                </div>
                            </div> -->
            </div>
        </div>

    <?php
    } else { ?>
        <div class="alert alert-danger" role="alert">There's no transaction! </a></div>
    <? }
    ?>
</div>

</div>
<!-- /.container-fluid -->