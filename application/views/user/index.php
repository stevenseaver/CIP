<!-- Begin Page Content -->
<div class="container-fluid">

    <?php 
        $data['items'] = $this->db->get_where('settings', ['parameter' => 'header_color'])->row_array();
        $color = $data['items']['value'];

        $check_year = '';
    ?>

    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row align-items-end mb-3">
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
                                $month_time = strtotime("-$i months", mktime(0, 0, 0, date('n'), 1, date('Y')));
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
                                $month_time = strtotime("-$i months", mktime(0, 0, 0, date('n'), 1, date('Y')));
                                $year = date('Y', $month_time);
                                $month = date('n', $month_time);
                                $month_start = mktime(0, 0, 0, $month, 1, $year);
                                $month_end = mktime(23, 59, 59, $month, date('t', $month_start), $year);
                                $month_name = date('F Y', $month_time);
                                
                                // Check if this month is currently selected
                                $is_active = ($start_date == $month_start && $end_date == $month_end) ? 'active' : '';
                            ?>
                                <a class="dropdown-item <?= $is_active ?>" 
                                href="<?= base_url('user/index?start_date=' . $month_start . '&end_date=' . $month_end) ?>">
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
        </div>
    </div>

    <?php if ($user['role_id'] != 3 and $user['role_id'] != 2) { ?>
        <!-- Content Row for Admin, Employee, Internal-->
        <?php 
            $temp = 0;
            $prodOrderCount1 = 0;
            $prodOrderCount2 = 0;
            $prodOrderCount3 = 0;
            $prodOrderCount4 = 0;
            $prodOrderCount5 = 0;
            $prodOrderCount6 = 0;
            $before = '';
            foreach ($prodOrder1 as $items) :
                if ($before != $items['transaction_id']) {
                    $before = $items['transaction_id'];
                    // echo $items['transaction_id'] . ' ';
                    $temp++;
                } else {
                }
                $prodOrderCount1 = $temp;
            endforeach;
            $temp = 0;
            foreach ($prodOrder2 as $items) :
                if ($before != $items['transaction_id']) {
                    $before = $items['transaction_id'];
                    $temp++;
                } else {
                }
                $prodOrderCount2 = $temp;
            endforeach;
            $temp = 0;
            foreach ($prodOrder3 as $items) :
                if ($before != $items['transaction_id']) {
                    $before = $items['transaction_id'];
                    $temp++;
                } else {
                }
                $prodOrderCount3 = $temp;
            endforeach;
            $temp = 0;
            foreach ($prodOrder4 as $items) :
                if ($before != $items['transaction_id']) {
                    $before = $items['transaction_id'];
                    $temp++;
                } else {
                }
                $prodOrderCount4 = $temp;
            endforeach;
            $temp = 0;
            foreach ($prodOrder5 as $items) :
                if ($before != $items['transaction_id']) {
                    $before = $items['transaction_id'];
                    $temp++;
                } else {
                }
                $prodOrderCount5 = $temp;
            endforeach;
            $temp = 0;
            foreach ($prodOrder6 as $items) :
                if ($before != $items['transaction_id']) {
                    $before = $items['transaction_id'];
                    $temp++;
                } else {
                }
                $prodOrderCount6 = $temp;
            endforeach;
            
        ?>
        
        <div class="row mb-0">
            <!-- Kanban Board Prod Summary -->
            <a class="col-lg-2 mb-4" href=" <?= base_url('production') ?>" style="text-decoration:none">
                <div class="card border-left-secondary py-1">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Production Queue</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $prodOrderCount1 ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-1-circle fa-2x text-gray-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a class="col-lg-2 mb-4" href=" <?= base_url('production') ?>" style="text-decoration:none">
                <div class="card border-left-info py-1">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Extrusion Starting</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $prodOrderCount2 ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-2-circle fa-2x text-gray-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a class="col-lg-2 mb-4" href=" <?= base_url('production') ?>" style="text-decoration:none">
                <div class="card border-left-primary py-1">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Extrusion Complete</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $prodOrderCount3 ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-3-circle fa-2x text-gray-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a class="col-lg-2 mb-4" href=" <?= base_url('production') ?>" style="text-decoration:none">
                <div class="card border-left-warning py-1">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Cutting Started</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $prodOrderCount4 ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-4-circle fa-2x text-gray-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a class="col-lg-2 mb-4" href=" <?= base_url('production') ?>" style="text-decoration:none">
                <div class="card border-left-success py-1">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Production Finished</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $prodOrderCount5 ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-5-circle fa-2x text-gray-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a class="col-lg-2 mb-4" href=" <?= base_url('production') ?>" style="text-decoration:none">
                <div class="card border-left-danger py-1">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Production Problems</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $prodOrderCount6 ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-6-circle fa-2x text-gray-600"></i>`
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="row">
            <div class="col-lg text-center">
                <p class="text-primary mb-3" type="button" data-toggle="collapse" id="collapseKanbanBtn" data-target="#collapseKanban" aria-expanded="false" aria-controls="collapseKanban">
                    Expand Kanban Board
                </p>
            </div>
        </div>
        <!-- </p> -->
        
        <div class="collapse" id="collapseKanban">
            <div class="card card-body px-0 bg-gray-100 border-0">
                <div class="row">
                    <div class="col-lg-2 mb-4">
                        <div class="card border-left-secondary py-1">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <?php 
                                        foreach ($prodOrder1 as $items) :
                                            if ($before != $items['transaction_id']) {
                                                $before = $items['transaction_id']; ?>
                                                <div class="d-flex bg-gray-100 rounded px-3 py-1 mb-3">
                                                    <a class="" href="<?= base_url('production/gbj_details/') . $items['transaction_id'] ?>"><?= $items['transaction_id'] . ' ' .  $items['product_name'];?></a>
                                                </div>
                                                <?php } else {
                                                }; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 mb-4">
                        <div class="card border-left-info py-1">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <?php 
                                        foreach ($prodOrder2 as $items) :
                                            if ($before != $items['transaction_id']) {
                                                $before = $items['transaction_id']; ?>
                                                <div class="d-flex bg-gray-100 rounded px-3 py-1 mb-3">
                                                    <a class="" href="<?= base_url('production/gbj_details/') . $items['transaction_id'] ?>"><?= $items['transaction_id'] . ' ' .  $items['product_name'];?></a>
                                                </div>
                                                <?php } else {
                                                }; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 mb-4">
                        <div class="card border-left-primary py-1">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <?php 
                                        foreach ($prodOrder3 as $items) :
                                            if ($before != $items['transaction_id']) {
                                                $before = $items['transaction_id']; ?>
                                                <div class="d-flex bg-gray-100 rounded px-3 py-1 mb-3">
                                                    <a class="" href="<?= base_url('production/gbj_details/') . $items['transaction_id'] ?>"><?= $items['transaction_id'] . ' ' .  $items['product_name'];?></a>
                                                </div>
                                                <?php } else {
                                                }; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 mb-4">
                        <div class="card border-left-warning py-1">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <?php 
                                        foreach ($prodOrder4 as $items) :
                                            if ($before != $items['transaction_id']) {
                                                $before = $items['transaction_id']; ?>
                                                <div class="d-flex bg-gray-100 rounded px-3 py-1 mb-3">
                                                    <a class="" href="<?= base_url('production/gbj_details/') . $items['transaction_id'] ?>"><?= $items['transaction_id'] . ' ' .  $items['product_name'];?></a>
                                                </div>
                                                <?php } else {
                                                }; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 mb-4">
                        <div class="card border-left-success py-1">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <?php 
                                        foreach ($prodOrder5 as $items) :
                                            if ($before != $items['transaction_id']) {
                                                $before = $items['transaction_id']; ?>
                                                <div class="d-flex bg-gray-100 rounded px-3 py-1 mb-3">
                                                    <a class="" href="<?= base_url('production/gbj_details/') . $items['transaction_id'] ?>"><?= $items['transaction_id'] . ' ' .  $items['product_name'];?></a>
                                                </div>
                                                <?php } else {
                                                }; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 mb-4">
                        <div class="card border-left-danger py-1">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <?php 
                                        foreach ($prodOrder6 as $items) :
                                            if ($before != $items['transaction_id']) {
                                                $before = $items['transaction_id']; ?>
                                                <div class="d-flex bg-gray-100 rounded px-3 py-1 mb-3">
                                                    <a class="" href="<?= base_url('production/gbj_details/') . $items['transaction_id'] ?>"><?= $items['transaction_id'] . ' ' .  $items['product_name'];?></a>
                                                </div>
                                                <?php } else {
                                                }; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if ($user['role_id'] == 1 or $user['role_id'] == 2 or $user['role_id'] == 7) { ?>
            <div class="row">
                <?php
                    $temp = 0;
                    $total_revenue = 0;
                    //current periode revenue
                    foreach ($sales_data as $sales) :
                        if ($before != $sales['ref']) { 
                            $date_now = time(); 
                            foreach ($sales_data as $amount) :
                                if ($amount['ref'] == $sales['ref']) {
                                    $value = ($amount['price']-$amount['discount']) * $amount['qty'];
                                    $temp = $temp + $value; 
                                } else {

                                }
                            endforeach;
                            // echo number_format($temp, 2, ',', '.'); 
                            $total_revenue = $temp + $total_revenue;
                            $total_revenue;
                            $before = $sales['ref'];
                            $temp = 0;
                            $tax = 0;
                        } else {
                        }
                    endforeach; 
                    //year to date revenue (annually)
                    $temp = 0;
                    $ytd_revenue = 0;
                    foreach ($ytd_sales as $sales) :
                        if ($before != $sales['ref']) { 
                            $date_now = time(); 
                            foreach ($ytd_sales as $amount) :
                                if ($amount['ref'] == $sales['ref']) {
                                    $value = ($amount['price']-$amount['discount']) * $amount['qty'];
                                    $temp = $temp + $value; 
                                } else {

                                }
                            endforeach;
                            // echo number_format($temp, 2, ',', '.'); 
                            $ytd_revenue = $temp + $ytd_revenue;
                            $ytd_revenue;
                            $before = $sales['ref'];
                            $temp = 0;
                            $tax = 0;
                        } else {
                        }
                    endforeach; 
                    //all time payables
                    $temp = 0; 
                    $payables = 0;
                    foreach ($inventory_item_received as $inv_rcv) :
                        if ($before != $inv_rcv['transaction_id']) { 
                            $date_now = time();
                            $due_date = $inv_rcv['date'] + $inv_rcv['term'] * 24 * 3600;
                            if($inv_rcv['is_paid'] == 0 and $due_date < $date_now ) {
                                foreach ($inventory_item_received as $amount) :
                                    if ($amount['transaction_id'] == $inv_rcv['transaction_id']) {
                                        $value = $amount['price'] * $amount['incoming'];
                                        $temp = $temp + $value; 
                                    } else {

                                    }
                                endforeach;
                                if($inv_rcv['tax'] == 0){

                                } else if ($inv_rcv['tax'] == 1) {
                                    $data['purchase_tax'] = $this->db->get_where('settings', ['parameter' => 'purchase_tax'])->row_array();
                                    $purchase_tax = $data['purchase_tax']['value'];
                                    
                                    $tax = $purchase_tax/100 * $temp;

                                    $temp = $temp + $tax;
                                }
                                $payables = $temp + $payables;
                                $before = $inv_rcv['transaction_id'];
                                $temp = 0;
                                $tax = 0;
                            } else {

                            }
                        } else {
                        }  
                    endforeach; 
                ?>
                <!-- Earnings (Monthly) Card -->
                <a class="col-xl-4 col-md-6 mb-4" href=" <?= base_url('sales/salesinfo?start_date=' . $start_date . '&end_date=' . $end_date . '') ?>" style="text-decoration:none">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="font-weight-bold text-primary mb-1">
                                        Earnings (This Period)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">IDR <?= number_format($total_revenue, 2, ',', '.'); ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-currency-dollar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- Earnings (Year-to-date) Card -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="font-weight-bold text-primary mb-1">
                                        Earnings (Year-to-Date)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">IDR <?= number_format($ytd_revenue, 2, ',', '.'); ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-currency-dollar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Employee Leave Card -->
                <a class="col-xl-4 col-md-6 mb-4" href="<?= base_url('purchasing/purchaseinfo') ?>" style="text-decoration:none">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="font-weight-bold text-warning mb-1">
                                        Accounts Payable (Due to-date)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">IDR <?= number_format($payables, 2, ',', '.'); ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php } else {
             
        } ?>

        <div class="row">
            <?php
                $temp = 0;
                $salesOrder = $temp;
                $before = '';
                foreach ($dataCartSO as $items) :
                    if ($before != $items['ref']) {
                        $before = $items['ref'];
                        $temp++;
                    } else {
                    }
                    $salesOrder = $temp;
                endforeach;
            ?>
            
            <!-- Sales order -->
            <a class="col-xl-4 col-md-6 mb-4" href=" <?= base_url('sales') ?>" style="text-decoration:none">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-info mb-1">Sales Order
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $salesOrder ?></div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: <?= $salesOrder ?>%" aria-valuenow="<?= $salesOrder ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <!-- Cust Message -->
            <a class="col-xl-4 col-md-6 mb-4" href=" <?= base_url('contact') ?>" style="text-decoration:none">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-success mb-1">
                                    Message from Customer</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $custMessage ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Employee Leave Card -->
            <a class="col-xl-4 col-md-6 mb-4" href="<?= base_url('hr/index') ?>" style="text-decoration:none">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-warning mb-1">
                                    Employee Leave Requests</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $employeeLeaveCount ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <?php
            $i = 1;
            $temp = 0;
            foreach ($materialStock as $ms) :
                $value = $ms['price'] * $ms['in_stock'];
                $temp = $temp + $value;
            endforeach;
            $materialValue = $temp;

            $temp = 0;
            foreach ($rollStock as $rs) :
                $value = $rs['price'] * $rs['in_stock'];
                $temp = $temp + $value;
            endforeach;
            $prodValue = $temp;

            $temp = 0;
            foreach ($fgStock as $fg) :
                $value = $fg['price'] * $fg['in_stock'];
                $temp = $temp + $value;
            endforeach;
            $gbjValue = $temp;

            $totalWarehouseValue = $materialValue + $prodValue + $gbjValue;
            if ($totalWarehouseValue != 0){
                $percentMaterial = ($materialValue / $totalWarehouseValue) * 100;
                $percentProd = ($prodValue / $totalWarehouseValue) * 100;
                $percentGBJ = ($gbjValue / $totalWarehouseValue) * 100;
            } else {
                $percentMaterial = 0;
                $percentProd = 0;
                $percentGBJ = 0;
            }
        ?>
        <!-- Content Row -->
        <!-- <div class="row">
            <div class="col-lg-12 mb-2">
                <div class="card shadow mb-1">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Accounts Payable Due Purchase Info</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>PO Number</th>
                                        <th>Date</th>
                                        <th>Due Date</th>
                                        <th>Supplier</th>
                                        <th>Total Amount</th>
                                        <th>Payment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $temp = 0; ?>
                                    <?php foreach ($inventory_item_received as $inv_rcv) :
                                        if ($before != $inv_rcv['transaction_id']) { 
                                            $date_now = time();
                                            $due_date = $inv_rcv['date'] + $inv_rcv['term'] * 24 * 3600;
                                            if($inv_rcv['is_paid'] == 0 and $due_date < $date_now ) { ?>
                                                <tr>
                                                    <td><?= $inv_rcv['transaction_id'] ?></td>
                                                    <td><?= date('d F Y H:i:s', $inv_rcv['date']); ?></td>
                                                    <td><?= date('d F Y H:i:s', $due_date); ?></td>
                                                    <td><?= $inv_rcv['supplier_name'] ?></td>
                                                    <td>
                                                        <?php 
                                                            foreach ($inventory_item_received as $amount) :
                                                                if ($amount['transaction_id'] == $inv_rcv['transaction_id']) {
                                                                    $value = $amount['price'] * $amount['incoming'];
                                                                    $temp = $temp + $value; 
                                                                } else {

                                                                }
                                                            endforeach;
                                                            if($inv_rcv['tax'] == 0){

                                                            } else if ($inv_rcv['tax'] == 1) {
                                                                $data['purchase_tax'] = $this->db->get_where('settings', ['parameter' => 'purchase_tax'])->row_array();
                                                                $purchase_tax = $data['purchase_tax']['value'];
                                                                
                                                                $tax = $purchase_tax/100 * $temp;

                                                                $temp = $temp + $tax;
                                                                
                                                            }
                                                            echo number_format($temp, 2, ',', '.'); 
                                                        ?>
                                                    </td>
                                                    <td><?php 
                                                        if ($inv_rcv['is_paid'] == 0) {
                                                            echo '<p class="badge badge-warning">Unpaid</p>';
                                                        } else {
                                                            echo '<p class="badge badge-success">Paid</p>';
                                                        }?>
                                                    </td>
                                                    <td>
                                                        <a href="<?= base_url('purchasing/info_details/') . $inv_rcv['transaction_id'] . '/' . $inv_rcv['supplier'] . '/' . $inv_rcv['date'] ?>" class="badge badge-primary"><i class="bi bi-info-circle"> </i>Details</a>
                                                    </td>
                                                </tr>
                                        <?php
                                            $before = $inv_rcv['transaction_id'];
                                            $temp = 0;
                                            $tax = 0;
                                            } else {

                                            }
                                        } else {
                                        } ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Sales Info -->
        <!-- <div class="row">
            <div class="col-lg-12 mb-2">
                <div class="card shadow mb-1">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Sales Info in This Period</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table1" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Total Amount (Excl. Tax)</th>
                                        <th>Status</th>
                                        <th>Payment Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $temp = 0;
                                    $total_revenue = 0;
                                    foreach ($sales_data as $sales) :
                                        if ($before != $sales['ref']) { 
                                            $date_now = time(); ?>
                                            <tr>
                                                <td><?= $sales['ref'] ?></td>
                                                <td><?= date('d F Y H:i:s', $sales['date']); ?></td>
                                                <td><?= $sales['name'] ?></td>
                                                <td>
                                                    <?php 
                                                        foreach ($sales_data as $amount) :
                                                            if ($amount['ref'] == $sales['ref']) {
                                                                $value = ($amount['price']-$amount['discount']) * $amount['qty'];
                                                                $temp = $temp + $value; 
                                                            } else {

                                                            }
                                                        endforeach;
                                                        // if($sales['tax'] == 0){

                                                        // } else if ($sales['tax'] == 1) {
                                                        //     $data['purchase_tax'] = $this->db->get_where('settings', ['parameter' => 'purchase_tax'])->row_array();
                                                        //     $purchase_tax = $data['purchase_tax']['value'];
                                                            
                                                        //     $tax = $purchase_tax/100 * $temp;

                                                        //     $temp = $temp + $tax;
                                                            
                                                        // }
                                                        echo number_format($temp, 2, ',', '.'); 
                                                    ?>
                                                </td>
                                                <td><?php 
                                                    if ($sales['status'] == 1) {
                                                        echo '<p class="badge badge-warning">Not yet delivered</p>';
                                                    } else if ($sales['status'] == 2){
                                                        echo '<p class="badge badge-primary">Delivering</p>';
                                                    } else if ($sales['status'] == 3){
                                                        echo '<p class="badge badge-success">Delivered</p>';
                                                    } else if ($sales['status'] == 4){
                                                        echo '<p class="badge badge-danger">Declined</p>';
                                                    }
                                                ?>
                                                </td>
                                                <td><?php 
                                                    if ($sales['is_paid'] == 1) {
                                                        echo '<p class="badge badge-success">Paid</p>';
                                                    } else {
                                                        echo '<p class="badge badge-warning">Unpaid</p>';
                                                    } ?>
                                                </td>
                                                <?php
                                                    $total_revenue = $temp + $total_revenue;
                                                    $total_revenue;
                                                ?>
                                                <td>
                                                    <a href="<?= base_url('sales/info_detail/') . $sales['ref']; ?>" class="badge badge-primary"><i class="bi bi-info-circle"> </i>Details</a>
                                                </td>
                                            </tr> 
                                        <?php
                                            $before = $sales['ref'];
                                            $temp = 0;
                                            $tax = 0;
                                        } else {
                                        } ?>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    
                                    <td colspan="2"></td>
                                    <td>
                                        <p class="font-weight-bold text-primary text-left">Total Revenue IDR</p>
                                    </td>
                                    <td>
                                        <p class="font-weight-bold text-primary text-left"><?= number_format($total_revenue, 2, ',', '.'); ?></p>
                                    </td>
                                    <td colspan="3"></td>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- Inventory Value Card -->
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Inventory Value</h6>
                        <span class="badge badge-pill badge-success">Live</span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start">
                            <div style="position:relative; width:150px; height:150px; flex-shrink:0;">
                                <canvas id="inventoryDonut"></canvas>
                                <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none;">
                                    <small class="text-muted" style="font-size:10px;">Total</small>
                                    <span class="font-weight-bold" style="font-size:12px;">
                                    IDR <?= number_format($totalWarehouseValue / 1e9, 1) ?>B
                                    </span>
                                </div>
                            </div>
                            <!-- Material warehouse -->
                            <div class="flex-fill mt-3 mt-md-0 ml-md-3" style="min-width:0; width:100%;">
                            <a href="<?= base_url('inventory/material_wh') ?>" class="text-decoration-none">
                                <div class="d-flex align-items-center py-2 border-bottom" style="gap:6px;">
                                <span style="width:9px;height:9px;background:#E74A3B;border-radius:2px;flex-shrink:0;"></span>
                                <!-- FIX 3: truncate long name, whitespace nowrap on numbers -->
                                <span class="flex-fill font-weight-bold text-dark" style="min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">Material warehouse</span>
                                <span class="text-muted" style="white-space:nowrap;">IDR <?= number_format($materialValue, 2, ',', '.') ?></span>
                                <span class="text-muted" style="white-space:nowrap;min-width:32px;text-align:right;"><?= number_format($percentMaterial, 1) ?>%</span>
                                </div>
                            </a>
                            <!-- Production warehouse -->
                            <a href="<?= base_url('inventory/prod_wh') ?>" class="text-decoration-none">
                                <div class="d-flex align-items-center py-2 border-bottom" style="gap:6px;">
                                <span style="width:9px;height:9px;background:#F6C23E;border-radius:2px;flex-shrink:0;"></span>
                                <span class="flex-fill font-weight-bold text-dark" style="min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">Production warehouse</span>
                                <span class="text-muted" style="white-space:nowrap;">IDR <?= number_format($prodValue, 2, ',', '.') ?></span>
                                <span class="text-muted" style="white-space:nowrap;min-width:32px;text-align:right;"><?= number_format($percentProd, 1) ?>%</span>
                                </div>
                            </a>
                            <!-- GBJ Warehouse -->
                            <a href="<?= base_url('inventory/gbj_wh') ?>" class="text-decoration-none">
                                <div class="d-flex align-items-center py-2" style="gap:6px;">
                                <span style="width:9px;height:9px;background:#1CC88A;border-radius:2px;flex-shrink:0;"></span>
                                <span class="flex-fill font-weight-bold text-dark" style="min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">Finished goods warehouse</span>
                                <span class="text-muted" style="white-space:nowrap;">IDR <?= number_format($gbjValue, 2, ',', '.') ?></span>
                                <span class="text-muted" style="white-space:nowrap;min-width:32px;text-align:right;"><?= number_format($percentGBJ, 1) ?>%</span>
                                </div>
                            </a>

                            <div class="d-flex justify-content-between align-items-baseline pt-2 mt-1" style="border-top:1px solid #e3e6f0;">
                                <span class="font-weight-bold text-secondary">Total warehouse value</span>
                                <span class="font-weight-bold text-primary" style="white-space:nowrap;">IDR <?= number_format($totalWarehouseValue, 2, ',', '.') ?></span>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Material Inventory Level Card -->
            <div class="col-lg-6 mb-3">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-dropbox mr-1"></i> Color and Additives Stock Levels
                        </h6>
                        <?php
                            $dataNotif = $this->db->where('status', 7)->where_in('categories', [4, 5])->get('stock_material')->result_array();
                            $lowCount = 0;
                            foreach ($dataNotif as $dn) {
                                if ((float)$dn['in_stock'] < (float)$dn['item_desc']) $lowCount++;
                            }
                        ?>
                        <?php if ($lowCount > 0): ?>
                            <span class="badge badge-pill badge-danger"><?= $lowCount ?> low</span>
                        <?php else: ?>
                            <span class="badge badge-pill badge-success">All OK</span>
                        <?php endif; ?>
                    </div>

                    <!-- scrollable body -->
                    <div class="card-body p-0" style="max-height:360px; overflow-y:auto;">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light" style="position:sticky;top:0;z-index:1;">
                            <tr>
                                <th class="pl-3">Item</th>
                                <th class="text-right">Stock</th>
                                <th class="text-right">Min</th>
                                <th class="text-center">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            usort($dataNotif, function($a, $b) {
                                $pctA = (float)$a['item_desc'] > 0 ? (float)$a['in_stock'] / (float)$a['item_desc'] : 1;
                                $pctB = (float)$b['item_desc'] > 0 ? (float)$b['in_stock'] / (float)$b['item_desc'] : 1;
                                return $pctA <=> $pctB;
                            });
                            foreach ($dataNotif as $dn):
                                $stock = (float)$dn['in_stock'];
                                $minVal = (float)$dn['item_desc'];
                                if ($minVal == 0) continue;
                                $pct = $minVal != 0 ? min(100, round($stock / $minVal * 100)) : 100;
                                if($pct <= 50) { 
                                    $barClass = 'bg-danger';  $badgeClass = 'badge-danger';  $label = 'Critical'; 
                                }
                                else if($pct <= 100){ 
                                    $barClass = 'bg-warning'; $badgeClass = 'badge-warning'; $label = 'Low'; 
                                }
                                else { 
                                    $barClass = 'bg-success'; $badgeClass = 'badge-success'; $label = 'OK'; 
                                }
                            ?>
                            <tr>
                                <td class="pl-3" style="max-width:160px;">
                                <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:500;">
                                    <?= htmlspecialchars($dn['name']) ?>
                                </div>
                                <!-- mini progress bar -->
                                <div class="progress mt-1" style="height:4px;">
                                    <div class="progress-bar <?= $barClass ?>" style="width:<?= $pct ?>%"></div>
                                </div>
                                </td>
                                <td class="text-right align-middle" style="white-space:nowrap;">
                                    <?= number_format($stock, 2, '.', ',') ?> <small class="text-muted"><?= $dn['unit_satuan'] ?></small>
                                </td>
                                <td class="text-right align-middle text-muted" style="white-space:nowrap;">
                                    <?= number_format($minVal, 2, '.', ',') ?> <small><?= $dn['unit_satuan'] ?></small>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge <?= $badgeClass ?>"><?= $label ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer text-muted small py-2 px-3">
                        <?= count($dataNotif) ?> items tracked &nbsp;·&nbsp;
                        <span class="text-danger"><?= $lowCount ?> below minimum</span>
                    </div>
                </div>
            </div>
        </div>
    <!-- Content Row for Customer-->
    <!-- Content Row for Customer-->
    <!-- Content Row for Customer-->
    <?php } else if ($user['role_id'] == 2){ ?>
        <div class="row">
            <div class="col-lg mb-2">
                <h4>Welcome, <span class="text-primary"><?= $user['name'] . '!'; ?></span></h4>
            </div>
        </div>
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <a class="col-lg-4 mb-4" href=" <?= base_url('inventory/gbj_wh') ?>" style="text-decoration:none">
                <div class="card border-left-primary py-1">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-primary mb-1">
                                    Finished Goods Warehouse</div>
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
    <?php } else {
        $userID = $user['id'];
        $temp = 0;
        $temp1 = 0;
        $grandTotal = 0;
        $grandTotalTrans = 0;
        foreach ($dataCart as $cd) :
            if ($cd['status'] == 0) {
                $temp = $temp + $cd['subtotal'];
                $grandTotal = $temp;
            } else if ($cd['status'] == 3) {
                $temp1 = $temp1 + $cd['subtotal'];
                $grandTotalTrans = $temp1;
            } else {
                $grandTotal = $grandTotal;
                $grandTotalTrans = $grandTotalTrans;
            }
        endforeach; ?>

        <div class="row">
            <!-- Cart Card Example -->
            <a href="<?= base_url('customer/cart') ?>" class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Cart</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($grandTotal, 2, ',', '.'); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Transaction History Card -->

            <a href="<?= base_url('customer/history') ?>" class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Transactions History
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($grandTotalTrans, 2, ',', '.'); ?></div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Content Row -->
        <!-- 
        <div class="row">
            Area Chart
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    Card Header - Dropdown
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    Card Body
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    <?php } ?>
</div>
</div>
<!-- End of Main Content -->

<script>
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
        
        window.location.href = '<?= base_url('user/index') ?>?start_date=' + startTimestamp + '&end_date=' + endTimestamp;
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

    new Chart(document.getElementById('inventoryDonut'), {
        type: 'doughnut',
        data: {
            labels: ['Material', 'Production', 'Finished Goods'],
            datasets: [{
            data: [<?= $percentMaterial ?>, <?= $percentProd ?>, <?= $percentGBJ ?>],
            backgroundColor: ['#E74A3B', '#F6C23E', '#1CC88A'],
            borderWidth: 0,
            hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                label: (ctx) => ` ${ctx.label}: ${ctx.parsed.toFixed(1)}%`
                }
            }
            }
        }
    });
        
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