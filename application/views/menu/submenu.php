<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-lg">
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newSubMenuModal">
                <span class="icon text-white-50">
                    <i class="fas fa-fw fa-folder-plus"></i>
                </span>
                <span class="text">Add New Submenu</span>
            </a>
            <div class="card shadow border-left-primary mb-4">
                <div class="card-header py-2">
                    <h5 class="m-0 font-weight-bold text-primary">Submenu</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Sub Menu</th>
                                    <th>Menu</th>
                                    <th>Url</th>
                                    <th>Icon</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($subMenu as $sm) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td><?= $sm['title']; ?></td>
                                        <td><?= $sm['menu']; ?></td>
                                        <td><?= $sm['url']; ?></td>
                                        <td><?= $sm['icon']; ?></td>
                                        <td>
                                            <?php if ($sm['is_active']) {
                                                echo '<p class="badge badge-success">Active</p>';
                                            } else {
                                                echo '<p class="badge badge-danger">Not Active</p>';
                                            } ?>
                                        </td>
                                        <td>
                                            <a data-toggle="modal" data-target="#editsubmenumodal" class="badge badge-primary text-white clickable" data-sub_id="<?= $sm['id'] ?>" data-title="<?= $sm['title'] ?>" data-menu_id="<?= $sm['menu_id'] ?>" data-url="<?= $sm['url'] ?>" data-icon="<?= $sm['icon'] ?>">Edit</a>
                                            <a href="<?= base_url('menu/toggleactive/') . $sm['id'] . '/' . $sm['is_active'] . '/' . urldecode($sm['title']) ?>" class="badge badge-success clickable">Toggle Active</a>
                                            <a data-toggle="modal" data-target="#deleteSubMenuModal" class="badge badge-danger text-white clickable" data-sub_id="<?= $sm['id'] ?>" data-title="<?= $sm['title'] ?>" data-menu_id="<?= $sm['menu_id'] ?>" data-url="<?= $sm['url'] ?>" data-icon="<?= $sm['icon'] ?>">Delete</a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <small class="text-primary pb-1">*) Submenu icon using fontawesome &copy; </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
</div>
<!-- End of Main Content -->

<!-- Add New Submenu Modal -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Add New Submenu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/submenu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title">
                        <?= form_error('title', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class="form-control">
                            <option value="">--Select Menu--</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                                <?= form_error('menu_id', '<small class="text-danger pl-3">', '</small>') ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="url" name="url" placeholder="Submenu url">
                        <?= form_error('url', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon">
                        <?= form_error('icon', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" checked>
                            <label class="form-check-label" for="is_active">
                                Active?
                            </label>
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

<!-- Edit Submenu Modal -->
<div class="modal fade" id="editsubmenumodal" tabindex="-1" aria-labelledby="editsubmenumodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Edit Submenu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/editsubmenu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- submenu id -->
                        <label for="sub_id" class="col-form-label">ID</label>
                        <input type="text" class="form-control" id="sub_id" name="sub_id" readonly>
                        <?= form_error('sub_id', '<small class="text-danger">', '</small><br>') ?>
                        <!-- title -->
                        <label for="title" class="col-form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                        <?= form_error('title', '<small class="text-danger">', '</small><br>') ?>
                        <!-- parent menu -->
                        <label for="menu_id" class="col-form-label">Parent Menu</label>
                        <select name="menu_id" id="menu_id" class="form-control">
                            <option value="">--Select Menu--</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                                <?= form_error('menu_id', '<small class="text-danger">', '</small><br>') ?>
                            <?php endforeach; ?>
                        </select>
                        <!-- url -->
                        <label for="url" class="col-form-label">URL</label>
                        <input type="text" class="form-control" id="url" name="url">
                        <?= form_error('url', '<small class="text-danger">', '</small><br>') ?>
                        <!-- icon -->
                        <label for="icon" class="col-form-label">Icon</label>
                        <input type="text" class="form-control" id="icon" name="icon">
                        <?= form_error('icon', '<small class="text-danger">', '</small><br>') ?>
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

<!-- Delete Submenu Modal -->
<div class="modal fade" id="deleteSubMenuModal" tabindex="-1" aria-labelledby="deleteSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('menu/deletesubmenu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- submenu id -->
                        <label for="sub_id" class="col-form-label">ID</label>
                        <input type="text" class="form-control" id="sub_id" name="sub_id" readonly>
                        <?= form_error('sub_id', '<small class="text-danger">', '</small><br>') ?>
                        <!-- title -->
                        <label for="title" class="col-form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                        <?= form_error('title', '<small class="text-danger">', '</small><br>') ?>
                        <!-- parent menu -->
                        <label for="menu_id" class="col-form-label">Parent Menu</label>
                        <select name="menu_id" id="menu_id" class="form-control">
                            <option value="">--Select Menu--</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                                <?= form_error('menu_id', '<small class="text-danger">', '</small><br>') ?>
                            <?php endforeach; ?>
                        </select>
                        <!-- url -->
                        <label for="url" class="col-form-label">URL</label>
                        <input type="text" class="form-control" id="url" name="url">
                        <?= form_error('url', '<small class="text-danger">', '</small><br>') ?>
                        <!-- icon -->
                        <label for="icon" class="col-form-label">Icon</label>
                        <input type="text" class="form-control" id="icon" name="icon">
                        <?= form_error('icon', '<small class="text-danger">', '</small><br>') ?>
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