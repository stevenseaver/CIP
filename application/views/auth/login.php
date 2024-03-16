<div class="container">
    <!-- Outer Row -->
    <div class="row d-flex justify-content-center my-5">
        <div class="col-xl-10 col-lg-12 col-md-9 my-5">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block">
                            <!-- <h1 class="text-center text-light font-weight-bold">Login</h1> -->
                            <img src="<?= base_url('asset/') ?>img/stock/undraw_authentication_fsn5.svg" alt="Responsive image" class="img-fluid mt-5 ml-4 mb-0 d-block">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Login Page</h1>
                                </div>
                                <?= $this->session->flashdata('message'); ?>
                                <form class="user" method="post" action="<?= base_url('auth') ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="nik" name="nik" placeholder="Username" value="<?= set_value('nik'); ?>">
                                        <?= form_error('nik', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user mb-2" id="password" name="password" placeholder="Password">
                                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                                        <div class="form-check ml-3 mb-3">
                                            <input class="form-check-input" type="checkbox" id="show_pass" name="show_pass" onclick="visibilePasswordLogin()" />
                                            <label class="small" for="show_pass">Show password</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                    <!-- <hr> -->
                                    <!-- <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a> -->
                                </form>
                                <hr>
                                <div class="text-center">
                                    <small>Don't have an account? <a href="<?= base_url('auth/registration') ?>">Create an Account! &rarr;</a></small>
                                </div>
                                <div class="text-center">
                                    <small>Forgot your password? <a href="<?= base_url('auth/forgotpassword') ?>">Forgot Password? &rarr;</a></small>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('web') ?>"> &larr; Back to Web Page</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>