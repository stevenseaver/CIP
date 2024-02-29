<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="h3 text-gray-800"><?= $title ?></div>
        <?php 
            $data['items'] = $this->db->get_where('settings', ['parameter' => 'header_color'])->row_array();
            $color = $data['items']['value'];
        ?>
    
        <div class="dropdown text-center my-2">
            <!-- <button class="btn text-<?= $color?> bi bi-caret-left-fill" onclick="left_click()" type="button">
            </button> -->
            <button class="btn btn-<?= $color?> dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                <a id="periode_show" name="periode_show"><?= $current_periode ?></a>
            </button>
            <!-- <button class="btn text-<?= $color?> bi bi-caret-right-fill" onclick="right_click()" type="button">
            </button> -->
    
            <div class="dropdown-menu">
                <?php $j = 0; 
                foreach($periode as $per) : ?>
                    <a class="dropdown-item" href="<?= base_url('purchasing/purchaseinfo?start_date=' . $per['start_date'] . '&end_date=' . $per['end_date'] . '&name=' . $per['id'])?>" onclick="select_date($per['id'])"><?= $per['period'];?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    
    <!-- show uncompleted purchase order -->
    <!-- <p class="h5 text-gray-800">Standing Purchase Order</p>
    <?php if ($inventory_item != null) {
        $i = 1;
        $temp = 0;
        $before = '';
    ?>
        <div class="card border-left-primary mb-3">
            <div class="row mx-4 my-3">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>PO Number</th>
                                <th>Date</th>
                                <th>Due Date</th>
                                <th>Supplier</th>
                                <th>Document</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            $temp = 0; ?>
                            <?php foreach ($inventory_item as $inv) :
                                if ($before != $inv['transaction_id']) { ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $inv['transaction_id'] ?></td>
                                        <td><?= date('d F Y H:i:s', $inv['date']); ?></td>
                                        <td><?= date('d F Y H:i:s', $inv['date'] + $inv['term'] * 24 * 3600); ?></td>
                                        <td><?= $inv['supplier_name'] ?></td>
                                        <td>
                                            <?php 
                                                foreach ($inventory_item as $amount) :
                                                    if ($amount['transaction_id'] == $inv['transaction_id']) {
                                                        $value = $amount['price'] * $amount['incoming'];
                                                        $temp = $temp + $value; 
                                                    } else {
                                                        
                                                    }
                                                endforeach;
                                                if($inv['tax'] == 0){
                                                    
                                                } else if ($inv['tax'] == 1) {
                                                    $data['purchase_tax'] = $this->db->get_where('settings', ['parameter' => 'purchase_tax'])->row_array();
                                                    $purchase_tax = $data['purchase_tax']['value'];
                                                    
                                                    $tax = $purchase_tax/100 * $temp;
                                                    
                                                    $temp = $temp + $tax;
                                                    
                                                }
                                                echo number_format($temp, 2, ',', '.'); 
                                            ?>
                                            
                                        </td>
                                        <td><?= $inv['description'] ?></td>
                                        <td>
                                            <a href="<?= base_url('purchasing/info_details/') . $inv['transaction_id'] . '/' . $inv['supplier'] . '/' . $inv['date'] ?>" class="badge badge-primary"><i class="bi bi-info-circle-fill"> </i>Details</a>
                                        </td>
                                    </tr>
                                    <?php
                                    $before = $inv['transaction_id'];
                                    $i++;
                                } else {
                                    $value = $inv['price'] * $inv['incoming'];
                                    $temp = $temp + $value;
                                } ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    } else { ?>
        <div class="alert alert-primary mb-3" role="alert">There's no standing purchase order at the moment!</div>
    <?php }
    ?> -->
<!--     
    <p class="h5 text-gray-800">Received Purchase Order</p> -->

    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message_is_paid'); ?>
        </div>
    </div>

    <?php if ($inventory_item_received != null) {
        $i = 1;
        $temp = 0;
        $before = '';
    ?>
        <div class="card border-left-primary mb-3">
            <div class="row mx-4 my-3">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>PO Number</th>
                                <th>Date</th>
                                <th>Due Date</th>
                                <th>Supplier</th>
                                <th>Total Amount</th>
                                <th>Document</th>
                                <th>Payment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            $temp = 0; ?>
                            <?php foreach ($inventory_item_received as $inv_rcv) :
                                if ($before != $inv_rcv['transaction_id']) { ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $inv_rcv['transaction_id'] ?></td>
                                        <td><?= date('d F Y H:i:s', $inv_rcv['date']); ?></td>
                                        <td><?= date('d F Y H:i:s', $inv_rcv['date'] + $inv_rcv['term'] * 24 * 3600); ?></td>
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
                                        <td><?= $inv_rcv['description'] ?></td>
                                        <td><?php 
                                            if ($inv_rcv['is_paid'] == 0) {
                                                echo '<p class="badge badge-warning">Not yet paid</p>';
                                            } else {
                                                echo '<p class="badge badge-success">Paid</p>';
                                            }?>
                                        </td>
                                        <!-- <td><?= number_format($value, 0, ',', '.') ?></td> -->
                                        <td>
                                            <a href="<?= base_url('purchasing/info_details/') . $inv_rcv['transaction_id'] . '/' . $inv_rcv['supplier'] . '/' . $inv_rcv['date'] ?>" class="badge badge-primary"><i class="bi bi-info-circle-fill"> </i>Details</a>
                                            <?php if($inv_rcv['is_paid'] == 1){ 
                                            } else { ?>
                                                <!-- <a href="<?= base_url('purchasing/paid/') . $inv_rcv['transaction_id'] .'/' . $inv_rcv['is_paid']?>" class="badge badge-success"><i class="bi bi-currency-dollar"> </i>Pay</a> -->
                                                <a data-toggle="modal" data-target="#paymentModal" data-po="<?= $inv_rcv['transaction_id']  ?>" class="badge badge-success"><i class="bi bi-currency-dollar"> </i>Pay</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php
                                    $before = $inv_rcv['transaction_id'];
                                    $temp = 0;
                                    $tax = 0;
                                    $i++;
                                } else {
                                } ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    } else { ?>
        <div class="alert alert-primary mb-3" role="alert">There's no received purchase order at the moment!</div>
    <?php }
    ?>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

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
            <form action="<?= base_url('purchasing/paid/') ?>" method="post">
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

<script>
    function left_click() {
        document.getElementById("periode_show").innerHTML = 'LEFT';
    }

    function right_click() {
        document.getElementById("periode_show").innerHTML = 'RIGHT';
    }
</script>