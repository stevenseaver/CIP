    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-lg-5 d-none d-lg-block">
                        <h3 class="font-weight-bold text-primary mx-5">User Registration</h3>
                        <p class="h5 mx-5">Support</p>
                        <a href="mailto:cs@plastikrukun.com" class="text-primary mx-5" target="_blank" rel="noopener noreferrer">
                            <span>cs@plastikrukun.com</span>
                        </a>
                        <!-- <img src="<?= base_url('asset/img/registration.png') ?>" class="img-fluid mx-auto d-block"> -->
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="post" action="<?= base_url('auth/registration'); ?>">
                                <!-- input nama -->
                                <div class="form-group">
                                    <label for="name" class="small ml-3">Full Name</label>
                                    <input type="text" class="form-control form-control-user mb-2" id="name" name="name" placeholder="Full Name" value="<?= set_value('name'); ?>">
                                    <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <!-- input email -->
                                <div class="form-group">
                                    <label for="email" class="small ml-3">E-mail</label>
                                    <input type="text" class="form-control form-control-user mb-2" id="email" name="email" placeholder="Email Address" value="<?= set_value('email'); ?>">
                                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                    <div class="form-check ml-3 mt-1">
                                        <input class="form-check-input" type="checkbox" id="username_email" name="username_email" onchange="getEmailAsUserId();" />
                                        <label class="small text-primary" for="username_email">Use as username</label>
                                    </div>
                                </div>
                                <hr>
                                <!-- Input NIK KTP -->
                                <div class="form-group">
                                    <label for="noktp" class="small ml-3">ID Card Number</label>
                                    <input type="text" class="form-control form-control-user mb-2" id="noktp" name="noktp" placeholder="ID Card Number" value="<?= set_value('noktp'); ?>">
                                    <?= form_error('noktp', '<small class="text-danger pl-3">', '</small>') ?>
                                    <small class="text-primary ml-3">Input your KTP/ID card number or passport number for foreigners.</small>
                                </div>
                                <!-- Input Tanggal Lahir -->
                                <div class="form-group">
                                    <label for="dob" class="small ml-3">Date of Birth</label>
                                    <input type="date" class="form-control form-control-user mb-2" id="dob" name="dob" placeholder="Date of Birth" value="<?= set_value('dob'); ?>">
                                    <?= form_error('dob', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <!-- input address 1 -->
                                <div class="form-group">
                                    <label for="address" class="small ml-3">Address</label>
                                    <input type="text" class="form-control form-control-user" id="address" name="address" placeholder="Street" value="<?= set_value('address'); ?>">
                                    <?= form_error('address', '<small class="text-danger pl-3 mb-1">', '</small>') ?>
                                </div>
                                <div class="form-group row mb-1">
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user mb-2" id="city" name="city" placeholder="City" value="<?= set_value('city'); ?>">
                                        <?= form_error('city', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <!-- state/province -->
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user mb-2" id="province" name="province" placeholder="Province or State" value="<?= set_value('province'); ?>">
                                        <?= form_error('province', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-8 mb-2">
                                        <input type="text" class="form-control form-control-user mb-2" id="country" name="country" placeholder="Country" value="<?= set_value('country'); ?>">
                                        <?= form_error('country', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <!-- zipcode -->
                                    <div class="col-sm-4 mb-2">
                                        <input type="text" class="form-control form-control-user mb-2" id="postal" name="postal" placeholder="Postal Code" value="<?= set_value('postal'); ?>">
                                        <?= form_error('postal', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <small class="text-primary ml-3">Will be used as shipping address. You can change this later.</small>
                                </div>
                                <!-- input no hp -->
                                <div class="form-group">
                                    <label for="hp" class="small ml-3">Phone Number</label>
                                    <input type="text" class="form-control form-control-user mb-2" id="hp" name="hp" placeholder="Mobile Phone Number (Optional)" value="<?= set_value('hp'); ?>">
                                    <?= form_error('hp', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <hr>
                                <!-- input NIK/ERN -->
                                <div class="form-group">
                                    <label for="hp" class="small ml-3">Username</label>
                                    <input type="text" class="form-control form-control-user mb-2" id="nik" name="nik" placeholder="Username" value="<?= set_value('nik'); ?>">
                                    <small class="text-primary ml-3">Will be used as login detail. You can also use your email or anything.</small>
                                    <?= form_error('nik', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <!-- password -->
                                <div class="form-group row mb-0">
                                    <div class="col-sm-6 mb-3">
                                        <label for="hp" class="small ml-3">Password</label>
                                        <input type="password" class="form-control form-control-user mb-2" id="password1" name="password1" placeholder="Password">
                                        <small class="text-primary ml-3">Min. 8 characters. </small>
                                    </div>
                                    <!-- repeat password -->
                                    <div class="col-sm-6">
                                        <label for="hp" class="small ml-3">Repeat Password</label>
                                        <input type="password" class="form-control form-control-user mb-2" id="password2" name="password2" placeholder="Repeat Password">
                                        <div class="form-check ml-3 mb-0">
                                            <input class="form-check-input" type="checkbox" id="show_pass" name="show_pass" onclick="visibilePassword()" />
                                            <label class="small" for="show_pass">Show password</label>
                                        </div>
                                        <?= form_error('password2', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                </div>
                                <div class="form-check ml-3 mb-3">
                                    <input class="form-check-input" type="checkbox" id="check_terms" name="check_terms" onchange="getEmailAsUserId();" />
                                    <label class="small" for="check_terms">I have read and agreed to the customer's<a href="<?= base_url('web/terms') ?>" rel="noopener noreferer" target="_blank"> terms and conditons</a> and <a href="<?= base_url('web/privacy_policy') ?>" rel="noopener noreferer" target="_blank"> privacy policy.</a> </label>
                                    <?= form_error('check_terms', '<small class="text-danger">', '</small>') ?>
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