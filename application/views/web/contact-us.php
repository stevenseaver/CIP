<!-- Begin Page Content -->
<div class="container-fluid pt-5 mt-5">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-1 text-primary font-weight-bold"><?= $title ?></h1>
    </div>

    <div class="row mb-2">
        <div class="col">
            <div class="card shadow border-0 mb-3">
                <div class="card-body">
                    <div class="row py-2 justify-content-center">
                        <div class="col-lg py-3 mx-2 text-center">
                            <i class="bi bi-geo fa-3x mb-3 x-2 text-primary"></i>
                            <p class="text-primary mb-0">Pergudangan Sinar Gedangan A-20</p>
                            <p class="text-secondary mb-0">Gedangan, Sidoarjo</p>
                            <p class="text-secondary mb-0">East Java, Indonesia 61245</p>
                            <a href="https://goo.gl/maps/zRBAk5gr9dujTFc48" class="" target="_blank">Directions &rarr; </a>
                        </div>
                        <div class="col-lg py-3 mx-2 text-center">
                            <i class="bi bi-envelope fa-3x mb-3 text-primary"></i>
                            <p class="text-primary mb-0">cs.sbplastik@gmail.com</p>
                            <p class="text-secondary mb-0">Monday - Friday</p>
                            <p class="text-secondary mb-0">09.00 - 16.00 (WIB/GMT+7)</p>
                            <a href="mailto:cs.sbplastik@gmail.com" class="text-dark" target="_blank" rel="noopener noreferrer">
                                <p class="text-primary mb-0">E-mail us &rarr; </p>
                            </a>
                        </div>
                        <div class="col-lg py-3 mx-2 mb-1 text-center">
                            <i class="bi bi-instagram fa-3x mb-3" style="color: #962fbf"></i>
                            <p class="text-primary mb-0">@sbplastik</p>
                            <p class="text-dark mb-0">Chat on Instagram</p>
                            <p class="text-dark mb-0">09.00 - 16.00 (WIB/GMT+7)</p>
                            <a href="https://instagram.com/sbplastik" target="_blank" rel="noopener noreferer">Chat with us <i class="bi bi-instagram mr-1"></i> </a>
                        </div>
                        <div class="col-lg py-3 mx-2 text-center">
                            <i class="bi bi-whatsapp fa-3x mb-3 text-success"></i>
                            <p class="text-primary mb-0">+62 822-3205-7755</p>
                            <p class="text-secondary mb-0">Sales Representatives</p>
                            <p class="text-secondary mb-0">09.00 - 16.00 (WIB/GMT+7)</p>
                            <a href="https://wa.me/+6282232057755/?text=Halo,%20boleh%20minta%20informasi%20soal%20produk%20kresek%20anda?%20|%20Hello,%20can%20I%20have%20any%20information%20of%20your%20products?" target="_blank" rel="noopener noreferer" class="">Chat on WhatsApp! &rarr; </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow border-0 mb-3" class="align-items-center">
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
        <div class="col-lg-5">
            <div class="card shadow border-0 mb-3" class="align-items-center">
                <div class="card-body">
                    <h5 class="mx-0 mb-3 font-weight-bold text-primary">Do you need our help?</h5>
                    <p class="text-dark mb-2">Contact Our Customer Service</p>
                    <i class="bi bi-person-badge fa-3x"></i>
                    <p class="text-primary mt-2 mb-0">+62 813-3103-0398</p>
                    <p class="text-dark mb-0">Customer Service Officer</p>
                    <p class="text-secondary mb-0">Monday to Saturday from 09.00 - 15.30 (WIB/GMT+7)</p>
                    <a href="https://wa.me/+6281331030398/?text=Halo,%20boleh%20minta%20informasi%20layanan%20pelanggan%20untuk%20produk%20kresek%20anda?%20|%20Hello,%20can%20I%20have%20any%20customer%20services%20informations%20of%20your%20products?" target="_blank" rel="noopener noreferer" class="">Chat on WhatsApp! &rarr; </a>
                    <p class="mx-0 my-3 text-dark">Or if you need anything other than Customer Services, you can find full list of our department's contacts you'd like to contact <a href="<?= base_url('web/contactList') ?>" rel="noopener noreferer"> here.</a></p>
                    <p class="mx-0 my-3 text-dark">You may also obliged to read our <a href="<?= base_url('web/terms') ?>" rel="noopener noreferer"> terms and conditons</a> and also our <a href="<?= base_url('web/privacy_policy') ?>" rel="noopener noreferer"> privacy policy</a> before using our services.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->