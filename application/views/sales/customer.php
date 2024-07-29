<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <!-- Add new asset inventory -->
    <!-- <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newCustModal">
        <span class="icon text-white-50">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Customer</span>
    </a> -->

    <div class="card shadow border-left-primary mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <!-- <th>Bank Account</th> -->
                            <!-- <th>Terms</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($customer as $cust) : ?>
                            <tr>
                                <td><?= $i ?></td>
                                <?php if ($cust['id'] < 10) { ?>
                                    <td>CUST-000<?= $cust['id']; ?></td>
                                <?php } else if ($cust['id'] < 100) { ?>
                                    <td>CUST-00<?= $cust['id']; ?></td>
                                <?php } else if ($cust['id'] >= 100) { ?>
                                    <td>CUST-0<?= $cust['id']; ?></td>
                                <?php }; ?>
                                <td><?= $cust['name']; ?></td>
                                <td><?= $cust['address'] . ' ' . $cust['province'] . ' ' . $cust['country'] . ' ' . $cust['postal']; ?></td>
                                <td><?= $cust['phone_number']; ?></td>
                                <td><?= $cust['email']; ?></td>
                                <!-- <td><?= $cust['bank_account']; ?></td> -->
                                <!-- <td><?= $cust['terms']; ?></td> -->
                                </td>
                                <td>
                                    <a data-toggle="modal" data-target="#editCustomerModal" class="badge badge-warning clickable" data-id="<?= $cust['id'] ?>" data-name="<?= $cust['name'] ?>" data-address="<?= $cust['address'] ?>" data-phone="<?= $cust['phone_number'] ?>" data-email="<?= $cust['email'] ?>"><i class="bi bi-pencil-fill"></i>Edit</a>
                                    <!-- <a data-toggle="modal" data-target="#deleteCustomerModal" data-id="<?= $cust['id'] ?>" data-name="<?= $cust['name'] ?>" class="badge badge-danger clickable"><i class="bi bi-trash-fill"> </i>Delete</a> -->
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
<!-- /.container-fluid -->
</div>
<!-- Modal For Add Data -->
<div class="modal fade" id="newCustModal" tabindex="-1" aria-labelledby="newCustModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCustModalLabel">Add New Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('sales/add_customer') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Asset code -->
                        <label for="name" class="col-form-label">Customer Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Add customer's name">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset name -->
                        <label for="address" class="col-form-label">Customer Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Add customer's address">
                        <?= form_error('address', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset Date of Acquirement -->
                        <label for="email" class="col-form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Add customer's email">
                        <?= form_error('email', '<small class="text-danger pl-2">', '</small>') ?>
                        <small>Not Compulsory</small>
                    </div>
                    <div class="form-group">
                        <!-- Asset Date of Acquirement -->
                        <label for="phone_number" class="col-form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Add customer's phone number">
                        <?= form_error('phone_number', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset Specifications -->
                        <label for="account" class="col-form-label">Bank Account</label>
                        <input type="text" class="form-control" id="account" name="account" placeholder="Bank Account">
                        <?= form_error('spec', '<small class="text-danger pl-2">', '</small>') ?>
                        <small>Not Compulsory</small>
                    </div>
                    <div class="form-group">
                        <!-- Terms -->
                        <label for="terms" class="col-form-label">Terms</label>
                        <select name="terms" id="terms" class="form-control" value="<?= set_value('terms') ?>">
                            <option value="">--Select Terms--</option>
                            <?php foreach ($terms as $tm) : ?>
                                <option value="<?= $tm['id'] ?>"><?= $tm['terms'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('terms', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal For Edit Data -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCustomerLabel">Edit Customer Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('sales/edit_customer') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- customer ud -->
                        <label for="id" class="col-form-label">Customer ID</label>
                        <input type="text" class="form-control" id="id" name="id" readonly>
                        <?= form_error('id', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- customer name -->
                        <label for="name" class="col-form-label">Customer Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- customer address -->
                        <label for="address" class="col-form-label">Customer Address</label>
                        <input type="text" class="form-control" id="address" name="address">
                        <?= form_error('address', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- customer email -->
                        <label for="email" class="col-form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Add customer's email">
                        <?= form_error('email', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- customer number-->
                        <label for="phone_number" class="col-form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Add customer's phone number">
                        <?= form_error('phone_number', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal For Delete Data -->
<div class="modal fade" id="deleteCustomerModal" tabindex="-1" aria-labelledby="deleteCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCustomerLabel">Delete Customer Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this customer. Are you sure?</p>
            <form action="<?= base_url('sales/delete_customer') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- customer code -->
                        <label for="code" class="col-form-label">Customer Code</label>
                        <input type="text" class="form-control" id="id" name="id" readonly>
                        <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- customer name -->
                        <label for="name" class="col-form-label">Customer Name</label>
                        <input type="text" class="form-control" id="name" name="name" readonly>
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Main Content -->