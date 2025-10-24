<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <!-- back button -->
    <a href="<?= base_url('inventory/assets') ?>" class="btn btn-white btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left text-dark"></i>
        </span>
        <span class="text text-dark">Back</span>
    </a>

    <!-- add data button -->
    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newMaintenanceData">
        <span class="icon text-white-50">
            <i class="bi bi-tools text-white"></i>
        </span>
        <span class="text text-white">Add Maintenance Data</span>
    </a>

    <!-- Modal for add items -->
    <div class="modal fade" id="newMaintenanceData" tabindex="-1" aria-labelledby="newMaintenanceDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newMaintenanceDataLabel">Add New Maintenance Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('inventory/add_maintenance_data/' . $inventory['id']); ?>" method="post">
                        <div class="form-group">
                            <!-- Inventory code -->
                            <label for="code" class="col-form-label">Item Code</label>
                            <input type="text" class="form-control mb-1" id="code" name="code" readonly value="<?= $inventory['code'] ?> ">
                            <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                        <!-- Date -->
                        <div class="form-group">
                            <label for="report_date" class="col-form-label">Date</label>
                            <input type="datetime-local" class="form-control" id="report_date" name="report_date" value="">
                            <?= form_error('report_date', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <!-- Analysis -->
                            <label for="analysis" class="col-form-label">Problems/Analysis</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control " id="analysis" name="analysis" aria-label="analysis" aria-describedby="basic-addon1"placeholder="Tambahkan permasalahan yang terjadi dan analisisnya. Jika perawatan rutin, tulis sesuai perawatan rutin.">
                                <?= form_error('analysis', '<small class="text-danger pl-2">', '</small>') ?>
                            </div>
                            <label for="analysis" class="col-form-label">Solution</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control " id="solution" name="solution" aria-label="solution" aria-describedby="basic-addon1"placeholder="Pengerjaan yang diperlukan untuk mengatasi masalah/hasil analisis di atas.">
                                <?= form_error('solution', '<small class="text-danger pl-2">', '</small>') ?>
                            </div>
                            <label for="analysis" class="col-form-label">Results</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control " id="result" name="result" aria-label="result" aria-describedby="basic-addon1"placeholder="Tuliskan hasil dari pengerjaan. Apakah menyelesaikan masalah?">
                                <?= form_error('result', '<small class="text-danger pl-2">', '</small>') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- PIC -->
                            <label for="pic" class="col-form-label">PIC</label>
                            <select name="pic" id="pic" class="form-control" value="<?= set_value('pic') ?>">
                                <option value="">--Select User--</option>
                                <?php foreach ($user_data as $udat) : ?>
                                    <option value="<?= $udat['name'] ?>"><?= $udat['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('pic', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <label for="image" class="col-form-label">Images</label>
                            <div class="custom-file">
                                <!-- Image -->
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <!-- <input type="file" class="custom-file-input" multiple="multiple" id="image" name="image"> -->
                                <label class="custom-file-label" for="image">Choose file</label>
                                <small class="text-primary">Maximum 5 MB</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="card rounded shadow border-0 mb-3">
        <div class="card-body mb-0">
            <div class="row">
                <div class="col-lg-6">
                    <p class="text-dark mb-1">Name</p>
                    <p class="text-dark font-weight-bold"> <?= $inventory['name']; ?></p>
                    <p class="text-dark mb-1">Code</p>
                    <p class="text-dark font-weight-bold"> <?= $inventory['code']; ?></p>
                    <p class="text-dark mb-1">Date (YYYY-MM-DD) </p>
                    <p class="text-dark font-weight-bold"> <?= $inventory['date_in']; ?></p>
                    <p class="text-dark mb-1">Value</p>
                    <p class="text-dark font-weight-bold">IDR <?= number_format($inventory['value'], 2, ',', '.') ?></p>
                </div>
                <div class="col-lg-6">
                    <p class="text-dark mb-1">Spec</p>
                    <p class="text-dark font-weight-bold"> <?= $inventory['spec']; ?></p>
                    <p class="text-dark mb-1">Position</p>
                    <p class="text-dark font-weight-bold"> <?= $inventory['room_name']; ?></p>
                    <p class="text-dark mb-1">User</p>
                    <p class="text-dark font-weight-bold"> <?= $inventory['user']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- prod order table -->
    <div class="table-responsive my-3">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <div class="h5 text-dark">Maintenance data</div>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Analysis</th>
                    <th>PIC</th>
                    <th>Photos</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                ?>
                <?php foreach ($asset_maintenance as $am) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= date('d F Y H:i:s', $am['date']); ?></td>
                        <td><?= $am['analysis'] ?></td>
                        <td><?= $am['pic'] ?></td>
                        <td><img class="img-fluid rounded" src="<?= base_url('asset/img/maintenance/') . $am['photos'] ?>" alt="" style="width: 15rem;"></td>
                        <td>
                            <!-- <a data-toggle="modal" data-target="#editMaintenanceData" class="badge badge-warning text-white clickable" data-id="<?= $am['id'] ?>"><i class="bi bi-pencil-fill"> </i>Edit</a> -->
                            <a data-toggle="modal" data-target="#deleteMaintenanceData" data-id="<?= $am['id'] ?>" class="badge badge-danger clickable"><i class="bi bi-trash-fill"> </i>Delete</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal For Delete Data -->
<div class="modal fade" id="deleteMaintenanceData" tabindex="-1" aria-labelledby="deleteMaintenanceDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMaintenanceDataLabel">Delete Maintenance Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/delete_maintenance_data/') ?>" method="post">
                <div class="modal-body">
                    <p class="mb-0">Are you sure to delete this maintenance data? This action can't be undo.</p>
                    <div class="form-group" style="display:none">
                        <!-- Asset Name -->
                        <label for="url" class="col-form-label">Maintenance Data ID</label>
                        <input type="text" class="form-control mb-1" readonly id="delete_id" name="delete_id" placeholder="Item ID">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group" style="display:none">
                        <!-- Asset ID -->
                        <label for="url" class="col-form-label">Asset Data ID</label>
                        <input type="text" class="form-control mb-1" readonly id="asset_id" name="asset_id" value="<?= $inventory['id']; ?>">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
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
