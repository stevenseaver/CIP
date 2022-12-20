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
    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newSupModal">
        <span class="icon text-white-50">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Supplier</span>
    </a>
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
                            <th>Bank Account</th>
                            <th>Terms</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($supplier as $sup) : ?>
                            <tr>
                                <td><?= $i ?></td>
                                <?php if ($sup['id'] < 10) { ?>
                                    <td>SUP-000<?= $sup['id']; ?></td>
                                <?php } else if ($sup['id'] < 100) { ?>
                                    <td>SUP-00<?= $sup['id']; ?></td>
                                <?php } else if ($sup['id'] >= 100) { ?>
                                    <td>SUP-0<?= $sup['id']; ?></td>
                                <?php }; ?>
                                <td><?= $sup['supplier_name']; ?></td>
                                <td><?= $sup['address']; ?></td>
                                <td><?= $sup['phone']; ?></td>
                                <td><?= $sup['email']; ?></td>
                                <td><?= $sup['bank_account']; ?></td>
                                <td><?= $sup['terms']; ?></td>
                                </td>
                                <td>
                                    <a data-toggle="modal" data-target="#editSupplierModal" data-id="<?= $sup['id'] ?>" data-name="<?= $sup['supplier_name'] ?>" data-address="<?= $sup['address'] ?>" data-phone="<?= $sup['phone'] ?>" data-email="<?= $sup['email'] ?>" data-account="<?= $sup['bank_account'] ?>" data-terms="<?= $sup['terms_id'] ?>" class="badge badge-success clickable">Edit</a>
                                    <a data-toggle="modal" data-target="#deleteSupplierModal" data-id="<?= $sup['id'] ?>" data-name="<?= $sup['supplier_name'] ?>" class="badge badge-danger clickable">Delete</a>
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
<div class="modal fade" id="newSupModal" tabindex="-1" aria-labelledby="newSupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSupModalLabel">Add New Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('purchasing/add_supplier') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Asset code -->
                        <label for="name" class="col-form-label">Supplier Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Add supplier's name">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset name -->
                        <label for="address" class="col-form-label">Supplier Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Add supplier's address">
                        <?= form_error('address', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset Date of Acquirement -->
                        <label for="email" class="col-form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Add supplier's email">
                        <?= form_error('email', '<small class="text-danger pl-2">', '</small>') ?>
                        <small>Not Compulsory</small>
                    </div>
                    <div class="form-group">
                        <!-- Asset Date of Acquirement -->
                        <label for="phone_number" class="col-form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Add supplier's phone number">
                        <?= form_error('phone_number', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset Specifications -->
                        <label for="account" class="col-form-label">Bank Account</label>
                        <input type="text" class="form-control" id="account" name="account" placeholder="Supplier bank account">
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
<div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSupplierLabel">Edit Supplier Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('purchasing/edit_supplier') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- supplier ud -->
                        <label for="id" class="col-form-label">Supplier ID</label>
                        <input type="text" class="form-control" id="id" name="id" readonly>
                        <?= form_error('id', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- supplier name -->
                        <label for="name" class="col-form-label">Supplier Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Supplier address -->
                        <label for="address" class="col-form-label">Supplier Address</label>
                        <input type="text" class="form-control" id="address" name="address">
                        <?= form_error('address', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- supplier email -->
                        <label for="email" class="col-form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Add supplier's email">
                        <?= form_error('email', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- supplier number-->
                        <label for="phone_number" class="col-form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Add supplier's phone number">
                        <?= form_error('phone_number', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- sup bank account assigned -->
                        <label for="account" class="col-form-label">Bank Account</label>
                        <input type="text" class="form-control" id="account" name="account" placeholder="Bank Account">
                        <?= form_error('spec', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- payment Terms -->
                        <label for="terms" class="col-form-label">Terms</label>
                        <select name="terms" id="terms" class="form-control" value="<?= set_value('terms') ?>">
                            <option value="">--Select Type--</option>
                            <?php foreach ($terms as $tm) : ?>
                                <option value="<?= $tm['id'] ?>"><?= $tm['terms'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('terms', '<small class="text-danger pl-2">', '</small>') ?>
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
<div class="modal fade" id="deleteSupplierModal" tabindex="-1" aria-labelledby="deleteSupplierLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSupplierLabel">Delete Customer Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this supplier. Are you sure?</p>
            <form action="<?= base_url('purchasing/delete_supplier') ?>" method="post">
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