    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg">
                        <div class="card shadow border-left-primary mb-4">
                            <div class="card-header py-2">
                                <h5 class="m-0 font-weight-bold text-primary">Audit</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>User ID</th>
                                                <th>Username</th>
                                                <th>Action</th>
                                                <th>Table Name</th>
                                                <th>Reference</th>
                                                <th>State Before</th>
                                                <th>State After</th>
                                                <th>IP Address</th>
                                                <th>Timestamps</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($audit as $au) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $i ?></td>
                                                    <td><?= $au['user_id']; ?></td>
                                                    <td><?= $au['username']; ?></td>
                                                    <td><?= $au['action']; ?></td>
                                                    <td><?= $au['table_name']; ?></td>
                                                    <td><?= $au['reference']; ?></td>
                                                    <td><?= $au['state_before']; ?></td>
                                                    <td><?= $au['state_after']; ?></td>
                                                    <td><?= $au['ip_address']; ?></td>
                                                    <td><?= $au['created_at']; ?></td>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
    </div>
</div>