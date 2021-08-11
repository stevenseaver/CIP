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
            <?= $this->session->flashdata('message'); ?>

            <!-- <a href="" class="btn btn-primary mb-3">Add New User</a> -->
            <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newUser">
                <span class="icon text-white-50">
                    <i class="fas fa-fw fa-user-plus"></i>
                </span>
                <span class="text">Add New User</span>
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
                            <th>Role</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Date of Birth</th>
                            <th>ID Card No.</th>
                            <th>Address</th>
                            <th>Mobile Phone</th>
                            <th>Since</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Role</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Date of Birth</th>
                            <th>ID Card No.</th>
                            <th>Address</th>
                            <th>Mobile Phone</th>
                            <th>Since</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($userdata as $u) : ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $u['role']; ?></td>
                                <td><?= $u['name']; ?></td>
                                <td><?= $u['nik']; ?></td>
                                <td><?= $u['email']; ?></td>
                                <td><?= $u['dob']; ?></td>
                                <td><?= $u['noktp']; ?></td>
                                <td><?= $u['address']; ?></td>
                                <td><?= $u['phone_number']; ?></td>
                                <td><?= date('d F Y', $u['date_created']); ?></td>
                                <td>
                                    <?php if ($u['is_active']) {
                                        echo 'Active';
                                    } else {
                                        echo 'Not Active';
                                    } ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/toggleactive/') . $u['id'] . '/' . $u['is_active'] . '/' . urldecode($u['name']) ?>" class="badge badge-warning">Toggle Active</a>
                                    <a href="<?= base_url('admin/deleteuser/') . $u['id'] . '/' . urldecode($u['name']) ?>" class="badge badge-danger">Delete</a>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal For Add New User -->
<div class="modal fade" id="newUser" tabindex="-1" aria-labelledby="newUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newUserLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/addUser') ?>" method="post">
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
                    <!-- input nomor HP -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="hp" name="hp" placeholder="Mobile Phone Number">
                        <?= form_error('hp', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input alamat -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                        <?= form_error('address', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input user_role -->
                    <div class="form-group">
                        <select name="role_id" id="role_id" class="form-control">
                            <option value="">--Select Role--</option>
                            <?php foreach ($role as $r) : ?>
                                <option value="<?= $r['id'] ?>"><?= $r['role'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('role_id', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- password -->
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
                            <small class="text-primary ml-2">Minimum 8 characters.</small>
                            <?= form_error('password1', '<small class="text-danger pl-3">', '</small>') ?>
                        </div><!-- repeat passweord -->
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="password2" name="password2" placeholder="Repeat Password">
                            <?= form_error('password2', '<small class="text-danger pl-3">', '</small>') ?>
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