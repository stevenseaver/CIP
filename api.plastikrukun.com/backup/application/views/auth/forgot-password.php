<div class="container d-flex align-items-center">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block">
                            <img src="<?= base_url('asset/') ?>img/stock/undraw_forgot_password_gi2d.svg" alt="Responsive image" class="img-fluid mt-5 ml-4 mb-0 d-block">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-left">
                                    <h1 class="h4 text-gray-900 mb-2">Forgot your password?</h1>
                                    <p class="mb-4">We get it, stuff happens. Just enter your registered email address below
                                        and we'll send you a link to reset your password!</p>
                                </div>
                                <?= $this->session->flashdata('message'); ?>
                                <form class="user" method="post" action="<?= base_url('auth/forgotpassword') ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Enter your email" value="<?= set_value('email'); ?>">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Reset Password
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth') ?>"> &larr; Back to Login!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('web') ?>"> &larr; Back to Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>