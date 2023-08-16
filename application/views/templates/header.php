<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="IT Department | Steven Seaver W.">
    <!-- <meta name="theme-color" content="#4e73df"> -->

    <title><?= $title ?></title>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- Bootstrap CSS -->
    <link href="<?= base_url('asset/'); ?>css/bootstrap.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Icon -->
    <!-- <link href="<?= base_url('asset/'); ?>css/bootstrap-icons.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('asset/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('asset/'); ?>css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom styles for user management page -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.25/r-2.2.9/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.25/r-2.2.9/datatables.min.js"></script>

    <!-- TinyMCE -->
    <script src="https://<hostname.tld>/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.tiny.cloud/1/spjzi5r4tv6d6aexi69v08fedua8qe2o847tew6pxzipwlbe/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#blog_content',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>

    <style>
        text-pink {
            color: #FF33B8;
        }

        text-orange {
            color: #FF8333;
        }

        @media all and (max-width: 2880px) {
            .desktop {
                display: block;
            }

            .mobile {
                display: none;
            }
        }

        @media all and (max-width: 991px) {
            .desktop {
                display: none;
            }

            .mobile {
                display: block;
            }
        }

        .clickable {
            cursor: pointer;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">