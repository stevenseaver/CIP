<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-6 mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="card border-left-primary mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4 pl-3 align-self-center">
                <img src="<?= base_url('asset/img/Profile/') . $user['image'] ?>" class="card-img">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title mb-2 font-weight-bold"><?= $user['name']; ?></h5>
                    <p class="card-text mb-1"><?= $user['nik']; ?></p>
                    <p class="card-text mb-1"><?= $user['email']; ?></p>
                    <p class="card-text mb-3"><?= $user['phone_number']; ?></p>
                    <p class="card-text"><small class="text-muted">Member since <?= date('d F Y', $user['date_created']); ?></small></p>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->