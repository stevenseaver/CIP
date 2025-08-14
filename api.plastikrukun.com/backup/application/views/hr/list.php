<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newUser">
                <span class="icon text-white-50">
                    <i class="fas fa-fw fa-user-plus"></i>
                </span>
                <span class="text">Add New Employee</span>
            </a>
            <a href="<?= base_url('hr/restart_count/0')?>" class="btn btn-light btn-icon-split mb-3">
                <span class="icon text-white-50">
                    <i class="bi bi-recycle "></i>
                </span>
                <span class="text">Restart Leave Count</span>
            </a>
        </div>
    </div>

    <div class="card shadow border-left-primary mb-4">
        <div class="card-header py-2">
            <h5 class="m-0 font-weight-bold text-primary">User Data</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Date of Birth *)</th>
                            <th>ID Card No.</th>
                            <th>Address</th>
                            <th>Mobile Phone</th>
                            <th>Since</th>
                            <th>Leave Count Left</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($userdata as $u) : ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $u['name']; ?></td>
                                <td><?= $u['role']; ?></td>
                                <td><?= $u['nik']; ?></td>
                                <td><?= $u['email']; ?></td>
                                <td><?= $u['dob']; ?></td>
                                <td><?= $u['noktp']; ?></td>
                                <td><?= $u['address'] . ', ' . $u['city'] . ', ' . $u['province'] . ', ' . $u['country'] . ', ' . $u['postal'] ; ?></td>
                                <td><?= $u['phone_number']; ?></td>
                                <td><?= date('d F Y', $u['date_created']); ?></td>
                                <td><?= $u['leave_count']; ?></td>
                                <td>
                                    <?php if ($u['is_active']) {
                                        echo '<p class="badge badge-success">Active</p>';
                                    } else {
                                        echo '<p class="badge badge-danger">Not Active</p>';
                                    } ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('hr/toggleactive/') . $u['id'] . '/' . $u['is_active'] . '/' . urldecode($u['name']) ?>" class="badge badge-primary"><i class="bi bi-toggles"> </i>Toggle Active</a>
                                    <!-- <a href="<?= base_url('hr/deleteuser/') . $u['id'] . '/' . urldecode($u['name']) ?>" class="badge badge-danger">Delete</a> -->
                                    <a href="<?= base_url('hr/restart_count/' . $u['id'])?>" class="badge badge-warning clickable"><i class="bi bi-arrow-clockwise"> </i>Restart Leave Count</a>
                                    <a data-toggle="modal" data-target="#deleteEmployee" data-id="<?= $u['id'] ?>" data-name="<?= $u['name'] ?>" class="badge badge-danger clickable"><i class="bi bi-trash"> </i>Delete</a>
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

<!-- Modal For Add New User -->
<div class="modal fade" id="newUser" tabindex="-1" aria-labelledby="newUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newUserLabel">Add New Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('hr/addEmployee') ?>" method="post">
                <div class="modal-body">
                    <!-- input nama -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input Username/ERN/NIK -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="nik" name="nik" placeholder="Employee Registration Number">
                        <small class="text-primary ml-2">Will be used as login detail.</small>
                        <?= form_error('nik', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input alamat email -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input alamat noktp -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="noktp" name="noktp" placeholder="ID Card Number">
                        <?= form_error('noktp', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input alamat dob -->
                    <div class="form-group">
                        <input type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth">
                        <?= form_error('dob', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input nomor HP -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="hp" name="hp" placeholder="Mobile Phone Number">
                        <?= form_error('hp', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input user_role -->
                    <div class="form-group">
                        <select name="role_id" id="role_id" class="form-control">
                            <option value="">--Select Role--</option>
                            <?php foreach ($role as $r) : ?>
                                <?php if ($r['id'] != '3') { ?>
                                    <option value="<?= $r['id'] ?>"><?= $r['role'] ?></option>
                                <?php } else {
                                } ?>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('role_id', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input alamat -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                        <?= form_error('address', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg mb-1">
                            <input type="text" class="form-control form-control-user" id="city" name="city" placeholder="City">
                            <?= form_error('city', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- state/province -->
                        <div class="col-lg">
                            <input type="text" class="form-control form-control-user" id="province" name="province" placeholder="Province or State">
                            <?= form_error('province', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-9 mb-2">
                            <input type="text" class="form-control form-control-user" id="country" name="country" placeholder="Country">
                            <?= form_error('country', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- zipcode -->
                        <div class="col-lg-3 mb-2">
                            <input type="text" class="form-control form-control-user" id="postal" name="postal" placeholder="Postal Code">
                            <?= form_error('postal', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <!-- password -->
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
                            <small class="text-primary ml-2">Minimum 8 characters.</small>
                            <?= form_error('password1', '<small class="text-danger pl-3">', '</small>') ?>
                        </div><!-- repeat passweord -->
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="password2" name="password2" placeholder="Repeat Password">
                            <?= form_error('password2', '<small class="text-danger pl-3">', '</small>') ?>
                            <div class="form-check ml-0 mt-1">
                                <input class="form-check-input" type="checkbox" id="show_pass" name="show_pass" onclick="visibilePassword()" />
                                <label class="small" for="show_pass">Show password</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal For Delete User Account -->
<div class="modal fade" id="deleteEmployee" tabindex="-1" aria-labelledby="deleteEmployeeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteEmployeeLabel">Delete User Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('hr/deleteEmployee') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- User ID -->
                        <label for="url" class="col-form-label">User ID</label>
                        <input type="text" class="form-control mb-1" readonly id="delete_id" name="delete_id" placeholder="Item Name">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- User Name-->
                        <label for="url" class="col-form-label">User Name</label>
                        <input type="text" readonly class="form-control mb-1" id="delete_name" name="delete_name" placeholder="Item Code">
                        <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
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