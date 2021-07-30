<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <?= form_error('name', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('nik', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('address', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('hp', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('role_id', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('password1', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('password2', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('approval'); ?>

            <!-- <a href="" class="btn btn-primary mb-3">Add New User</a> -->
        </div>
    </div>

    <div class="card shadow border-left-primary mb-4">
        <div class="card-header py-2">
            <h5 class="m-0 font-weight-bold text-primary">User Leave Data</h5>
        </div>
        <div class="card-body">
            <a href="<?= base_url("hr/"); ?>" class="btn btn-primary mb-3 text-white">Refresh</a>
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ERN</th>
                            <th>Name</th>
                            <th>Leave Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Reason</th>
                            <th>Document</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>ERN</th>
                            <th>Name</th>
                            <th>Leave Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Reason</th>
                            <th>Document</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($leavedata as $ld) : ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $ld['user_nik']; ?></td>
                                <td><?= $ld['user_name']; ?></td>
                                <td><?= $ld['type']; ?></td>
                                <td><?= $ld['start_date']; ?></td>
                                <td><?= $ld['finish_date']; ?></td>
                                <td><?= $ld['reason']; ?></td>
                                <td><a href="<?= base_url('document/leave_proof/') . $ld['document'] ?>" class="badge badge-primary" target="_blank">Open</a></td>
                                <td>
                                    <?php if ($ld['status'] == 1) {
                                        echo '<p class="badge badge-success">Approved</p>';
                                    } else if ($ld['status'] == 0) {
                                        echo '<p class="badge badge-warning">Waiting</p>';
                                    } else if ($ld['status'] == 2) {
                                        echo '<p class="badge badge-danger">Declined</p>';
                                    } ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('hr/approve/') . $ld['user_nik'] . '/' . $ld['start_date'] . '/' . $ld['finish_date']; ?>" class="badge badge-success">Approve</a>
                                    <a href="<?= base_url('hr/decline/') . $ld['user_nik'] . '/' . $ld['start_date'] . '/' . $ld['finish_date']; ?>" class="badge badge-danger">Decline</a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <small class="text-primary pb-1">*) Date format is in YYYY-MM-DD</small>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->