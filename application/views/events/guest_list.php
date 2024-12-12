<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <?= $this->session->flashdata('guest_list_message'); ?>
    <div class="row">
        <div class="col-lg-12">
            <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newGuest">
                <span class="icon text-white-50">
                    <i class="fas fa-fw fa-user-plus"></i>
                </span>
                <span class="text">Add New Guest</span>
            </a>
            <a href="" class="btn btn-success btn-icon-split mb-3 mx-1">
                <span class="icon text-white-50">
                    <i class="fas fa-fw fa-user-plus"></i>
                </span>
                <span class="text">Import Guest</span>
            </a>
        </div>
    </div>
    
    <div class="card shadow border-left-primary mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Guest ID</th>
                            <th>Name</th>
                            <th>Number Pax</th>
                            <th>Category</th>
                            <th>Seating</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>RSVP Status</th>
                            <th>QR</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($guest_list as $gl) : ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $gl['guest_id']; ?></td>
                                <td><?= $gl['full_name']; ?></td>
                                <td><?= $gl['num_pax']; ?></td>
                                <td><?= $gl['title']; ?></td>
                                <td><?= $gl['seating']; ?></td>
                                <td><?= $gl['address']; ?></td>
                                <td><?= $gl['email']; ?></td>
                                <td><?= $gl['phone']; ?></td>
                                <td>
                                    <?php if ($gl['rsvp_status'] == 0) {
                                        echo '<p class="badge badge-warning">Pending</p>';
                                    } else if ($gl['rsvp_status'] == 1) {
                                        echo '<p class="badge badge-success">Confirmed</p>';
                                    } else if ($gl['rsvp_status'] == 2) {
                                        echo '<p class="badge badge-danger">Declined</p>';
                                    }; ?>
                                </td>
                                <td>
                                    <!-- <img style="width: 100px;" src="<?= base_url('asset/img/QRCode/') . $inv['code'] . '.png'; ?>"> -->
                                </td>
                                <td>
                                    <a data-toggle="modal" data-target="#sendInvite" data-id="<?= $gl['id'] ?>" data-name="<?= $gl['full_name'] ?>" class="badge badge-success clickable"><i class="bi bi-send-check"> </i>Send Invititation</a>
                                    <a data-toggle="modal" data-target="#editGuest" data-guest-id="<?= $gl['guest_id']; ?>" data-name="<?= $gl['full_name']; ?>" data-num-pax="<?= $gl['num_pax']; ?>" data-category="<?= $gl['category']; ?>" data-address="<?= $gl['address']; ?>" data-email="<?= $gl['email']; ?>" data-phone="<?= $gl['phone']; ?>" data-rsvp="<?= $gl['rsvp_status']; ?>"class="badge badge-warning clickable"><i class="bi bi-pencil-fill"> </i>Edit</a>
                                    <a data-toggle="modal" data-target="#deleteGuest" data-guest-id="<?= $gl['guest_id']; ?>" data-guest-name="<?= $gl['full_name']; ?>" class="badge badge-danger clickable"><i class="bi bi-trash3-fill"> </i>Delete</a>
                                </td>
                            </tr>
                            <?php $i++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal for add new guest -->
<div class="modal fade" id="newGuest" tabindex="-1" aria-labelledby="newGuestLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newGuestLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('events/add_guest') ?>" method="post">
                <div class="modal-body">
                    <!-- input event ID -->
                    <div class="form-group">
                        <label for="event_id" class="col-form-label">Event ID</label>
                        <input type="text" readonly class="form-control" id="event_id" name="event_id" value="<?= $user['event_id']; ?>">
                        <?= form_error('event_id', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input guest ID -->
                    <?php 
                        //randomize guest_id
                        $date = time();
                        $year = date('y');
                        $week = date('W');

                        $n = 3;
                        $result = $year . $week . bin2hex(random_bytes($n));
                        $token = hash('crc32c', $result);
                        $guest_id = 'G'. $token;
                    ?>
                    <div class="form-group">
                        <label for="guest_id" class="col-form-label">Guest ID</label>
                        <input type="text" class="form-control" id="guest_id" name="guest_id" value="<?= $guest_id; ?>">
                        <?= form_error('guest_id', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input nama -->
                    <div class="form-group">
                        <label for="full_name" class="col-form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Full Name" value="<?= set_value('full_name'); ?>">
                        <?= form_error('full_name', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input num_pax -->
                    <div class="form-group">
                        <label for="num_pax" class="col-form-label">Number of Pax</label>
                        <input type="number" class="form-control" min="0" id="num_pax" name="num_pax" value="<?= set_value('num_pax'); ?>">
                        <?= form_error('num_pax', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input seating -->
                    <div class="form-group">
                        <label for="category" class="col-form-label">Category</label>
                        <select name="category" id="category" class="form-control" value="<?= set_value('position') ?>">
                            <option value="">--Select Type--</option>
                            <?php foreach ($guest_cat as $cat) : ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('category', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input address -->
                    <div class="form-group">
                        <label for="address" class="col-form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Guest's address" value="<?= set_value('address'); ?>">
                        <?= form_error('address', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input email -->
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Guest's email" value="<?= set_value('email'); ?>">
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input address -->
                    <div class="form-group">
                        <label for="phone" class="col-form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Guest's phone" value="<?= set_value('phone'); ?>">
                        <?= form_error('phone', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input user_role -->
                    <div class="form-group">
                        <label for="rsvp_status" class="col-form-label">RSVP</label>
                        <select name="rsvp_status" id="rsvp_status" class="form-control">
                            <option value="">--Select RSVP Status--</option>
                            <option value="0">Pending</option>
                            <option value="1">Confirmed</option>
                            <option value="2">Declined</option>
                        </select>
                        <?= form_error('rsvp_status', '<small class="text-danger pl-3">', '</small>') ?>
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

<!-- Modal for edit  guest -->
<div class="modal fade" id="editGuest" tabindex="-1" aria-labelledby="editGuestLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGuestLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('events/edit_guest') ?>" method="post">
                <div class="modal-body">
                    <!-- input event ID -->
                    <div class="form-group">
                        <label for="event_id" class="col-form-label">Event ID</label>
                        <input readonly type="text" class="form-control" id="event_id" name="event_id" value="<?= $user['event_id']; ?>">
                        <?= form_error('event_id', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label for="guest_id" class="col-form-label">Guest ID</label>
                        <input readonly type="text" class="form-control" id="guest_id" name="guest_id">
                        <?= form_error('guest_id', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input nama -->
                    <div class="form-group">
                        <label for="full_name" class="col-form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Full Name" >
                        <?= form_error('full_name', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input num_pax -->
                    <div class="form-group">
                        <label for="num_pax" class="col-form-label">Number of Pax</label>
                        <input type="number" class="form-control" min="0" id="num_pax" name="num_pax">
                        <?= form_error('num_pax', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input seating -->
                    <div class="form-group">
                        <label for="category" class="col-form-label">Category</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">--Select Type--</option>
                            <?php foreach ($guest_cat as $cat) : ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('category', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input address -->
                    <div class="form-group">
                        <label for="address" class="col-form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Guest's address" >
                        <?= form_error('address', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input email -->
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Guest's email">
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input address -->
                    <div class="form-group">
                        <label for="phone" class="col-form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Guest's phone">
                        <?= form_error('phone', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- input user_role -->
                    <div class="form-group">
                        <label for="rsvp_status" class="col-form-label">RSVP</label>
                        <select name="rsvp_status" id="rsvp_status" class="form-control">
                            <option value="">--Select RSVP Status--</option>
                            <option value="0">Pending</option>
                            <option value="1">Confirmed</option>
                            <option value="2">Declined</option>
                        </select>
                        <?= form_error('rsvp_status', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal For Delete Data -->
<div class="modal fade" id="deleteGuest" tabindex="-1" role="dialog" aria-labelledby="deleteGuestLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteGuestLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('events/delete_guest/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- menu id -->
                        <label for="deletemenu" class="col-form-label">ID</label>
                        <input type="text" class="form-control" id="delete_guest_id" name="delete_guest_id" readonly>
                        <!-- productmenu name -->
                        <label for="deletemenu" class="col-form-label">Product Category Name</label>
                        <input type="text" class="form-control" id="delete_guest_name" name="delete_guest_name" readonly>
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