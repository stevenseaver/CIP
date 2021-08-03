<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <?= $this->session->flashdata('message'); ?>
            <div class="card border-left-primary mb-3">
                <div class="card-body">
                    <?= form_open_multipart('employee/submit'); ?>
                    <div class="form-group row">
                        <!-- show ERN -->
                        <label for="nik" class="col-sm-3 col-form-label">ERN</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nik" name="nik" value="<?= $user['nik']; ?>" readonly>
                            <?= form_error('nik', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- show name -->
                        <label for="fullname" class="col-sm-3 col-form-label">Full Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>" readonly>
                            <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- input leave_type -->
                        <label for="leave_type" class="col-sm-3 col-form-label">Type</label>
                        <div class="col-sm-9">
                            <select name="leave_type" id="leave_type" class="form-control" value="<?= set_value('leave_type') ?>">
                                <option value="">--Select Type--</option>
                                <?php foreach ($leavetype as $l) : ?>
                                    <option value="<?= $l['id'] ?>"><?= $l['type'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('leave_type', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- fill start date -->
                        <label for="start_date" class="col-sm-3 col-form-label">Start Date</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= set_value('start_date') ?>">
                            <?= form_error('start_date', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- fill finish date -->
                        <label for="finish_date" class="col-sm-3 col-form-label">Finish Date</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="finish_date" name="finish_date" value="<?= set_value('finish_date') ?>">
                            <?= form_error('finish_date', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- fill reason -->
                        <label for="reason" class="col-sm-3 col-form-label">Reason</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="reason" name="reason" placeholder="Fill in your reason" value="<?= set_value('reason') ?>">
                            <?= form_error('reason', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- upload document -->
                        <label for="proof" class="col-sm-3 col-form-label">Document</label>
                        <div class="col-sm-9">
                            <input type="file" class="custom-file-input" id="proof" name="proof">
                            <label class="custom-file-label" for="proof">Choose file</label>
                            <small class="text-primary">Maximum 2 MB. Required for sick leave.</small>
                            <?= form_error('proof', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-fw fa-arrow-right"></i>
                                </span>
                                <span class="text">Submit Request</span></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-left-primary mb-4">
        <div class="card-header py-2">
            <h5 class="m-0 font-weight-bold text-primary">Your Request</h5>
        </div>
        <div class="card-body">
            <a href="<?= base_url("employee/leaveform"); ?>" class="btn btn-primary mb-3 text-white">Refresh</a>
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
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($leavedata as $ld) : ?>
                            <?php
                            if ($ld['user_nik'] != $user['nik']) {
                                continue;
                            } else {
                            }
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $ld['user_nik'] ?></td>
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