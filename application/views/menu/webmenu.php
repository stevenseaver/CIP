<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col">
            <?= form_error('title', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('url', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('icon', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newMenuModal">
                <span class="icon text-white-50">
                    <i class="fas fa-fw fa-folder-plus"></i>
                </span>
                <span class="text">Add New Web Menu</span>
            </a>
            <div class="card shadow border-left-primary mb-4">
                <div class="card-header py-2">
                    <h5 class="m-0 font-weight-bold text-primary">Web Menu</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Menu</th>
                                    <th>URL</th>
                                    <th>Icon</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($webmenu as $m) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td><?= $m['title']; ?></td>
                                        <td><?= $m['url']; ?></td>
                                        <td><i class="<?= $m['icon']; ?> ?>"></i></td>
                                        <td>
                                            <?php if ($m['is_active']) {
                                                echo '<p class="badge badge-success">Active</p>';
                                            } else {
                                                echo '<p class="badge badge-danger">Not Active</p>';
                                            } ?>
                                        </td>
                                        <td>
                                            <a data-toggle="modal" data-target="#editWebMenuModal" class="badge badge-warning text-white clickable" data-id="<?= $m['id'] ?>" data-title="<?= $m['title'] ?>" data-url="<?= $m['url'] ?>" data-icon="<?= $m['icon'] ?>"><i class="bi bi-pencil-fill"> </i>Edit</a>
                                            <a href="<?= base_url('menu/toggleWebMenuActive/') . $m['id'] . '/' . $m['is_active'] . '/' . urldecode($m['title']) ?>" class="badge badge-primary clickable"><i class="bi bi-toggles"> </i>Toggle Active</a>
                                            <a data-toggle="modal" data-target="#deleteWebMenuModal" class="badge badge-danger text-white clickable" data-menu-id="<?= $m['id'] ?>" data-menu-name="<?= $m['title'] ?>"><i class="bi bi-pencil-fill"> </i>Delete</a>
                                        </td>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                        <small class="text-primary pb-1">*)Web menu controls the menu page in main website. </small>
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
            <form action="<?= base_url('menu/webmenu') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <p class="text-secondary mb-0">Web Menu Title</p>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Add new web menu title">
                        <?= form_error('title', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <p class="text-secondary mb-0">Web Menu URL</p>
                        <input type="text" class="form-control" id="url" name="url" placeholder="Add web menu URL">
                        <?= form_error('url', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <p class="text-secondary mb-0">Web Menu Icon</p>
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Add web menu icon">
                        <?= form_error('icon', '<small class="text-danger pl-3">', '</small>') ?>
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

<!-- Edit Webmenu Modal -->
<div class="modal fade" id="editWebMenuModal" tabindex="-1" aria-labelledby="editWebMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWebMenuModalLabel">Edit Web Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/editwebmenu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- webmenu id -->
                        <label for="id" class="col-form-label">ID</label>
                        <input type="text" class="form-control" id="id" name="id" readonly>
                        <?= form_error('id', '<small class="text-danger">', '</small><br>') ?>
                        <!-- title -->
                        <label for="title" class="col-form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                        <?= form_error('title', '<small class="text-danger">', '</small><br>') ?>
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

<!-- Modal For Delete Data -->
<div class="modal fade" id="deleteWebMenuModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('menu/delete_webmenu/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- menu id -->
                        <label for="deletemenu" class="col-form-label">Menu ID</label>
                        <input type="text" class="form-control" id="delete_webmenu_id" name="delete_webmenu_id" readonly>
                        <!-- webmenu name -->
                        <label for="deletemenu" class="col-form-label">Webmenu Name</label>
                        <input type="text" class="form-control" id="delete_webmenu_name" name="delete_webmenu_name" readonly>
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