<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="h3 text-gray-900"><?= $title ?></div>
        <?php 
            $data['items'] = $this->db->get_where('settings', ['parameter' => 'header_color'])->row_array();
            $data['sales_tax'] = $this->db->get_where('settings', ['parameter' => 'sales_tax'])->row_array();
            $color = $data['items']['value'];
            $sales_tax = $data['sales_tax']['value'];
        ?>
        <!-- button to select period -->
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
                            <a class="dropdown-item" href="<?= base_url('sales/deliveryorder?start_date=' . $per['start_date'] . '&end_date=' . $per['end_date'] . '&name=' . $per['id'])?>" onclick="select_date($per['id'])"><?= $per['period'];?></a>
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
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

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
                                href="<?= base_url('sales/deliveryorder?start_date=' . $month_start . '&end_date=' . $month_end) ?>">
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

    <?php if ($dataCart != null) {
        $i = 1;
        $temp = 0;
        $tax = 0;
        $before = '';
    ?>
        <div class="card rounded border-0 shadow mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-hover" id="table1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <!-- <th>No</th> -->
                                    <th>Customer</th>
                                    <th>Invoice Number</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Delivery Address</th>
                                    <th>Reference</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataCart as $items) : 
                                    if ($before != $items['ref']) { ?>
                                        <!-- <td><?= $i ?></td> -->
                                        <td><?= $items['name']; ?></td>
                                        <td><?= $items['ref']; ?></td>
                                        <td><?= date('d F Y H:i', $items['date']); ?></td>
                                        <td>
                                            <?php 
                                                foreach ($dataCart as $amount) :
                                                    if ($amount['ref'] == $items['ref']) {
                                                        $value = ($amount['price']-$amount['discount']) * $amount['qty'];
                                                        $temp = $temp + $value; 
                                                    } else {
                                                        
                                                    }
                                                endforeach;
                                                if($sales_tax == 0){
                                                    
                                                } else {
                                                    $data['purchase_tax'] = $this->db->get_where('settings', ['parameter' => 'purchase_tax'])->row_array();
                                                    
                                                    $tax = $sales_tax/100 * $temp;
                                                    
                                                    $temp = $temp + $tax;
                                                    
                                                }
                                                echo number_format($temp, 2, ',', '.'); 
                                            ?>
                                        </td>
                                        <td><?= $items['deliveryTo']; ?></td>
                                        <td><?= $items['description']; ?></td>
                                        <!-- <td>
                                            <img class="img-fluid rounded" src="<?= base_url('asset/img/payment/') . $items['img']  ?>" alt="Payment Invoice" style="width: 15rem;">
                                        </td> -->
                                        <td>
                                            <a href="<?= base_url('sales/delivery_detail/') . $items['ref'] ?>" class="badge badge-primary">Delivery Detail</a>
                                            <a href="<?= base_url('sales/sales_status_change/') . $items['ref'] . '/' . '3' ?>" class="badge badge-success">Confirm Delivery</a>
                                        </td>
                                        </tr>
                                    <?php
                                        $before = $items['ref'];
                                        $temp = 0;
                                        $tax = 0;
                                        $i++;
                                    } else {
                                    }
                                    ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <?php
    } else { ?>
        <div class="alert alert-danger" role="alert">There's no transaction! </a></div>
    <?php }
    ?>
</div>

</div>
<!-- /.container-fluid -->

<script>
    var table = $('#table1').DataTable({
        order: [2, 'asc']
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
        
        window.location.href = '<?= base_url('sales/deliveryorder') ?>?start_date=' + startTimestamp + '&end_date=' + endTimestamp;
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