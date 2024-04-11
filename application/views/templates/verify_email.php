<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Forgot Password</title>
</head>

<body id="page-top">
    <i class="bi bi-patch-check fa-3x mb-3 x-2 text-primary"></i>
    <h4 class="text-primary mb-2 font-weight-bold">Verify Your Email</h4>
    <p class="text-secondary mb-1">We're glad you join our extended family tree.</p>
    <p class="text-secondary mb-1">Click this link below to activate your account. This link will self destruct in one (1) day.</p>
    <a href="<?= base_url() . 'auth/verify?email=' . $email . '&token=' . $token ?>" class="btn btn-primary mt-3">Activate Account</a>
</body>
</html>