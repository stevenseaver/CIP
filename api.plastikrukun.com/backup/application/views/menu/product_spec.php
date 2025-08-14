<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col">
            <?= form_error('edit_name', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('edit_id', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('edit_spec', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('edit_content', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>

            <a href="<?= base_url('menu/productmenu') ?>" class="btn btn-secondary btn-icon-split mb-3">
                <span class="icon text-white-50">
                    <i class="bi bi-arrow-left font-weight-bold"></i>
                </span>
                <span class="text">Back</span>
            </a>
            <a class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newProductSpecModal">
                <span class="icon text-white-50">
                    <i class="bi bi-plus-lg"></i>
                </span>
                <span class="text">Add Product Specification Details</span>
            </a>
            <div class="card shadow border-left-primary mb-4">
                <div class="card-header py-2">
                    <h5 class="m-0 font-weight-bold text-primary">Details</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Product Name</th>
                                    <th>Specification</th>
                                    <th>Items</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($productspec as $m) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td><?= $m['product_name']; ?></td>
                                        <td><?= $m['specification']; ?></td>
                                        <td><?= $m['items']; ?></td>
                                        <td>
                                            <a data-toggle="modal" data-target="#editSpecItem" class="badge badge-warning text-white clickable" data-id="<?= $m['id'] ?>" data-name="<?= $m['product_name'] ?>" data-spec="<?= $m['specification'] ?>" data-content='<?= $m['items'] ?>'><i class="bi bi-pencil-fill"> </i>Edit</a>
                                            <a data-toggle="modal" data-target="#deleteSpecItemModal" class="badge badge-danger text-white clickable" data-id="<?= $m['id'] ?>" data-name="<?= $m['product_name'] ?>" data-spec="<?= $m['specification'] ?>"><i class="bi bi-trash"> </i>Delete</a>
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
<div class="modal fade" id="newProductSpecModal" tabindex="-1" aria-labelledby="newProductSpecModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newProductSpecModalLabel">Add New Product Specificaion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/product_spec/') . $id; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <p class="text-secondary mb-1">Product Name</p>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Add new product menu name">
                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <p class="text-secondary mb-1">Product ID</p>
                        <input type="text" class="form-control" id="id" name="id" value="<?= $id ?>" readonly>
                        <?= form_error('id', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <p class="text-secondary mb-1">Specification Name</p>
                        <input type="text" class="form-control" id="specification" name="specification" placeholder="Add product specification name">
                        <?= form_error('specification', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <p class="text-secondary mb-1">Content</p>
                        <input type="text" class="form-control" id="content" name="content" placeholder="Add product specification content">
                        <?= form_error('content', '<small class="text-danger pl-3">', '</small>') ?>
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
<div class="modal fade" id="editSpecItem" tabindex="-1" aria-labelledby="editSpecItemLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSpecItemLabel">Edit Product Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/edit_spec/') . $id; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- menu id -->
                        <label for="deletemenu" class="col-form-label">Specification ID</label>
                        <input type="text" class="form-control" id="edit_id" name="edit_id" readonly>
                        <!-- product name -->
                        <label for="deletemenu" class="col-form-label">Product Name</label>
                        <input type="text" class="form-control" id="edit_name" name="edit_name">
                        <!-- spec name -->
                        <label for="deletemenu" class="col-form-label">Specification Name</label>
                        <input type="text" class="form-control" id="edit_spec" name="edit_spec">
                        <!-- spec content -->
                        <label for="deletemenu" class="col-form-label">Specification Content</label>
                        <input type="text" class="form-control" id="edit_content" name="edit_content">
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
<div class="modal fade" id="deleteSpecItemModal" tabindex="-1" role="dialog" aria-labelledby="deleteSpecItemLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSpecItemLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('menu/delete_spec/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- menu id -->
                        <label for="deletemenu" class="col-form-label">Specification ID</label>
                        <input type="text" class="form-control" id="delete_id" name="delete_id" readonly>
                        <!-- product name -->
                        <label for="deletemenu" class="col-form-label">Product Name</label>
                        <input type="text" class="form-control" id="delete_name" name="delete_name" readonly>
                        <!-- spec name -->
                        <label for="deletemenu" class="col-form-label">Specification Name</label>
                        <input type="text" class="form-control" id="delete_spec" name="delete_spec" readonly>
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