<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('asset/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('asset/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('asset/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('asset/'); ?>js/sb-admin-2.min.js"></script>
<script>
    //email as username
    function getEmailAsUserId() {
        var checkBox = document.getElementById("username_email");
        var email = document.getElementById("email");
        var nik = document.getElementById("nik");

        if (checkBox.checked == true) {
            nik.value = email.value;
        } else {
            nik.value = "";
        }
    }

    function visibilePasswordLogin() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function visibilePassword() {
        var x = document.getElementById("password1");
        var y = document.getElementById("password2");
        if (x.type === "password" & y.type === "password") {
            x.type = "text";
            y.type = "text";
        } else {
            x.type = "password";
            y.type = "password";
        }
    }
</script>
</body>

</html>