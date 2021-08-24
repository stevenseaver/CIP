<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-dark"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-6 mb-0">
            <?= $this->session->flashdata('message'); ?>
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
                                <th>Code</th>
                                <th>Stock (Kg)</th>
                                <th>Warehouse</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($finishedStock as $fs) : ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $fs['name'] ?></td>
                                    <td><?= $fs['code'] ?></td>
                                    <td><?= $fs['in_stock'] ?></td>
                                    <td><?= $fs['warehouse_name'] ?></td>
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