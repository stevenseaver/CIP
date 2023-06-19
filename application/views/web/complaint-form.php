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
                    <h5 class="mx-0 mb-3 font-weight-bold text-primary">Or, you can just drop your inquiries here!</h5>
                    <?= $this->session->flashdata('message'); ?>
                    <form class="user" method="post" action="<?= base_url('contact/validate'); ?>">
                        <!-- input nama -->
                        <div class="form-group">
                            <div class="row mx-0">
                                <!-- name -->
                                <label for="name" class="text-primary">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Hello there, what's your name?">
                                <?= form_error('name', '<small class="text-danger mt-2 ml-2">', '</small>') ?>
                            </div>
                            <div class="row mx-0">
                                <!-- email-->
                                <label for="email" class="text-primary mt-3">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Your email here.">
                                <?= form_error('email', '<small class="text-danger mt-2 ml-2">', '</small>') ?>
                            </div>
                            <div class="row mx-0 mb-3">
                                <!-- message -->
                                <label for="message" class="text-primary mt-3">Message</label>
                                <textarea type="text" class="form-control" id="message" name="message" rows="3" placeholder="Sends us your question, feedback, anything goes here!"></textarea>
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