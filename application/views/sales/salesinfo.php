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

        <div class="dropdown text-right align-items-center mb-3">
            <button class="btn btn-<?= $color?> dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                <a id="periode_show" name="periode_show"><?= $current_periode ?></a>
            </button>

            <div class="dropdown-menu">
                <?php $j = 0; 
                foreach($periode as $per) : ?>
                    <a class="dropdown-item" href="<?= base_url('sales/salesinfo?start_date=' . $per['start_date'] . '&end_date=' . $per['end_date'] . '&name=' . $per['id'])?>" onclick="select_date($per['id'])"><?= $per['period'];?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <?php if ($dataCart != null) {
        $i = 1;
        $temp = 0;
        $tax = 0;
        $before = '';
        $subtotal = 0;
    ?>
        <div class="card rounded border-0 shadow mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Customer</th>
                                    <th>Invoice Number</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Delivery Address</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataCart as $items) :
                                    if ($before != $items['ref']) { ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $items['name']; ?></td>
                                        <td><?= $items['ref']; ?></td>
                                        <td><?= date('d F Y H:i', $items['date']); ?></td>
                                        <td>
                                            <?php 
                                                foreach ($dataCart as $amount) :
                                                    if ($amount['ref'] == $items['ref']) {
                                                        $value = $amount['price'] * $amount['qty'];
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
                                        <td>
                                            <?php if($items['status'] == 1){ ?> 
                                                <p class="mr-3 my-1 text-center">
                                                    <span class="icon text-warning mx-2">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </span>
                                                    <span class="text-warning">Confirming</span>
                                                </p>
                                            <?php } else if($items['status'] == 2){ ?> 
                                                <p class="mr-3 my-1 text-center">
                                                    <span class="icon text-primary mx-2">
                                                        <i class="bi bi-truck"></i>
                                                    </span>
                                                    <span class="text-primary">Delivering</span>
                                                </p>
                                            <?php } else if($items['status'] == 3){ ?> 
                                                <p class="mr-3 my-1 text-center">
                                                    <span class="icon text-success mx-2">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </span>
                                                    <span class="text-success">Delivered</span>
                                                </p>
                                            <?php } else if($items['status'] == 4){ ?> 
                                                <p class="mr-3 my-1 text-center">
                                                    <span class="icon text-danger mx-2">
                                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                                    </span>
                                                    <span class="text-danger">Declined</span>
                                                </p>
                                            <?php } ?>  
                                        </td>
                                        <td>
                                            <?php if($items['is_paid'] == 1){ ?> 
                                                <p class="mr-3 my-1 text-center">
                                                    <span class="icon text-success mx-2">
                                                        <i class="bi bi-currency-dollar"></i>
                                                    </span>
                                                    <span class="text-success">Paid</span>
                                                </p>
                                            <?php } else { ?> 
                                                <p class="mr-3 my-1 text-center">
                                                    <span class="icon text-danger mx-2">
                                                        <i class="bi bi-currency-dollar"></i>
                                                    </span>
                                                    <span class="text-danger">Unpaid</span>
                                                </p>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('sales/info_detail/') . $items['ref']?>" class="badge badge-primary"><i class="bi bi-info-circle"> </i>Details</a>
                                            <?php if($items['is_paid'] == 1){ 

                                            } else { ?>
                                                <!-- <a href="<?= base_url('sales/paid/') . $items['ref']?>" class="badge badge-success"><i class="bi bi-currency-dollar"> </i>Pay</a> -->
                                                <a data-toggle="modal" data-target="#paymentModal" data-po="<?= $items['ref']  ?>" class="badge badge-success"><i class="bi bi-currency-dollar"> </i>Pay</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                        $before = $items['ref'];
                                        $subtotal = $subtotal + $temp;
                                        $temp = 0;
                                        $tax = 0;
                                        $i++;
                                } endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td><strong>Total Sales</strong></td>
                                    <td>IDR <?= number_format($subtotal, 2, ',', '.'); ?></td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>
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

<!-- Modal For Delete Data -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Yipikay yay!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">Are you sure this is paid?</p>
            <form action="<?= base_url('sales/paid') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- item id -->
                        <label for="url" class="col-form-label">Invoice ID</label>
                        <input type="text" class="form-control" id="ref_id" name="ref_id" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Pay</button>
                </div>
            </form>
        </div>
    </div>
</div>