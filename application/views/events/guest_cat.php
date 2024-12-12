<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col">
            <?= form_error('title', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('url', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('icon', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('guest_cat_msg'); ?>

            <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newProductMenuModal">
                <span class="icon text-white-50">
                    <i class="fas fa-fw fa-folder-plus"></i>
                </span>
                <span class="text">Add New Guest Category</span>
            </a>
            <div class="card shadow border-left-primary mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Guest Category</th>
                                    <th>Table/Seating</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($prod_cat as $m) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td><?= $m['title']; ?></td>
                                        <td><?= $m['seating']; ?></td>
                                        <td>
                                            <a data-toggle="modal" data-target="#editGuestCategory" class="badge badge-primary text-white clickable" data-id="<?= $m['id']; ?>" data-title="<?= $m['title']; ?>" data-seating="<?= $m['seating']; ?>">Edit</a>
                                            <a data-toggle="modal" data-target="#deleteGuestCategory" class="badge badge-danger text-white clickable" data-cat-id="<?= $m['id'] ?>" data-cat-name="<?= $m['title']; ?>">Delete</a>
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
            <form action="<?= base_url('events/guest_category') ?>" method="post">
                <div class="modal-body">
                    <!-- Event ID -->
                    <div class="form-group">
                        <p class="text-secondary mb-1">Event ID</p>
                        <input readonly type="text" class="form-control" id="event_id" name="event_id" value="<?= $user['event_id']; ?> ">
                        <?= form_error('event_id', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- Guest CATegory -->
                    <div class="form-group">
                        <p class="text-secondary mb-1">Guest Category</p>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Add new product menu title">
                        <?= form_error('title', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <!-- Guest's seating nomemclature -->
                    <div class="form-group">
                        <p class="text-secondary mb-1">Guest Seating Nomenclature</p>
                        <input type="text" class="form-control" id="seating" name="seating" placeholder="Product unit of measurement">
                        <?= form_error('seating', '<small class="text-danger pl-3">', '</small>') ?>
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
<div class="modal fade" id="editGuestCategory" tabindex="-1" aria-labelledby="editGuestCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGuestCategoryLabel">Edit Product Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('events/edit_guest_category'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- webmenu id -->
                        <label for="id" class="col-form-label">ID</label>
                        <input type="text" class="form-control" id="id" name="id" readonly>
                        <?= form_error('id', '<small class="text-danger">', '</small><br>') ?>
                        <!-- title -->
                        <label for="title" class="col-form-label">Guest Category</label>
                        <input type="text" class="form-control" id="title" name="title">
                        <?= form_error('title', '<small class="text-danger">', '</small><br>') ?>
                        <!-- title -->
                        <label for="seating" class="col-form-label">Guest Seating Nomenclature</label>
                        <input type="text" class="form-control" id="seating" name="seating">
                        <?= form_error('seating', '<small class="text-danger">', '</small><br>') ?>
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
<div class="modal fade" id="deleteGuestCategory" tabindex="-1" role="dialog" aria-labelledby="deleteGuestCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteGuestCategoryLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('events/delete_productmenu/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- menu id -->
                        <label for="deletemenu" class="col-form-label">ID</label>
                        <input type="text" class="form-control" id="delete_cat_id" name="delete_cat_id" readonly>
                        <!-- productmenu name -->
                        <label for="deletemenu" class="col-form-label">Product Category Name</label>
                        <input type="text" class="form-control" id="delete_cat_name" name="delete_cat_name" readonly>
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