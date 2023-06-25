<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="row text-dark">
        <div class="col-lg-3 mb-3">
            <div class="list-group list-group-flush" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active" id="list-general-list" data-toggle="list" href="#list-general" role="tab" aria-controls="general">General</a>
                <a class="list-group-item list-group-item-action" id="list-backup-list" data-toggle="list" href="#list-backup" role="tab" aria-controls="backup">Backup</a>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="list-general" role="tabpanel" aria-labelledby="list-general-list">
                    <div class="mb-3 h5">Sidebar Color</div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card border-left-primary mb-3">
                                <div class="card-body">
                                    <a class="btn" href="<?= base_url('admin/theme_color/primary') ?>"><i class="bi bi-circle-fill fa-2x text-primary"></i></a>
                                    <a class="btn" href="<?= base_url('admin/theme_color/dark') ?>"><i class="bi bi-circle-fill fa-2x text-dark"></i></a>
                                    <a class="btn" href="<?= base_url('admin/theme_color/secondary') ?>"><i class="bi bi-circle-fill fa-2x text-secondary"></i></a>
                                    <a class="btn" href="<?= base_url('admin/theme_color/light') ?>"><i class="bi bi-circle-fill fa-2x text-light"></i></a>
                                    <a class="btn" href="<?= base_url('admin/theme_color/danger') ?>"><i class="bi bi-circle-fill fa-2x text-danger"></i></a>
                                    <a class="btn" href="<?= base_url('admin/theme_color/warning') ?>"><i class="bi bi-circle-fill fa-2x text-warning"></i></a>
                                    <a class="btn" href="<?= base_url('admin/theme_color/success') ?>"><i class="bi bi-circle-fill fa-2x text-success"></i></a>
                                    <a class="btn" href="<?= base_url('admin/theme_color/info') ?>"><i class="bi bi-circle-fill fa-2x text-info"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="list-backup" role="tabpanel" aria-labelledby="list-backup-list">
                    <div class="mb-3 h5">Back up database</div>
                    <form action="<?= base_url('admin/download_database') ?>" method="post">
                        <!-- <button class="btn btn-outline-danger" type="submit" id="button-backup">Back Up</button> -->
                        <button type="submit" class="btn btn-outline-danger btn-icon-split">
                            <span class="icon text-white-60">
                                <i class="fas fa-fw fa-database text-white"></i>
                            </span>
                            <span class="text">Back up</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Menu</th>
                    <th scope="col">Access</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($settingItems as $m) : ?>
                    <tr>
                        <th scope="row"><?= $i ?></th>
                        <td><?= $m['parameter']; ?></td>
                        <td><?= $m['value']; ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> -->
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->