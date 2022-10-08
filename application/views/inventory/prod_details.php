<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-dark font-weight-bold"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-6 mb-0">
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
                    <p class="text-dark mb-1">Lipatan : </p>
                    <p class="text-dark font-weight-bold"> <?= $getID['lipatan'] ?></p>
                    <p class="text-dark mb-1">Gramatur : </p>
                    <p class="text-dark font-weight-bold"> <?= $getID['weight'] ?></p>
                </div>
            </div>
        </div>
    </div>


    <!-- back button -->
    <a href="<?= base_url('inventory/prod_wh/') ?>" class="btn btn-secondary btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left"></i>
        </span>
        <span class="text">Back</span>
    </a>

    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newMaterial">
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
                                <th>Code</th>
                                <th>Date Created</th>

                                <th>Inbound(Kg)</th>
                                <th>Outbound(Kg)</th>
                                <th>Stock (Kg)</th>
                                <th>Warehouse</th>
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
                                    <td><?= $rs['name'] ?></td>
                                    <td><?= $rs['code'] ?></td>
                                    <td><?= date('d F Y H:i:s', $rs['date']); ?></td>
                                    <td><?= $rs['incoming'] ?></td>
                                    <td><?= $rs['outgoing'] ?></td>
                                    <td><?= $rs['in_stock'] ?></td>
                                    <td><?= $rs['warehouse_name'] ?></td>
                                    <td><?= $rs['status_name'] ?></td>
                                    <td>
                                        <?php
                                        if ($rs['status_name'] == 'Saldo Awal' or $rs['status_name'] == 'Saldo Akhir') { ?>
                                            <a href="" class="badge badge-primary" data-toggle="modal" data-target="#adjustGBJTrans">Edit</a>
                                        <?php } else { ?>
                                            <?php if ($rs['status_name'] == 'Production' or $rs['status_name'] == 'Return Sales' or $rs['status_name'] == 'Purchasing') { ?>
                                                <a href="" class="badge badge-primary" data-toggle="modal" data-target="#adjustGBJTrans">Edit</a>
                                                <a href="" class="badge badge-danger" data-toggle="modal" data-target="#deleteTransaction">Delete</a>
                                            <?php } else { ?>
                                                <a href="" class="badge badge-primary" data-toggle="modal" data-target="#adjustGBJTrans">Delete</a>
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