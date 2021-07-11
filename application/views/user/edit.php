<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-left-primary mb-3">
                <div class="card-body">
                    <?= form_open_multipart('user/edit'); ?>
                    <div class="form-group row">
                        <!-- edit name -->
                        <label for="fullname" class="col-sm-3 col-form-label">Full Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>">
                            <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- edit email -->
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="email" name="email" value="<?= $user['email']; ?>">
                            <?= form_error('email', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- edit phone number -->
                        <label for="hp" class="col-sm-3 col-form-label">Mobile Phone</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="hp" name="hp" value="<?= $user['phone_number']; ?>">
                            <?= form_error('hp', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- edit ERN -->
                        <label for="nik" class="col-sm-3 col-form-label">ERN</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nik" name="nik" value="<?= $user['nik']; ?>" readonly>
                            <?= form_error('nik', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- edit address -->
                        <label for="address" class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="address" name="address" value="<?= $user['address']; ?>">
                            <?= form_error('address', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- edit profile picture -->
                        <div class="col-sm-3">Picture</div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src="<?= base_url('asset/img/Profile/') . $user['image'] ?>" class="img-thumbnail">
                                </div>
                                <div class="col-sm-9">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                        <small class="text-primary">Maximum 2 MB</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-fw fa-user-edit"></i>
                                </span>
                                <span class="text">Edit Profile</span></button>
                        </div>
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