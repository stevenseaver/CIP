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

            <a href="<?= base_url('inventory/material_wh') ?>" class="btn btn-light btn-icon-split mb-3">
                <span class=" icon text-white-50">
                    <i class="bi bi-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
            <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newProductMenuModal">
                <span class="icon text-white-50">
                    <i class="fas fa-fw fa-folder-plus"></i>
                </span>
                <span class="text">Add New Material Category</span>
            </a>
            <div class="card shadow border-left-primary mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Title</th>
                                    <th>Unit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($prod_cat as $m) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td><?= $m['categories_name']; ?></td>
                                        <td><?= $m['unit']; ?></td>
                                        <td>
                                            <a data-toggle="modal" data-target="#editMaterialCat" class="badge badge-primary text-white clickable" data-id="<?= $m['id'] ?>" data-title="<?= $m['categories_name'] ?>" data-unit="<?= $m['unit'] ?>">Edit</a>
                                            <a data-toggle="modal" data-target="#deleteMaterialCat" class="badge badge-danger text-white clickable" data-menu-id="<?= $m['id'] ?>" data-menu-name="<?= $m['categories_name'] ?>">Delete</a>
                                        </td>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
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
            <form action="<?= base_url('inventory/material_category') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <p class="text-secondary mb-1">Product Category Title</p>
                        <input type="text" class="form-control" id="title" name="title" placeholder="New material category title">
                        <?= form_error('title', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <p class="text-secondary mb-1">Product Unit of Measurement</p>
                        <input type="text" class="form-control" id="unit" name="unit" placeholder="Category's unit of measurement">
                        <?= form_error('unit', '<small class="text-danger pl-3">', '</small>') ?>
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
<div class="modal fade" id="editMaterialCat" tabindex="-1" aria-labelledby="editMaterialCatLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMaterialCatLabel">Edit Product Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inventory/edit_materialcategory'); ?>" method="post">
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
                        <!-- title -->
                        <label for="unit" class="col-form-label">Unit of Measurement</label>
                        <input type="text" class="form-control" id="unit" name="unit">
                        <?= form_error('unit', '<small class="text-danger">', '</small><br>') ?>
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
<div class="modal fade" id="deleteMaterialCat" tabindex="-1" role="dialog" aria-labelledby="deleteMaterialCat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMaterialCat">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('inventory/delete_materialcategory/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- menu id -->
                        <label for="deletemenu" class="col-form-label">ID</label>
                        <input type="text" class="form-control" id="delete_productmenu_id" name="delete_productmenu_id" readonly>
                        <!-- productmenu name -->
                        <label for="deletemenu" class="col-form-label">Product Category Name</label>
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