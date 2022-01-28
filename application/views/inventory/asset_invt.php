<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-dark font-weight-bold"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <!-- Add new asset inventory -->
    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newAssetModal">
        <span class="icon text-white-50">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Item</span>
    </a>

    <!-- view asset  -->
    <a href="<?= base_url('inventory/list_inventory') ?>" class="btn btn-secondary btn-icon-split mb-3" target="_blank" rel="noopener noreferrer">
        <span class="icon text-white-50">
            <i class="bi bi-eye"></i>
        </span>
        <span class="text">View List Item</span>
    </a>

    <div class="card border-left-primary mb-3">
        <div class="row mx-4 my-3">
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Date Acquired</th>
                                <th>Position</th>
                                <th>Specifications/Descriptions</th>
                                <th>Value</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>QR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            ?>
                            <?php foreach ($inventory as $inv) : ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $inv['code'] ?></td>
                                    <td><?= $inv['name'] ?></td>
                                    <td><?= $inv['date_in'] ?></td>
                                    <td><?= $inv['room_name'] ?></td>
                                    <td><?= $inv['spec'] ?></td>
                                    <td><?= $inv['value'] ?></td>
                                    <td><?= $inv['user'] ?></td>
                                    <td>
                                        <?php if ($inv['status'] == 1) {
                                            echo '<p class="badge badge-success">Active</p>';
                                        } else if ($inv['status'] == 0) {
                                            echo '<p class="badge badge-warning">Maintenance</p>';
                                        } else if ($inv['status'] == 2) {
                                            echo '<p class="badge badge-danger">Decomissioned</p>';
                                        } ?>
                                    </td>
                                    <td>
                                        <a data-toggle="modal" data-target="#createQR" class="badge badge-primary" data-code="<?= $inv['code'] ?>" data-name="<?= $inv['name'] ?>" data-date="<?= $inv['date_in'] ?>" data-pos="<?= $inv['room_name'] ?>">View e-QR</a>
                                        <a data-toggle="modal" data-target="#transferAssetModal" class="badge badge-primary" data-code="<?= $inv['code'] ?>" data-name="<?= $inv['name'] ?>" data-position="<?= $inv['room_name'] ?>">Transfer</a>
                                        <a data-toggle="modal" data-target="#editAssetModal" class="badge badge-secondary text-white" data-id="<?= $inv['id'] ?>" data-code="<?= $inv['code'] ?>" data-name="<?= $inv['name'] ?>" data-user="<?= $inv['user'] ?>" data-spec="<?= $inv['spec'] ?>" data-value="<?= $inv['value'] ?>">Edit</a>
                                        <a href="<?= base_url('inventory/toggle_asset_status/') . $inv['id'] . "/" . $inv['status'] . "/" . $inv['name'] ?>" class="badge badge-warning">Toggle Status</a>
                                        <a data-toggle="modal" data-target="#deleteAssetModal" data-id="<?= $inv['id'] ?>" data-code="<?= $inv['code'] ?>" data-name="<?= $inv['name'] ?>" class="badge badge-danger">Delete</a>
                                        <?php
                                        if (empty($inv['user'])) {
                                            if ($user['role_id'] == '1') { ?>
                                                <a data-toggle="modal" data-target="#assignUserModal" class="badge badge-success" data-code="<?= $inv['code'] ?>" data-name="<?= $inv['name'] ?>" data-position="<?= $inv['room_name'] ?>">Assign User</a>
                                            <?php } else { ?>
                                                <a data-toggle="modal" data-target="#useAssetModal" class="badge badge-success" data-code="<?= $inv['code'] ?>" data-name="<?= $inv['name'] ?>" data-position="<?= $inv['room_name'] ?>" data-user="<?= $user['name'] ?>">Use Asset</a>
                                            <?php }
                                            ?>
                                        <?php } else { ?>
                                            <?php if ($user['role_id'] == '1') { ?>
                                                <a data-toggle="modal" data-target="#deleteAssignedUser" class="badge badge-dark" data-code="<?= $inv['code'] ?>" data-name="<?= $inv['name'] ?>" data-position="<?= $inv['room_name'] ?>" data-user="<?= $inv['user'] ?>">Delete User</a>
                                            <?php } else if ($inv['user'] == $user['name']) { ?>
                                                <a data-toggle="modal" data-target="#deleteUserModal" class="badge badge-dark" data-code="<?= $inv['code'] ?>" data-name="<?= $inv['name'] ?>" data-position="<?= $inv['room_name'] ?>" data-user="<?= $inv['user'] ?>">Finish Using</a>
                                            <?php }
                                            ?>
                                        <?php }
                                        ?>
                                        <!-- <a href="<?= base_url('inventory/qr_code') ?>" class="badge badge-light" target="_blank" rel="noopener noreferrer">QR Code</a> -->
                                    </td>
                                    <td>
                                        <img style="width: 100px;" src="<?= base_url('asset/img/QRCode/') . $inv['code'] . '.png'; ?>">
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

</div>
<!-- container-fluid -->
<script>
    $('#dataTable').dataTable({
        "Value": {
            render: $.fn.dataTable.render.number(',', '.', 0, 'IDR')
        }
    });
</script>

</div>
<!-- End of Main Content -->

<!-- Modal For Add Data -->
<div class="modal fade" id="newAssetModal" tabindex="-1" aria-labelledby="newAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newAssetModalLabel">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/add_asset') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Asset code -->
                        <label for="code" class="col-form-label">Item Code</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Automatically Coded" readonly>
                        <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- asset type -->
                        <label for="type" class="col-form-label">Type</label>
                        <div class="mb-1">
                            <select name="type" id="type" class="form-control" value="<?= set_value('type') ?>">
                                <option value="">--Select Type--</option>
                                <?php foreach ($inv_type as $type) : ?>
                                    <option value="<?= $type['code'] ?>"><?= $type['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('type', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Asset name -->
                        <label for="name" class="col-form-label">Item Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Add new item">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset Date of Acquirement -->
                        <label for="date" class="col-form-label">Date Acquired</label>
                        <input type="date" class="form-control" id="date_acquired" name="date_acquired" placeholder="Date Acquired">
                        <?= form_error('date_acquired', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- asset position -->
                        <label for="position" class="col-form-label">Position</label>
                        <div class="mb-1">
                            <select name="position" id="position" class="form-control" value="<?= set_value('position') ?>">
                                <option value="">--Select Type--</option>
                                <?php foreach ($room as $inv) : ?>
                                    <option value="<?= $inv['room_id'] ?>"><?= $inv['room_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('position', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Asset Specifications -->
                        <label for="spec" class="col-form-label">Specifications</label>
                        <input type="text" class="form-control" id="spec" name="spec" placeholder="No Special Characters">
                        <?= form_error('spec', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset value -->
                        <label for="value" class="col-form-label">Value</label>
                        <input type="text" class="form-control" id="value" name="value" placeholder="IDR">
                        <?= form_error('value', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- asset status -->
                        <label for="status" class="col-form-label">Status</label>
                        <div class="mb-1">
                            <select name="status" id="status" class="form-control" value="<?= set_value('status') ?>">
                                <option value="">--Select Type--</option>
                                <option value="1">Active</option>
                                <option value="0">Maintenance</option>
                                <option value="2">Decomissioned</option>
                            </select>
                            <?= form_error('status', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
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

<!-- Modal for QR  -->
<div class="modal fade" id="createQR" tabindex="-1" aria-labelledby="newAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newAssetModalLabel">QR Code Generator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/view_QR') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Asset code -->
                        <p>You're about to print QR Code for this following item:</p>
                        <label for="code" class="col-form-label">Item Code</label>
                        <input type="text" class="form-control mb-1" id="code" name="code" placeholder="" readonly>
                        <label for="code" class="col-form-label">Item Name</label>
                        <input type="text" class="form-control mb-1" id="name" name="name" placeholder="" readonly>
                        <label for="code" class="col-form-label">Date Acquired</label>
                        <input type="text" class="form-control mb-1" id="date" name="date" placeholder="" readonly>
                        <label for="code" class="col-form-label">Position</label>
                        <input type="text" class="form-control mb-1" id="pos" name="pos" placeholder="" readonly>
                        <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">View QR</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Transfer Asset -->
<div class="modal fade" id="transferAssetModal" tabindex="-1" aria-labelledby="transferAssetLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transferAssetLabel">Transfer Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/transfer_asset') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Asset code -->
                        <label for="transfer_asset_code" class="col-form-label">Item Code</label>
                        <input readonly type="text" class="form-control mb-1" id="transfer_asset_code" name="transfer_asset_code" placeholder="Add new item">
                        <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                        <!-- Asset name -->
                        <label for="transfer_asset_name" class="col-form-label">Item Name</label>
                        <input readonly type="text" class="form-control mb-1" id="transfer_asset_name" name="transfer_asset_name" placeholder="Add new item">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset From -->
                        <label for="asset_departure" class="col-form-label">Transfer from..</label>
                        <input readonly type="text" class="form-control mb-1" id="asset_departure" name="asset_departure" placeholder="Add new item">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="text-center">
                        <icon class="bi bi-arrow-down-up text-justify"></icon>
                    </div>
                    <div>
                        <!-- Asset To -->
                        <label for="asset_destination" class="col-form-label">to..</label>
                        <div class="mb-1">
                            <select name="asset_destination" id="asset_destination" class="form-control" value="<?= set_value('position') ?>">
                                <option value="">--Select Destination--</option>
                                <?php foreach ($room as $inv) : ?>
                                    <option value="<?= $inv['room_id'] ?>"><?= $inv['room_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('asset_destination', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Transfer</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal For Edit Data -->
<div class="modal fade" id="editAssetModal" tabindex="-1" aria-labelledby="editAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAssetModalLabel">Edit Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/edit_asset') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Asset code -->
                        <label for="url" class="col-form-label">Item Code</label>
                        <input type="text" class="form-control mb-1" readonly id="code" name="code" placeholder="Item Code">
                        <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset name -->
                        <label for="url" class="col-form-label">Item Name</label>
                        <input type="text" class="form-control mb-1" id="name" name="name" placeholder="Item Name">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset Spec -->
                        <label for="url" class="col-form-label">Specifications</label>
                        <input type="text" class="form-control mb-1" id="spec" name="spec" placeholder="">
                        <?= form_error('spec', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset value -->
                        <label for="url" class="col-form-label">Value</label>
                        <input type="text" class="form-control mb-1" id="value" name="value" placeholder="IDR">
                        <?= form_error('value', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal For Delete Data -->
<div class="modal fade" id="deleteAssetModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('inventory/delete_asset') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- asset id -->
                        <label for="url" class="col-form-label">ID</label>
                        <input type="text" class="form-control" id="delete_asset_id" name="delete_asset_id" readonly>
                        <!-- asset code -->
                        <label for="url" class="col-form-label">Code</label>
                        <input type="text" class="form-control" id="delete_asset_code" name="delete_asset_code" readonly>
                        <!-- asset name -->
                        <label for="url" class="col-form-label">Name</label>
                        <input type="text" class="form-control" id="delete_asset_name" name="delete_asset_name" readonly>
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

<!-- Modal For Assign User -->
<div class="modal fade" id="assignUserModal" tabindex="-1" role="dialog" aria-labelledby="assignUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignUserLabel">Heyho!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/assign_user') ?>" method="post">
                <div class="modal-body">
                    <p class=" mb-0">You're going to assign this asset,</p>
                    <div class="form-group">
                        <!-- asset id -->
                        <label for="url" class="col-form-label">Code</label>
                        <input type="text" class="form-control" id="assign_asset_code" name="assign_asset_code" readonly>
                        <!-- asset code -->
                        <label for="url" class="col-form-label">Name</label>
                        <input type="text" class="form-control" id="assign_asset_name" name="assign_asset_name" readonly>
                        <!-- asset name -->
                        <label for="url" class="col-form-label">Position</label>
                        <input type="text" class="form-control" id="assign_asset_position" name="assign_asset_position" readonly>
                        <!-- user -->
                        <div>
                            <label for="user_assigned" class="col-form-label">to be used by..</label>
                            <div class="mb-1">
                                <select name="user_assigned" id="user_assigned" class="form-control" value="<?= set_value('user_assigned') ?>">
                                    <option value="">--Select User--</option>
                                    <?php foreach ($user_data as $udat) : ?>
                                        <option value="<?= $udat['name'] ?>"><?= $udat['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('user_assigned', '<small class="text-danger pl-2">', '</small>') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal For Using Asset for User -->
<div class="modal fade" id="useAssetModal" tabindex="-1" role="dialog" aria-labelledby="useAssetModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="useAssetModal">Notice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/use_asset') ?>" method="post">
                <div class="modal-body">
                    <p class=" mb-0">You're going to use this asset:</p>
                    <div class="form-group">
                        <!-- asset id -->
                        <label for="url" class="col-form-label">Code</label>
                        <input type="text" class="form-control" id="assign_asset_code" name="assign_asset_code" readonly>
                        <!-- asset code -->
                        <label for="url" class="col-form-label">Name</label>
                        <input type="text" class="form-control" id="assign_asset_name" name="assign_asset_name" readonly>
                        <!-- asset name -->
                        <label for="url" class="col-form-label">Position</label>
                        <input type="text" class="form-control" id="assign_asset_position" name="assign_asset_position" readonly>
                        <!-- user -->
                        <label for="url" class="col-form-label">User</label>
                        <input type="text" class="form-control" id="assign_asset_user" name="assign_asset_user" readonly>
                    </div>
                    <p class=" mb-0">Please notice:</p>
                    <p class=" mb-0">1. Maintain the condition of the asset as if it is yours.</p>
                    <p class=" mb-0">2. If any damage occurs, contact your supervisor.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Use</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal For Delete User Assigned -->
<div class="modal fade" id="deleteAssignedUser" tabindex="-1" role="dialog" aria-labelledby="deleteAssignedLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAssignedHeader">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete asset user. Are you sure?</p>
            <form action="<?= base_url('inventory/delete_asset_user') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- asset id -->
                        <label for="url" class="col-form-label">Code</label>
                        <input type="text" class="form-control" id="delete_user_code" name="delete_user_code" readonly>
                        <!-- asset code -->
                        <label for="url" class="col-form-label">Name</label>
                        <input type="text" class="form-control" id="delete_user_name" name="delete_user_name" readonly>
                        <!-- asset pos -->
                        <label for="url" class="col-form-label">Position</label>
                        <input type="text" class="form-control" id="delete_user_position" name="delete_user_position" readonly>
                        <!-- asset user -->
                        <label for="url" class="col-form-label">User</label>
                        <input type="text" class="form-control" id="delete_user_user" name="delete_user_user" readonly>
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

<!-- Modal For Delete Asset User for User  -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModal">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about delete this asset from your responsibility. Are you sure?</p>
            <form action="<?= base_url('inventory/delete_user') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- asset id -->
                        <label for="url" class="col-form-label">Code</label>
                        <input type="text" class="form-control" id="delete_user_code" name="delete_user_code" readonly>
                        <!-- asset code -->
                        <label for="url" class="col-form-label">Name</label>
                        <input type="text" class="form-control" id="delete_user_name" name="delete_user_name" readonly>
                        <!-- asset pos -->
                        <label for="url" class="col-form-label">Position</label>
                        <input type="text" class="form-control" id="delete_user_position" name="delete_user_position" readonly>
                        <!-- asset user -->
                        <label for="url" class="col-form-label">User</label>
                        <input type="text" class="form-control" id="delete_user_user" name="delete_user_user" readonly>
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