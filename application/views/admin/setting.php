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
                    <div class="mb-2 h5">Sidebar Color</div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card border-left-primary mb-4">
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
                    <?php 
                        $data['purchase_tax'] = $this->db->get_where('settings', ['parameter' => 'purchase_tax'])->row_array();
                        $data['sales_tax'] = $this->db->get_where('settings', ['parameter' => 'sales_tax'])->row_array();
                        $purchase_tax = $data['purchase_tax']['value'];
                        $sales_tax = $data['sales_tax']['value']
                    ?>
                    <label class="mb-2 h5">Purchase Tax</label>
                    <form action="<?= base_url('admin/update_purchase_tax/') ?>" method="post">
                    <div class="row mb-3">
                        <div class="col-lg-3 input-group">
                                <!-- Item folding -->
                                <input type="number" step=".1" class="form-control" id="purchase_tax" name="purchase_tax" value="<?= $purchase_tax ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                    <button class="btn btn-outline-success" type="submit" id="save_purchase_tax">Save</button>
                                </div>
                                <?= form_error('purchase_tax', '<small class="text-danger pl-2">', '</small>') ?>
                            </div>
                        </div>
                    </form>
                    <div class="mb-2 h5">Sales Tax</div>
                    <form action="<?= base_url('admin/update_sales_tax/') ?>" method="post">
                    <div class="row mb-5">
                        <div class="col-lg-3 input-group">
                            <!-- Item folding -->
                            <input type="number" step=".1" class="form-control" id="sales_tax" name="sales_tax" value="<?=$sales_tax ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                                <button class="btn btn-outline-success" type="submit" id="save_sales_tax">Save</button>
                            </div>
                            <?= form_error('sales_tax', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    </form>
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

    <script>
        //js for setting purchase tax input onchange
        function change_purchase_tax($amount){
            window.location.href = "<?= site_url('admin/update_purchase_tax/');?>"+amount;
        }
    </script>

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