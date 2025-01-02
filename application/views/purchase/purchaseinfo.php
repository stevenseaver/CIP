<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="h3 text-gray-800"><?= $title ?></div>
        <?php 
            $data['items'] = $this->db->get_where('settings', ['parameter' => 'header_color'])->row_array();
            $color = $data['items']['value'];
        ?>
        <!-- button to select period -->
        <div class="dropdown text-center my-2">
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
                            <a class="dropdown-item" href="<?= base_url('purchasing/purchaseinfo?start_date=' . $per['start_date'] . '&end_date=' . $per['end_date'] . '&name=' . $per['id'])?>" onclick="select_date($per['id'])"><?= $per['period'];?></a>
                        <?php } else {
                        
                        }?>
                    <?php
                    }
                    else { 

                    };
                endforeach; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="list-group list-group-flush mb-3" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action active" id="list-perPurchase-list" data-toggle="list" href="#list-perPurchase" role="tab" aria-controls="general">Per Invoice</a>
        <a class="list-group-item list-group-item-action" id="list-perItem-list" data-toggle="list" href="#list-perItem" role="tab" aria-controls="backup">Per Item</a>
        <a class="list-group-item list-group-item-action" id="list-raw-list" data-toggle="list" href="#list-raw" role="tab" aria-controls="backup">Raw</a>
    </div>
    
    
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message_is_paid'); ?>
        </div>
    </div>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="list-perPurchase" role="tabpanel" aria-labelledby="list-perPurchase-list">
            <?php if ($inventory_item_received != null) {
                $i = 1;
                $temp = 0;
                $before = '';
                $subtotal = 0;
            ?>
            <div class="card border-left-primary mb-3">
                <div class="row mx-4 my-3">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tableInfo" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="display:none">No</th>
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
                                            <td style="display:none"><?= $i ?></td>
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
                                                    // if($inv_rcv['tax'] == 0){
                                                        
                                                    // } else if ($inv_rcv['tax'] == 1) {
                                                    //     $data['purchase_tax'] = $this->db->get_where('settings', ['parameter' => 'purchase_tax'])->row_array();
                                                    //     $purchase_tax = $data['purchase_tax']['value'];
                                                        
                                                    //     $tax = $purchase_tax/100 * $temp;
                                                        
                                                    //     $temp = $temp + $tax;
                                                        
                                                    // }
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
                                        $subtotal = $subtotal + $temp;
                                        $temp = 0;
                                        $tax = 0;
                                        $i++;
                                    } else {
                                    } ?>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-right"><strong>Total Purchase</strong></td>
                                    <td>IDR <?= number_format($subtotal, 2, ',', '.'); ?></td>
                                    <td colspan="4"></td>
                                </tr>
                            </tfoot>
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
        <div class="tab-pane fade" id="list-perItem" role="tabpanel" aria-labelledby="list-perItem-list">
            <?php if ($purchasePerItem != null) {
                $i = 1;
                $temp = 0;
                $temp1 = 0;
                $total_weight = 0;
                $total_item = 0;
                $before = '';
            ?>
            <div class="card rounded border-left-primary shadow mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-hover" id="tableItem" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Amount Purchased</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($purchasePerItem as $items) :
                                        if ($before != $items['name']) { ?>
                                        <tr>
                                            <td><?= $items['name']; ?></td>
                                            <td>
                                                <?php 
                                                    foreach ($purchasePerItem as $amount) :
                                                        if ($amount['name'] == $items['name'] and $amount['unit_satuan'] == 'kg') {
                                                            $temp = $temp + $amount['incoming']; 
                                                        } else if($amount['name'] == $items['name']){
                                                            $temp1 = $temp1 + $amount['incoming']; 
                                                        };
                                                    endforeach;
                                                    if ($items['unit_satuan'] == 'kg') {
                                                        echo number_format($temp , 2, ',', '.') . ' '. $items['unit_satuan']; 
                                                    } else { 
                                                        echo number_format($temp1 , 2, ',', '.') . ' '. $items['unit_satuan']; 
                                                    };
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                            $before = $items['name'];
                                            $total_weight = $total_weight + $temp;
                                            $total_item = $total_item + $temp1;
                                            $temp = 0;
                                            $temp1 = 0;
                                            $i++;
                                    } else {
                                    };
                                    endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right"><strong>Total</strong></td>
                                        <td><?= number_format($total_weight, 2, ',', '.') . ' kg and ' . number_format($total_item, 2, ',', '.') . ' pcs'; ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            } else { ?>
                <div class="alert alert-primary mb-3" role="alert">There's no received purchase order at the moment!</div>
            <?php }
            ?>
        </div>
        <div class="tab-pane fade" id="list-raw" role="tabpanel" aria-labelledby="list-raw-list">
            <?php if ($inventory_item_received != null) {
                $i = 1;
                $temp = 0;
                $temp1 = 0;
                $before = '';
                $subtotal = 0;
            ?>
            <div class="card border-left-primary mb-3">
                <div class="row mx-4 my-3">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tableRaw" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>PO Number</th>
                                    <th>Supplier</th>
                                    <th>Item</th>
                                    <th>Amount</th>
                                    <th>Price</th>
                                    <th>Total Amount</th>
                                    <th>Reference</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                $temp = 0; ?>
                                <?php foreach ($inventory_item_received as $inv_rcv) : ?>
                                    <tr>
                                        <td><?= date('d F Y H:i:s', $inv_rcv['date']); ?></td>
                                        <td><?= $inv_rcv['transaction_id'] ?></td>
                                        <td><?= $inv_rcv['supplier_name'] ?></td>
                                        <td><?= $inv_rcv['name'] ?></td>
                                        <td><?= number_format($inv_rcv['incoming'], 2, ',', '.') . ' ' . $inv_rcv['unit_satuan'];?></td>
                                        <td><?= number_format($inv_rcv['price'], 2, ',', '.'); ?></td>
                                        <td><?= number_format($inv_rcv['incoming'] * $inv_rcv['price'], 2, ',', '.'); ?></td>
                                        <td><?= $inv_rcv['description'] ?></td>
                                        <td><?= $inv_rcv['item_desc'] ?></td>
                                    </tr>
                                <?php
                                    // $before = $inv_rcv['transaction_id'];
                                    if ($inv_rcv['unit_satuan'] == 'kg'){
                                        $temp = $temp + $inv_rcv['incoming'];
                                    } else {
                                        $temp1 = $temp1 + $inv_rcv['incoming'];
                                    }
                                    $subtotal = $subtotal + ($inv_rcv['incoming'] * $inv_rcv['price']);
                                    $i++;
                                endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-right"><strong>Total Purchase</strong></td>
                                    <td><?= number_format($temp, 2, ',', '.') . ' kg'; ?></td>
                                    <td><?= number_format($temp1, 2, ',', '.') . ' pcs'; ?></td>
                                    <td>IDR <?= number_format($subtotal, 2, ',', '.'); ?></td>
                                    <td colspan="4"></td>
                                </tr>
                            </tfoot>
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
    </div>
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
    var table = $('#tableInfo').DataTable({
        order: [2, 'asc']
    });

    var table = $('#tableItem').DataTable({
        paging: true
    });

    var table = $('#tableRaw').DataTable({
        order: [3, 'asc']
    });
</script>