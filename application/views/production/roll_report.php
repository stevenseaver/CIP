<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <?php if ($materialStock != null) {
        $i = 1;
        $temp = 0;
        $before = '';
    ?>
        <div class="card border-left-primary mb-3">
            <div class="row mx-4 my-3">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Production ID</th>
                                    <th>Date</th>
                                    <th>Batch</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                $temp = 0; ?>
                                <?php foreach ($materialStock as $inv) :
                                    if ($before != $inv['transaction_id']) { ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $inv['transaction_id'] ?></td>
                                            <td><?= date('d F Y H:i:s', $inv['date']); ?></td>
                                            <td><?= $inv['description'] ?></td>
                                            <?php $value = $inv['price'] * $inv['in_stock'];
                                            $temp = $temp + $value;  ?>
                                            <td>
                                                <a href="<?= base_url('production/input_roll_details/') . $inv['transaction_id'] ?>" class="badge badge-primary">Details</a>
                                                <a href="<?= base_url('production/add_roll/') . $inv['transaction_id'] ?>" class="badge badge-warning">Input Roll</a>
                                                <!-- <a href="<?= base_url('production/rollToGBJ/') . $inv['transaction_id']?>" class="badge badge-success">Transfer to GBJ</a> -->
                                                <a data-toggle="modal" data-target="#deleteRollModal" data-po="<?= $inv['transaction_id']  ?>" class="badge badge-danger">Delete Roll Input</a>
                                            </td>
                                        </tr>
                                    <?php
                                        $before = $inv['transaction_id'];
                                        $i++;
                                    } else {
                                    } ?>
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
<!-- /.container-fluid -->

</div>

<!-- Modal For Delete Data -->
<div class="modal fade" id="deleteRollModal" tabindex="-1" role="dialog" aria-labelledby="deleteRollModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRollModalLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">Closing this window will delete all roll data you've entered. Are you sure?</p>
            <form action="<?= base_url('production/delete_all_roll/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- item id -->
                        <label for="url" class="col-form-label">Production Order ID</label>
                        <input type="text" class="form-control" id="delete_roll_id" name="delete_roll_id" readonly>
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
<!-- End of Main Content -->