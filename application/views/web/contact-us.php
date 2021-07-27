<!-- Begin Page Content -->
<div class="container-fluid pt-4 mt-5">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-1 text-primary font-weight-bold"><?= $title ?></h1>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="row py-3 justify-content-center">
                        <div class="col py-3 text-center">
                            <i class="bi bi-geo fa-3x mb-3"></i>
                            <p class="text-primary mb-0">Pergudangan dan Industri Sinar Gedangan A-20</p>
                            <p class="text-secondary mb-0">Gedangan, Sidoarjo</p>
                            <p class="text-secondary mb-0">East Java, Indonesia 61245</p>
                            <a href="https://goo.gl/maps/zRBAk5gr9dujTFc48" class="" target="_blank">Directions &rarr; </a>
                        </div>
                        <div class="col-lg-5 py-3 px-0 text-center">
                            <i class="bi bi-telephone fa-3x mb-3"></i>
                            <p class="text-primary mb-0">+6231-701-1529</p>
                            <p class="text-secondary mb-0">Monday - Friday</p>
                            <p class="text-secondary mb-0">08.00 - 16.00 (WIB/GMT+7)</p>
                        </div>
                    </div>
                    <div class="row py-3 justify-content-center">
                        <div class="col py-3 px-2 text-center">
                            <i class="bi bi-envelope fa-3x mb-3"></i>
                            <p class="text-primary mb-0">cs.sbplastik@gmail.com</p>
                            <p class="text-secondary mb-0">Monday - Friday</p>
                            <p class="text-secondary mb-0">08.00 - 16.00 (WIB/GMT+7)</p>
                        </div>
                        <div class="col-lg-5 py-3 px-3 text-center">
                            <i class="bi bi-whatsapp fa-3x mb-3"></i>
                            <p class="text-primary mb-0">+62822-3205-7755</p>
                            <p class="text-secondary mb-0">Steven</p>
                            <a href="https://wa.me/+6282232057755/?text=Halo,%20ada%20informasi%20soal%20produk%20kresek%20anda?" class="text-primary mb-0">Chat on WhatsApp! &rarr; </a>
                        </div>
                    </div>
                    <div class="row justify-content-center">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <h5 class="mx-0 mb-3 font-weight-bold text-primary">Or, you can just drop your inquiries here!</h5>
                    <?= $this->session->flashdata('message'); ?>
                    <form class="user" method="post" action="<?= base_url('contact/add_message'); ?>">
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
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-60">
                                    <i class="fas fa-fw fa-arrow-right"></i>
                                </span>
                                <span class="text">Submit</span>
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