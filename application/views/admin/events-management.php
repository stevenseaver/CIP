<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <?= $this->session->flashdata('event_management_message'); ?>

    <div class="row">
        <div class="col-lg-12">
            <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newUser">
                <span class="icon text-white-50">
                    <i class="fas fa-fw fa-user-plus"></i>
                </span>
                <span class="text">Add New Events</span>
            </a>
        </div>
    </div>

    <div class="card shadow border-left-primary mb-4">
        <div class="card-header py-2">
            <h5 class="m-0 font-weight-bold text-primary">Events Data</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile Phone</th>
                            <th>Event ID</th>
                            <th>Event Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Location</th>
                            <th>Description</th>
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
                                <td><?= $u['email']; ?></td>
                                <td><?= $u['phone_number']; ?></td>
                                <td><?= $u['event_id']; ?></td>
                                <td><?= $u['event_name']; ?></td>
                                <td><?= date('d F Y H:i', $u['event_start_date']); ?></td>
                                <td><?= date('d F Y H:i', $u['event_end_date']); ?></td>
                                <td><?= $u['event_location']; ?></td>
                                <td><?= $u['event_description']; ?></td>
                                <!-- <td><?= $u['address'] . ', ' . $u['city'] . ', ' . $u['province'] . ', ' . $u['country'] . ', ' . $u['postal'] ; ?></td> -->
                                <!-- <td><?= date('d F Y', $u['date_created']); ?></td> -->
                                <td>
                                    <?php if ($u['is_active']) {
                                        echo '<p class="badge badge-success">Active</p>';
                                    } else {
                                        echo '<p class="badge badge-danger">Not Active</p>';
                                    } ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/toggleactive/') . $u['id'] . '/' . $u['is_active'] . '/' . urldecode($u['name']) ?>" class="badge badge-warning"><i class="bi bi-toggles"> </i>Toggle Active</a>
                                    <!-- <a href="<?= base_url('admin/deleteuser/') . $u['id'] . '/' . urldecode($u['name']) ?>" class="badge badge-danger">Delete</a> -->
                                    <a data-toggle="modal" data-target="#deleteAccount" data-id="<?= $u['id'] ?>" data-name="<?= $u['name'] ?>" class="badge badge-danger clickable"><i class="bi bi-person-dash"> </i>Delete</a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- <small class="text-primary pb-1">*) Date format is in YYYY-MM-DD</small> -->
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
                <h5 class="modal-title" id="newUserLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/addUser') ?>" method="post">
                <div class="modal-body">
                    <!-- input nama -->
                    <div class="form-group">
                        <label for="name" class="col-form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="row form group mb-3">
                        <!-- input Username/ERN/NIK -->
                        <div class="col">
                            <label for="nik" class="col-form-label">Username</label>
                            <input type="text" class="form-control" id="nik" name="nik" placeholder="User Registration Number">
                            <small class="text-primary ml-2">Will be used as login detail.</small>
                            <?= form_error('nik', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- input alamat email -->
                        <div class="col">
                            <label for="email" class="col-form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <div class="row form group mb-3">
                        <!-- generate event ID -->
                        <?php 
                            $date = time();
                            $year = date('y');
                            $week = date('W');
                            $day = date('d');

                            $n = 2;
                            $result = bin2hex(random_bytes($n));
                            $unique_event_id = 'E'. $year  . $week . $result;
                        ?>
                        <div class="col">
                            <label for="event_id" class="col-form-label">Event ID</label>
                            <input type="text" class="form-control" id="event_id" name="event_id" value="<?= $unique_event_id; ?>">
                            <?= form_error('event_id', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- input nama event -->
                        <div class="col">
                            <label for="event_name" class="col-form-label">Event Name</label>
                            <input type="text" class="form-control" id="event_name" name="event_name" placeholder="Event Name">
                            <?= form_error('event_name', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <div class="row form group mb-3">
                        <!-- input alamat dob -->
                        <div class="col">
                            <label for="event_start_date" class="col-form-label">Event Start Date</label>
                            <input type="datetime-local" class="form-control" id="event_start_date" name="event_start_date" placeholder="">
                            <?= form_error('event_start_date', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- input alamat dob -->
                        <div class="col">
                            <label for="event_end_date" class="col-form-label">Event End Date</label>
                            <input type="datetime-local" class="form-control" id="event_end_date" name="event_end_date" placeholder="">
                            <?= form_error('event_end_date', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <div class="row form group mb-3">
                        <!-- input alamat dob -->
                        <div class="col">
                            <label for="event_location" class="col-form-label">Event Location</label>
                            <input type="text" class="form-control" id="event_location" name="event_location" placeholder="Event locations">
                            <small>Can be added later.</small>
                            <?= form_error('event_location', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- input alamat dob -->
                        <div class="col">
                            <label for="event_description" class="col-form-label">Event Description</label>
                            <input type="text" class="form-control" id="event_description" name="event_description" placeholder="Event description">
                            <small>Can be added later.</small>
                            <?= form_error('event_description', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <div class="row form group mb-3">
                        <!-- input alamat dob -->
                        <div class="col">
                            <label for="dob" class="col-form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth">
                            <?= form_error('dob', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- input nomor HP -->
                        <div class="col">
                            <label for="hp" class="col-form-label">Mobile Phone Number</label>
                            <input type="text" class="form-control" id="hp" name="hp" placeholder="Mobile Phone Number">
                            <?= form_error('hp', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <!-- input alamat -->
                    <div class="form-group">
                        <label for="address" class="col-form-label">Event Complete Address</label>
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
                    <div class="form-group row mb-0">
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
                    <small>Can be added later.</small>
                    <!-- input user_role -->
                    <div class="form-group">
                        <label for="role_id" class="col-form-label">Role</label>
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
                            <label for="role_id" class="col-form-label">Password</label>
                            <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
                            <small class="text-primary ml-2">Minimum 8 characters.</small>
                            <?= form_error('password1', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- repeat passweord -->
                        <div class="col-sm-6">
                            <label for="role_id" class="col-form-label">Repeat Password</label>
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
<div class="modal fade" id="deleteAccount" tabindex="-1" aria-labelledby="deleteAccountLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountLabel">Delete User Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/deleteuser') ?>" method="post">
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