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

            <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newProductMenuModal">
                <span class="icon text-white-50">
                    <i class="fas fa-fw fa-folder-plus"></i>
                </span>
                <span class="text">Add New Product Menu</span>
            </a>
            <div class="card shadow border-left-primary mb-4">
                <div class="card-header py-2">
                    <h5 class="m-0 font-weight-bold text-primary">Product Menu</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Title</th>
                                    <th>URL</th>
                                    <th>Icon</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($productmenu as $m) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td><?= $m['title']; ?></td>
                                        <td><?= $m['url']; ?></td>
                                        <td><?= $m['image']; ?></td>
                                        <td>
                                            <a href="<?= base_url('menu/product_spec/') . $m['id'] ?>" class="badge badge-info text-white clickable">Details</a>
                                            <a data-toggle="modal" data-target="#editProductMenu" class="badge badge-primary text-white clickable" data-id="<?= $m['id'] ?>" data-title="<?= $m['title'] ?>" data-url="<?= $m['url'] ?>" data-icon="<?= $m['image'] ?>">Edit</a>
                                            <a data-toggle="modal" data-target="#deleteProductMenuModal" class="badge badge-danger text-white clickable" data-menu-id="<?= $m['id'] ?>" data-menu-name="<?= $m['title'] ?>">Delete</a>
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
<div class="modal fade" id="newProductMenuModal" tabindex="-1" aria-labelledby="newProductMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newProductMenuModalLabel">Add New Product Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/productmenu') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <p class="text-secondary mb-1">Product Menu Title</p>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Add new product menu title">
                        <?= form_error('title', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <p class="text-secondary mb-1">Product Menu URL</p>
                        <input type="text" class="form-control" id="url" name="url" placeholder="Add product menu URL">
                        <?= form_error('url', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <p class="text-secondary mb-1">Product Menu Icon</p>
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Add product menu icon">
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
<div class="modal fade" id="editProductMenu" tabindex="-1" aria-labelledby="editProductMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductMenuLabel">Edit Product Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/editproductmenu'); ?>" method="post">
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
<div class="modal fade" id="deleteProductMenuModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('menu/delete_productmenu/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- menu id -->
                        <label for="deletemenu" class="col-form-label">Menu ID</label>
                        <input type="text" class="form-control" id="delete_productmenu_id" name="delete_productmenu_id" readonly>
                        <!-- productmenu name -->
                        <label for="deletemenu" class="col-form-label">Product Menu Name</label>
                        <input type="text" class="form-control" id="delete_productmenu_name" name="delete_productmenu_name" readonly>
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