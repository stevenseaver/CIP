    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-lg-5 d-none d-lg-block">
                        <img src="<?= base_url('asset/') ?>img/undraw_Account_re_o7id.svg" class="img-fluid mx-3 d-block mt-5">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="post" action="<?= base_url('auth/registration'); ?>">
                                <!-- input nama -->
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Full Name" value="<?= set_value('name'); ?>">
                                    <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <!-- input email -->
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user mb-2" id="email" name="email" placeholder="Email Address" value="<?= set_value('email'); ?>">
                                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" id="username_email" name="username_email" onchange="aaa();" />
                                        <label class="small" for="username_email">Use as username</label>
                                    </div>
                                </div>
                                <hr>
                                <!-- input address -->
                                <div class="form-group row">
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-user" id="address" name="address" placeholder="Address" value="<?= set_value('address'); ?>">
                                        <?= form_error('address', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <div class="col-sm-4 pl-0">
                                        <input type="text" class="form-control form-control-user" id="city" name="city" placeholder="City" value="<?= set_value('city'); ?>">
                                        <?= form_error('city', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-user" id="province" name="province" placeholder="Province" value="<?= set_value('province'); ?>">
                                        <?= form_error('province', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <div class="col-sm-4 pl-0">
                                        <input type="text" class="form-control form-control-user" id="country" name="country" placeholder="Country" value="<?= set_value('country'); ?>">
                                        <?= form_error('country', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <div class="col-sm-4 pl-0">
                                        <input type="text" class="form-control form-control-user" id="zipcode" name="zipcode" placeholder="Zipcode" value="<?= set_value("zipcode"); ?>">
                                        <?= form_error('zipcode', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                </div>
                                <!-- input no hp -->
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="hp" name="hp" placeholder="Mobile Phone Number" value="<?= set_value('hp'); ?>">
                                    <?= form_error('hp', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <hr>
                                <!-- input NIK/ERN -->
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="nik" name="nik" placeholder="Username" value="<?= set_value('nik'); ?>">
                                    <small class="text-primary ml-3">Will be used as login detail.</small>
                                    <?= form_error('nik', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <!-- password -->
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password">
                                        <small class="text-primary ml-3">Min. 8 characters.</small>
                                    </div>
                                    <!-- repeat password -->
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Repeat Password">
                                        <?= form_error('password1', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                                <!-- <hr>
                                <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a> -->
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?= base_url('auth/forgotpassword') ?>">Forgot Password? &rarr;</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="<?= base_url('auth'); ?>">Already have an account? Login! &rarr;</a>
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