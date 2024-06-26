<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('edit_menu_id', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('edit_menu_name', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newMenuModal">
                <span class="icon text-white-50">
                    <i class="fas fa-fw fa-folder-plus"></i>
                </span>
                <span class="text">Add New Menu</span>
            </a>
            <div class="card shadow border-left-primary mb-4">
                <div class="card-header py-2">
                    <h5 class="m-0 font-weight-bold text-primary">Menu</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Menu</th>
                                    <th>Icon</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($menu as $m) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td><?= $m['menu']; ?></td>
                                        <td><i class="<?= $m['menu_icon']; ?> ?>"></i></td>
                                        <td>
                                            <a data-toggle="modal" data-target="#editmenumodal" class="badge badge-warning text-white clickable" data-menu-id="<?= $m['id'] ?>" data-menu-name="<?= $m['menu'] ?>" data-menu-icon="<?= $m['menu_icon']?>"><i class="bi bi-pencil-fill"> </i>Edit</a>
                                            <a data-toggle="modal" data-target="#deletemenumodal" class="badge badge-danger text-white clickable" data-menu-id="<?= $m['id'] ?>" data-menu-name="<?= $m['menu'] ?>"><i class="bi bi-trash"> </i>Delete</a>
                                        </td>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                        <small class="text-primary pb-1">*) Menu is divided by user role types. </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>
</div>
<!-- End of Main Content -->

<!-- Modal For Add Data -->
<div class="modal fade" id="newMenuModal" tabindex="-1" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Add New Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="menu" name="menu" placeholder="Add new menu">
                        <?= form_error('menu', '<small class="text-danger pl-3">', '</small>') ?>
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
<div class="modal fade" id="editmenumodal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/editmenu') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- menu id -->
                        <label for="editmenu" class="col-form-label">Menu ID</label>
                        <input type="text" class="form-control" id="edit_menu_id" name="edit_menu_id" readonly>
                        <?= form_error('edit_menu_id', '<small class="text-danger">', '</small><br>') ?>
                        <!-- menu name -->
                        <label for="editmenu" class="col-form-label">Edit Menu Name</label>
                        <input type="text" class="form-control" id="edit_menu_name" name="edit_menu_name">
                        <?= form_error('edit_menu_name', '<small class="text-danger">', '</small><br>') ?>
                        <!-- menu name -->
                        <label for="editmenu" class="col-form-label">Edit Menu Icon</label>
                        <input type="text" class="form-control" id="edit_menu_icon" name="edit_menu_icon">
                        <?= form_error('edit_menu_icon', '<small class="text-danger">', '</small><br>') ?>
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
<div class="modal fade" id="deletemenumodal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('menu/deletemenu/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- menu id -->
                        <label for="deletemenu" class="col-form-label">Menu ID</label>
                        <input type="text" class="form-control" id="delete_menu_id" name="delete_menu_id" readonly>
                        <!-- menu name -->
                        <label for="deletemenu" class="col-form-label">Menu Name</label>
                        <input type="text" class="form-control" id="delete_menu_name" name="delete_menu_name" readonly>
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