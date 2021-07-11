<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-6 mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card border-left-info mb-3">
                <div class="card-body">
                    <form action="<?= base_url('user/changepassword') ?>" method="post">
                        <div class="form-group row">
                            <!-- password lama -->
                            <label for="current_password" class="col-sm-4 col-form-label">Old Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="current_password" name="current_password">
                                <?= form_error('current_password', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- password baru -->
                            <label for="new_password1" class="col-sm-4 col-form-label">New Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="new_password1" name="new_password1">
                                <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- password baru repeat -->
                            <label for="new_password2" class="col-sm-4 col-form-label">Repeat Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="new_password2" name="new_password2">
                                <?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-60">
                                    <i class="fas fa-fw fa-arrow-right"></i>
                                </span>
                                <span class="text">Change Password</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->