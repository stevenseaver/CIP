<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="h3 text-gray-800"><?= $title ?></div>
        <?php 
            $data['items'] = $this->db->get_where('settings', ['parameter' => 'header_color'])->row_array();
            $color = $data['items']['value'];
        ?>

        <!-- <div class="dropdown text-center my-2">
            <button class="btn btn-<?= $color?> dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                <a id="periode_show" name="periode_show"><?= $current_periode ?></a>
            </button>
    
            <div class="dropdown-menu">
                <?php $j = 0;
                $current_time = time();
                $year = date('Y', $current_time);
                $month = date('m', $current_time);
                foreach($periode as $per) : 
                    if($per['year'] <= $year and $per['year'] >= $year-1 or $per['year'] == '0') { 
                        if($per['year'] < $year or $per['month'] <= $month) {?>
                            <a class="dropdown-item" href="<?= base_url('production/usage?start_date=' . $per['start_date'] . '&end_date=' . $per['end_date'] . '&name=' . $per['id'])?>" onclick="select_date($per['id'])"><?= $per['period'];?></a>
                        <?php } else {
                        
                        }?>
                    <?php
                    }
                    else { 

                    };
                endforeach; ?>
            </div>
        </div> -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row align-items-end mb-4">
                <!-- Start Date -->
                <div class="col-md-3">
                    <label for="start_date">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" 
                        value="<?= date('Y-m-d', $start_date) ?>">
                </div>
                
                <!-- End Date -->
                <div class="col-md-3">
                    <label for="end_date">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" 
                        value="<?= date('Y-m-d', $end_date) ?>">
                </div>
                
                <!-- Apply Button -->
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary btn-block" onclick="applyDateRange()">
                        <i class="fas fa-search"></i> Apply
                    </button>
                </div>
                
                <!-- Month Shortcuts Dropdown -->
                <div class="col-md-4">
                    <label>Quick Select Month</label>
                    <div class="dropdown">
                        <button class="btn btn-<?= $color ?? 'secondary' ?> dropdown-toggle btn-block" 
                                type="button" data-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-calendar"></i> <span id="selected_period">
                            <?php
                            // Display current selected period
                            $current_period_name = 'Select Month';
                            for ($i = 0; $i < 12; $i++) {
                                $month_time = strtotime("-$i months");
                                $year = date('Y', $month_time);
                                $month = date('n', $month_time);
                                $month_start = mktime(0, 0, 0, $month, 1, $year);
                                $month_end = mktime(23, 59, 59, $month, date('t', $month_start), $year);
                                
                                if ($start_date == $month_start && $end_date == $month_end) {
                                    $current_period_name = date('F Y', $month_time);
                                    break;
                                }
                            }
                            echo $current_period_name;
                            ?>
                            </span>
                        </button>
                        <div class="dropdown-menu" style="max-height: 300px; overflow-y: auto;">
                            <?php
                            // Generate last 12 months
                            for ($i = 0; $i < 12; $i++) {
                                $month_time = strtotime("-$i months");
                                $year = date('Y', $month_time);
                                $month = date('n', $month_time);
                                $month_start = mktime(0, 0, 0, $month, 1, $year);
                                $month_end = mktime(23, 59, 59, $month, date('t', $month_start), $year);
                                $month_name = date('F Y', $month_time);
                                
                                // Check if this month is currently selected
                                $is_active = ($start_date == $month_start && $end_date == $month_end) ? 'active' : '';
                            ?>
                                <a class="dropdown-item <?= $is_active ?>" 
                                href="<?= base_url('production/usage?start_date=' . $month_start . '&end_date=' . $month_end) ?>">
                                    <?= $month_name ?>
                                </a>
                            <?php } ?>
                            
                            <div class="dropdown-divider"></div>
                            
                            <!-- Additional shortcuts -->
                            <a class="dropdown-item" href="#" onclick="setDateRange('today'); return false;">
                                <i class="bi bi-calendar-date"></i> Today
                            </a>
                            <a class="dropdown-item" href="#" onclick="setDateRange('yesterday'); return false;">
                                <i class="bi bi-calendar-minus"></i> Yesterday
                            </a>
                            <a class="dropdown-item" href="#" onclick="setDateRange('last7days'); return false;">
                                <i class="bi bi-calendar-week"></i> Last 7 Days
                            </a>
                            <a class="dropdown-item" href="#" onclick="setDateRange('last30days'); return false;">
                                <i class="bi bi-calendar3"></i> Last 30 Days
                            </a>
                            <a class="dropdown-item" href="#" onclick="setDateRange('alltime'); return false;">
                                <i class="bi bi-calendar3"></i> All Time
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-group list-group-flush" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active" id="list-Material-list" data-toggle="list" href="#list-Material" role="tab" aria-controls="general">Materials Usage</a>
                <a class="list-group-item list-group-item-action" id="list-Roll-list" data-toggle="list" href="#list-Roll" role="tab" aria-controls="backup">Roll Produced</a>
                <a class="list-group-item list-group-item-action" id="list-FG-list" data-toggle="list" href="#list-FG" role="tab" aria-controls="backup">Finished Goods Produced</a>
            </div>
        </div>
    </div>
    
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="list-Material" role="tabpanel" aria-labelledby="list-Material-list">
            <?php if ($materialUsage != null) {
                $i = 1;
                $temp = 0;
                $temp1 = 0;
                $total_weight = 0;
                $total_item = 0;
                $subtotal = 0;
                $grandTotal = 0;
                $before = '';
            ?>
            <div class="card rounded border-0 shadow mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Production Usage</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($materialUsage as $items) :
                                        if ($before != $items['name']) { ?>
                                        <tr>
                                            <td><?= $items['name']; ?></td>
                                            <td>
                                                <?php 
                                                    foreach ($materialUsage as $amount) :
                                                        if ($amount['name'] == $items['name'] and $amount['unit_satuan'] == 'kg') {
                                                            $temp = $temp + $amount['outgoing'];
                                                        } else if($amount['name'] == $items['name']){
                                                            $temp1 = $temp1 + $amount['outgoing'];
                                                        };
                                                    endforeach;
                                                    if($temp != 0){
                                                        echo number_format($temp, 2, ',', '.') . ' '. $items['unit_satuan']; 
                                                    } else {
                                                        echo number_format($temp1, 2, ',', '.') . ' '. $items['unit_satuan']; 
                                                    };
                                                ?>
                                            </td>
                                            <?php
                                                $price = $items['price'];
                                                if($temp != 0){
                                                    $subtotal = $temp * $price;
                                                } else {
                                                    $subtotal = $temp1 * $price;
                                                };
                                                $grandTotal = $grandTotal + $subtotal;
                                            ?>
                                            <td><?= number_format($price, 2, ',', '.'); ?></td>
                                            <td><?= number_format($subtotal, 2, ',', '.'); ?></td>
                                        </tr>
                                        <?php
                                            $before = $items['name'];
                                            $total_weight = $total_weight + $temp;
                                            $total_item = $total_item + $temp1;
                                            $temp = 0;
                                            $temp1 = 0;
                                            $subtotal = 0;
                                            $i++;
                                    } else {
                                    };
                                    endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right"><strong>Total</strong></td>
                                        <td><?= number_format($total_weight, 2, ',', '.') . ' kg and ' . number_format($total_item, 2, ',', '.') . ' pcs'; ?></td>
                                        <td></td>
                                        <td><?= 'Rp '. number_format($grandTotal, 2, ',', '.'); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } else { ?>
                <div class="alert alert-danger" role="alert">There's no transaction! </a></div>
            <?php }; ?>
        </div>
        <div class="tab-pane fade" id="list-Roll" role="tabpanel" aria-labelledby="list-Roll-list">
            <?php if ($rollProduced != null) {
                $i = 1;
                $temp = 0;
                $temp1 = 0;
                $total_weight = 0;
                $total_item = 0;
                $subtotal = 0;
                $grandTotal = 0;
                $before = '';
            ?>
            <div class="card rounded border-0 shadow mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table2" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Production Made</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rollProduced as $items) :
                                        //only shown if status == 3 or 9
                                        if ($items['status'] == 1 or $items['status'] == 7) {
                                            continue;
                                        } else {
                                            if ($before != $items['name']) { ?>
                                            <tr>
                                                <td><?= $items['name']; ?></td>
                                                <td>
                                                    <?php 
                                                        foreach ($rollProduced as $amount) :
                                                            if ($amount['name'] == $items['name']) {
                                                                $temp = $temp + $amount['incoming']; 
                                                            } else {
                                                                
                                                            };
                                                        endforeach;
                                                        echo number_format($temp , 2, ',', '.') . ' kg'; 
                                                        ?>
                                                </td>
                                                <?php
                                                    $price = $items['price'];
                                                    $subtotal = $temp * $price;
                                                    $grandTotal = $grandTotal + $subtotal;
                                                ?>
                                                <td><?= number_format($price, 2, ',', '.'); ?></td>
                                                <td><?= number_format($subtotal, 2, ',', '.'); ?></td>
                                            </tr>
                                            <?php
                                                $before = $items['name'];
                                                $total_weight = $total_weight + $temp;
                                                $temp = 0;
                                                $subtotal = 0;
                                                $i++;
                                            } else {
                                            };
                                        };
                                    endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right"><strong>Total</strong></td>
                                        <td><?= number_format($total_weight, 2, ',', '.') . ' kg'; ?></td>
                                        <td></td>
                                        <td><?= 'Rp '. number_format($grandTotal, 2, ',', '.'); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } else { ?>
                <div class="alert alert-danger" role="alert">There's no transaction! </a></div>
            <?php }; ?>
        </div>
        <div class="tab-pane fade" id="list-FG" role="tabpanel" aria-labelledby="list-FG-list">
            <?php if ($fgProduced != null) {
                $i = 1;
                $temp = 0;
                $total_weight = 0;
                $total_item = 0;
                $subtotal = 0;
                $grandTotal = 0;
                $before = '';
            ?>
            <div class="card rounded border-0 shadow mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table1" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Production Made</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($fgProduced as $items) :
                                        if ($before != $items['name']) { ?>
                                            <tr>
                                                <td><?= $items['name']; ?></td>
                                                <td>
                                                    <?php 
                                                        foreach ($fgProduced as $amount) :
                                                            if ($amount['name'] == $items['name']) {
                                                                $temp = $temp + $amount['before_convert']; 
                                                            } else {

                                                            };
                                                        endforeach;
                                                        echo number_format($temp , 2, ',', '.') . ' kg'; 
                                                    ?>
                                                </td>
                                                <?php
                                                    $price = $items['price'];
                                                    $subtotal = $temp * $price;
                                                    $grandTotal = $grandTotal + $subtotal;
                                                ?>
                                                <td><?= number_format($price, 2, ',', '.'); ?></td>
                                                <td><?= number_format($subtotal, 2, ',', '.'); ?></td>
                                            </tr>
                                            <?php
                                                $before = $items['name'];
                                                $total_weight = $total_weight + $temp;
                                                $temp = 0;
                                                $subtotal = 0;
                                                $i++;
                                        } else {
                                        };
                                    endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right"><strong>Total</strong></td>
                                        <td><?= number_format($total_weight, 2, ',', '.') . ' kg'; ?></td>
                                        <td></td>
                                        <td><?= 'Rp '. number_format($grandTotal, 2, ',', '.'); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } else { ?>
                <div class="alert alert-danger" role="alert">There's no transaction! </a></div>
            <?php }; ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>
    function left_click() {
        document.getElementById("periode_show").innerHTML = 'LEFT';
    }

    function right_click() {
        document.getElementById("periode_show").innerHTML = 'RIGHT';
    }

    var table2 = $('#table2').DataTable({
        paging: true,
        select: {
            style: 'single'
        },
        columnDefs: [
            {
                targets:[0,1,2,3],
                orderable: true,
                searchable: true
            }
        ]
    });
    
    var table1 = $('#table1').DataTable({
        paging: true,
        select: {
            style: 'single'
        },
        columnDefs: [
            {
                targets:[0,1,2,3],
                orderable: true,
                searchable: true
            }
        ]
    });

    function applyDateRange() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        
        if (!startDate || !endDate) {
            alert('Please select both start and end dates');
            return;
        }
        
        // Convert to timestamps
        const startTimestamp = new Date(startDate).getTime() / 1000;
        const endTimestamp = new Date(endDate + ' 23:59:59').getTime() / 1000;
        
        if (startTimestamp > endTimestamp) {
            alert('Start date must be before end date');
            return;
        }
        
        window.location.href = '<?= base_url('production/usage') ?>?start_date=' + startTimestamp + '&end_date=' + endTimestamp;
    }

    function setDateRange(range) {
        const now = new Date();
        let startDate, endDate;
        let rangeName = '';
        
        switch(range) {
            case 'today':
                startDate = endDate = now;
                rangeName = 'Today';
                break;
                
            case 'yesterday':
                startDate = endDate = new Date(now.setDate(now.getDate() - 1));
                rangeName = 'Yesterday';
                break;
                
            case 'last7days':
                endDate = new Date();
                startDate = new Date(now.setDate(now.getDate() - 6));
                rangeName = 'Last 7 Days';
                break;
                
            case 'last30days':
                endDate = new Date();
                startDate = new Date(now.setDate(now.getDate() - 29));
                rangeName = 'Last 30 Days';
                break;

            case 'alltime':
                endDate = new Date();
                startDate = new Date(now.setDate(now.getDate() - 20362));
                rangeName = 'All time';
                break;
        }
        
        // Update the button text
        document.getElementById('selected_period').textContent = rangeName;
        
        // Format dates as YYYY-MM-DD
        document.getElementById('start_date').value = formatDate(startDate);
        document.getElementById('end_date').value = formatDate(endDate);
        
        // Auto apply
        applyDateRange();
    }

    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Allow pressing Enter to apply date range
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('start_date').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') applyDateRange();
        });
        document.getElementById('end_date').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') applyDateRange();
        });
    });
</script>