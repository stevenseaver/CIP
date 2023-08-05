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
                                    <th>Customer</th>
                                    <th>Invoice Number</th>
                                    <th>Date</th>
                                    <th>Delivery Address</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataCart as $items) :
                                    if ($before != $items['ref']) { ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $items['name']; ?></td>
                                        <td><?= $items['ref']; ?></td>
                                        <td><?= date('d F Y H:i', $items['date']); ?></td>
                                        <td><?= $items['deliveryTo']; ?></td>
                                        <td>
                                            <?php if($items['status'] == 1){ ?> 
                                                <p class="mr-3 my-3 text-center">
                                                    <span class="icon text-warning mx-2">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </span>
                                                    <span class="text-warning">Confirming</span>
                                                </p>
                                            <?php } else if($items['status'] == 2){ ?> 
                                                <p class="mr-3 my-3 text-center">
                                                    <span class="icon text-primary mx-2">
                                                        <i class="bi bi-truck"></i>
                                                    </span>
                                                    <span class="text-primary">Delivering</span>
                                                </p>
                                            <?php } else if($items['status'] == 3){ ?> 
                                                <p class="mr-3 my-3 text-center">
                                                    <span class="icon text-success mx-2">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </span>
                                                    <span class="text-success">Delivered</span>
                                                </p>
                                            <?php } else if($items['status'] == 4){ ?> 
                                                <p class="mr-3 my-3 text-center">
                                                    <span class="icon text-danger mx-2">
                                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                                    </span>
                                                    <span class="text-danger">Declined</span>
                                                </p>
                                            <?php } ?>  
                                        </td>
                                        <td>
                                            <a href="<?= base_url('sales/info_detail/') . urldecode($items['name']) . '/' . $items['ref'] . '/' . $items['date'] . '/' . $items['status'] ?>" class="badge badge-primary">Details</a>
                                        </td>
                                    </tr>
                                    <?php
                                        $before = $items['ref'];
                                        $i++;
                                        
                                } endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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