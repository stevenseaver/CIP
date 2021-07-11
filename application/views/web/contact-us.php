<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-primary font-weight-bold"><?= $title ?></h1>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow mb-3">
                <div class="card-body">
                    <!--Google map-->
                    <?php echo $map['html']; ?>
                    <!--Google Maps-->
                </div>
            </div>
        </div>
        <div class="col-lg-5 ml-0 pl-0">
            <div class="card shadow mb-3">
                <div class="card-body">
                    <form class="user" method="post" action="<?= base_url('auth/registration'); ?>">
                        <!-- input nama -->
                        <div class="form-group">
                            <!-- name -->
                            <label for="name" class="text-primary">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                            <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
                            <!-- address first row-->
                            <label for="address" class="text-primary mt-3">Address</label>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <input type="text" class="form-control mb-2" id="street" name="street" placeholder="Street">
                                    <?= form_error('street', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="col-lg-4 ml-0 pl-0">
                                    <input type="text" class="form-control mb-2" id="city" name="city" placeholder="City">
                                    <?= form_error('city', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <!-- address second row-->
                                    <input type="text" class="form-control" id="state" name="state" placeholder="Province/State">
                                    <?= form_error('state', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="col ml-0 pl-0">
                                    <!-- address third row-->
                                    <input type="text" class="form-control" id="country" name="country" placeholder="Country">
                                    <?= form_error('country', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="col ml-0 pl-0">
                                    <!-- address fourth row-->
                                    <input type="text" class="form-control" id="postal" name="postal" placeholder="Postal Code">
                                    <?= form_error('postal', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <!-- telp no -->
                            <label for="hp" class="text-primary mt-3">Phone Number</label>
                            <input type="text" class="form-control" id="hp" name="hp">
                            <?= form_error('hp', '<small class="text-danger pl-3">', '</small>') ?>
                            <!-- message -->
                            <label for="message" class="text-primary mt-3">Message</label>
                            <textarea type="text" class="form-control" id="message" name="message" rows="3"></textarea>
                            <?= form_error('message', '<small class="text-danger pl-3">', '</small>') ?>
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