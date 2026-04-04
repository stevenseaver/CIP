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
                                                <th>Row Affected</th>
                                                <th>Reference</th>
                                                <th>State Before</th>
                                                <th>State After</th>
                                                <th>Difference</th>
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
                                                    <td><?= $au['row']; ?></td>
                                                    <td><?= $au['reference']; ?></td>
                                                    <td><?= $au['state_before']; ?></td>
                                                    <td><?= $au['state_after']; ?></td>
                                                   <?php 
                                                        $diff = [];

                                                        $before = is_array($au['state_before']) 
                                                                    ? $au['state_before'] 
                                                                    : json_decode($au['state_before'], true);

                                                        $after = is_array($au['state_after']) 
                                                                    ? $au['state_after'] 
                                                                    : json_decode($au['state_after'], true);

                                                        if (is_array($before) && is_array($after)) {
                                                            $diff = array_diff_assoc($before, $after);
                                                        };
                                                    ?>
                                                    <td><?= !empty($diff) ? print_r($diff, true) : 'Clear'; ?></td>
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