<!-- Begin Page Content -->
<div class="container-fluid">

    <?php 
        $data['items'] = $this->db->get_where('settings', ['parameter' => 'header_color'])->row_array();
        $color = $data['items']['value'];

        $check_year = '';
    ?>

    <?php if ($user['role_id'] != 2) { ?>
        <!-- Content Row for Admin, Employee, Internal-->
        <div class="row">
            <div class="col-lg mb-2">
                <h4>Welcome, <span class="text-primary"><?= $user['name'] . '!'; ?></span></h4>
            </div>
        </div>
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <a class="col-lg-4 mb-4" href=" <?= base_url('events/') ?>" style="text-decoration:none">
                <div class="card border-left-primary py-1">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-primary mb-1">
                                    <?= $user['event_id'] . ' ' . $user['event_name'];?></div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-boxes fa-2x text-gray-800"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <?php } else if ($user['role_id'] == 2){ ?>
        <div class="row">
            <div class="col-lg mb-2">
                <h4>Welcome, <span class="text-primary"><?= $user['name'] . '!'; ?></span></h4>
            </div>
        </div>
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <a class="col-lg-4 mb-4" href=" <?= base_url('events/') ?>" style="text-decoration:none">
                <div class="card border-left-primary py-1">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-primary mb-1">
                                    <?= $user['event_id'] . ' ' . $user['event_name'];?></div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-boxes fa-2x text-gray-800"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <?php }; ?>
    </div>
</div>  
<!-- End of Main Content -->

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#table1').DataTable({
            paging: true,
            columnDefs: [{
                targets: [0, 1, 2, 3],
                orderable: true,
                searchable: true
            }]
        });

        // Kanban toggle text-change functionality
        $('#collapseKanban').on('show.bs.collapse', function() {
            $('#collapseKanbanBtn').text('Collapse Kanban Board');
        });
        
        $('#collapseKanban').on('hide.bs.collapse', function() {
            $('#collapseKanbanBtn').text('Expand Kanban Board');  
        });
    });
</script>