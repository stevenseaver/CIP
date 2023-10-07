<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <?php if ($user['role_id'] != 3) { ?>
        <!-- Content Row for Admin, Employee, Internal-->
        <?php 
            $temp = 0;
            $prodOrderCount = $temp;
            $before = '';
            foreach ($prodOrder as $items) :
                if ($before != $items['transaction_id']) {
                    $before = $items['transaction_id'];
                    $temp++;
                } else {
                }
                $prodOrderCount = $temp;
            endforeach;
        ?>
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <a class="col-xl-3 col-md-6 mb-4" href=" <?= base_url('production') ?>" style="text-decoration:none">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Production Order Due</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $prodOrderCount ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-gear-fill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Cust Message -->
            <a class="col-xl-3 col-md-6 mb-4" href=" <?= base_url('contact') ?>" style="text-decoration:none">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
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
            <!-- Earnings (Monthly) Card Example -->
            <a class="col-xl-3 col-md-6 mb-4" href=" <?= base_url('sales') ?>" style="text-decoration:none">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sales Order
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

            <!-- Employee Leave Card -->
            <a href="<?= base_url('hr/index') ?>" class="col-xl-3 col-md-6 mb-4" style="text-decoration:none">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
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
        <!-- Content Row -->
        <div class="row">
            <!-- Content Column -->
            <div class="col-lg-6 mb-4">
                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Inventory Value</h6>
                    </div>
                    <div class="card-body">
                        <a href="<?= base_url('inventory/material_wh')?>" style="text-decoration:none"><p class="font-weight-bold">Material Warehouse <span class="float-right">IDR <?= number_format($materialValue, 2, ',', '.'); ?></span></p></a>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $percentMaterial ?>%" aria-valuenow="<?= $percentMaterial ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <a href="<?= base_url('inventory/prod_wh')?>" style="text-decoration:none"><p class="font-weight-bold">Production Warehouse <span class="float-right">IDR <?= number_format($prodValue, 2, ',', '.'); ?></span></p></a>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $percentProd ?>%" aria-valuenow="<?= $percentProd ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <a href="<?= base_url('inventory/gbj_wh')?>" style="text-decoration:none"><p class="font-weight-bold">Finished Good Warehouse <span class="float-right">IDR <?= number_format($gbjValue, 2, ',', '.'); ?></span></p></a>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $percentGBJ ?>%" aria-valuenow="<?= $percentGBJ ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="font-weight-bold text-primary">Total Warehouse Value <span class="float-right">IDR <?= number_format($totalWarehouseValue, 2, ',', '.'); ?></span></p>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>

        <!-- Content Row for Customer-->
        <!-- Content Row for Customer-->
        <!-- Content Row for Customer-->
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
            } else if ($cd['status'] != 0) {
                $temp1 = $temp1 + $cd['subtotal'];
                $grandTotalTrans = $temp1;
            } else {
                $grandTotal = 0;
                $grandTotalTrans = 0;
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($grandTotal, 0, ',', '.'); ?></div>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($grandTotalTrans, 0, ',', '.'); ?></div>
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