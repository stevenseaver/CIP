<!-- Begin Page Content -->
<div class="container-fluid pt-5 mt-5">
    <div class="row justify-content-center align-items-center text-center pt-1">
        <!-- Page Heading -->
        <div class="col-lg-12 mx-3 mb-3">
            <i class="bi bi-telephone fa-3x"></i>
            <h2 class="h3 mb-0 text-primary font-weight-bold"><?= $title ?></h1>
        </div>
    </div>
    <div class="row">

        <div class="col-lg">
            <div class="card shadow border-0 mb-3" class="align-items-center">
                <div class="card-body">
                    <h5 class="mx-0 mb-3 font-weight-bold text-primary">If you need our after sales service, feel free to contact us here!</h5>
                    <?= $this->session->flashdata('message'); ?>
                    <form class="user" method="post" action="<?= base_url('web/validate'); ?>">
                        <!-- input nama -->
                        <div class="form-group">
                            <div class="row mx-0">
                                <!-- invoice number -->
                                <label for="invoice" class="text-primary">Invoice Number</label>
                                <!-- <input type="text" class="form-control" id="invoice" name="invoice" placeholder="Input your 7 digit invoice number here"> -->
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">INV-</span>
                                    </div>
                                    <input type="text"class="form-control" id="invoice" name="invoice" value="<?= set_value('invoice'); ?>" placeholder="123456-1234">
                                </div>
                                <?= form_error('invoice', '<small class="text-danger mt-2 ml-2">', '</small>') ?>
                            </div>
                            <div class="row mx-0">
                                <!-- email-->
                                <label for="email" class="text-primary mt-3">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Your email here, so we can contact you">
                                <?= form_error('email', '<small class="text-danger mt-2 ml-2">', '</small>') ?>
                            </div>
                            <div class="row mx-0">
                                <!-- email-->
                                <label for="phone" class="text-primary mt-3">Phone Number</label>
                                <input type="phone" class="form-control" id="phone" name="phone" placeholder="Your phone number here, so we can contact you">
                                <?= form_error('phone', '<small class="text-danger mt-2 ml-2">', '</small>') ?>
                                <small class="text-dark mt-2 ml-2">Use your country code, i.e. +62!</small>
                            </div>
                            <!-- <div class="row mx-0">
                                <label for="email" class="text-primary mt-3">Type</label>
                                <select name="" id="">
                                    <option type="email" class="form-control" id="email" name="email">
                                </select>
                                <?= form_error('email', '<small class="text-danger mt-2 ml-2">', '</small>') ?>
                            </div> -->
                            <div class="row mx-0 mb-3">
                                <!-- message -->
                                <label for="message" class="text-primary mt-3">Tell us what happened?</label>
                                <textarea type="text" class="form-control" id="message" name="message" rows="3" placeholder="Tell us about your problem, and we will do our best to help you!"></textarea>
                                <?= form_error('message', '<small class="text-danger mt-2 ml-2">', '</small>') ?>
                            </div>
                        </div>
                        <form action="?" method="POST">
                            <div class="g-recaptcha" data-sitekey="6LfDc9ciAAAAAOvs9TRP8ISo26wwrdQkg3Ln1ih7"></div>
                            <button type="submit" class="btn btn-primary btn-icon-split mt-3">
                                <span class="icon text-white-60">
                                    <i class="fas fa-fw fa-arrow-right"></i>
                                </span>
                                <span class="text">Submit</span>
                            </button>
                        </form>
                        </body>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->