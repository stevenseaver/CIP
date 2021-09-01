<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-dark"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-6 mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <!-- back button -->
    <a href="<?= base_url('inventory/prod_wh/') ?>" class="btn btn-primary btn-icon-split mb-3">
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
                                <th>Weight (Kg)</th>
                                <th>Lip (cm)</th>
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
                                if ($rs['id'] != $code) {
                                    continue;
                                } else {
                                }
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $rs['name'] ?></td>
                                    <td><?= $rs['code'] ?></td>
                                    <td><?= $rs['date'] ?></td>
                                    <td><?= $rs['weight'] ?></td>
                                    <td><?= $rs['lipatan'] ?></td>
                                    <td><?= $rs['in_stock'] ?></td>
                                    <td><?= $rs['warehouse_name'] ?></td>
                                    <td><?= $rs['status_name'] ?></td>
                                    <td>
                                        <a href="" class="badge badge-success">Transactions</a>
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