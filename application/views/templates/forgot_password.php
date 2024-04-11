<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Forgot Password</title>
</head>
<body id="page-top">
    <i class="bi bi-key fa-3x mb-3 x-2 text-primary"></i>
    <h4 class="text-primary mb-2 font-weight-bold">Forgot your password?</h4>
    <p class="text-secondary mb-1">Don't worry, we know this would happen so we will help you.</p>
    <p class="text-secondary mb-1">Click this link below to reset your password. This link will self destruct in 5 minutes.</p>
    <!-- <a href="" class="btn btn-primary mt-3" target="_blank">Directions &rarr; </a> -->
    <a href="<?= base_url() . 'auth/resetpassword?email=' . $email . '&token=' . $token ?>" class="btn btn-primary mt-3">Reset Password</a>
</body>
</html>