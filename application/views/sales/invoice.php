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
                    <a class="dropdown-item" href="<?= base_url('sales/invoice?start_date=' . $per['start_date'] . '&end_date=' . $per['end_date'] . '&name=' . $per['id'])?>" onclick="select_date($per['id'])"><?= $per['period'];?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="list-group list-group-flush mb-3" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action active" id="list-perInvoice-list" data-toggle="list" href="#list-perInvoice" role="tab" aria-controls="general">Per Invoice</a>
        <a class="list-group-item list-group-item-action" id="list-perItem-list" data-toggle="list" href="#list-perItem" role="tab" aria-controls="backup">Per Item</a>
        <a class="list-group-item list-group-item-action" id="list-raw-list" data-toggle="list" href="#list-raw" role="tab" aria-controls="backup">Raw</a>
    </div>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="list-perInvoice" role="tabpanel" aria-labelledby="list-perInvoice-list">
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
                            <table class="table table-hover" id="table1" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <!-- <th>No</th> -->
                                        <th>Customer</th>
                                        <th>Invoice Number</th>
                                        <th>Date</th>
                                        <th>Delivery Address</th>
                                        <th>Reference</th>
                                        <th>Amount</th>
                                        <th class="text-center">Payment Status</th>
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
                                            <td><?= $items['deliveryTo']; ?></td>
                                            <td><?= $items['description']; ?></td>
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
                                            <td class="text-center">
                                                <?php if($items['is_paid'] == 1){ ?> 
                                                    <p class="mr-3 my-1 text-center">
                                                        <span class="icon text-success">
                                                            <i class="bi bi-currency-dollar"></i>
                                                        </span>
                                                        <span class="text-success">Paid</span>
                                                    </p>
                                                <?php } else { ?> 
                                                    <p class="mr-3 my-1 text-center">
                                                        <span class="icon text-danger">
                                                            <i class="bi bi-currency-dollar"></i>
                                                        </span>
                                                        <span class="text-danger">Unpaid</span>
                                                    </p>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('sales/invoice_detail/') . $items['ref'] ?>" class="badge badge-primary">Invoice Detail</a>
                                                <a href="<?= base_url('sales/createPDF/3/') . $items['ref'] . '/' . $items['name'] . '/' . $items['date'] ?>?>" target="_blank" rel="noopener noreferrer" class="badge badge-success">Preview Invoice</a>
                                            </td>
                                            </tr>
                                        <?php
                                            $before = $items['ref'];
                                            $subtotal = $subtotal + $temp;
                                            $temp = 0;
                                            $tax = 0;
                                            $i++;
                                        } else {
                                        };
                                        ?>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td><strong>Total Sales</strong></td>
                                        <td>IDR <?= number_format($subtotal, 2, ',', '.'); ?></td>
                                        <td colspan="2"></td>
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
        <div class="tab-pane fade" id="list-perItem" role="tabpanel" aria-labelledby="list-perItem-list">
            <?php if ($dataCartperItem != null) {
                $i = 1;
                $temp = 0;
                $temp1 = 0;
                $temp2 = 0;
                $before = '';
                $total_sack = 0;
                $total_weight = 0;
            ?>
            <div class="card rounded border-0 shadow mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table2" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Amount</th>
                                        <th>Sack</th>
                                        <th>Weight</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dataCartperItem as $items) :
                                        if ($before != $items['item_name']) { ?>
                                        <tr>
                                            <td><?= $items['item_name']; ?></td>
                                            <td>
                                                <?php 
                                                    foreach ($dataCartperItem as $amount) :
                                                        if ($amount['item_name'] == $items['item_name']) {
                                                            $temp = $temp + $amount['qty']; 
                                                        } else {
                                                            
                                                        }
                                                    endforeach;
                                                    echo number_format($temp , 2, ',', '.') . ' '. $items['unit']; 
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    foreach ($dataCartperItem as $amount) :
                                                        if ($amount['item_name'] == $items['item_name']) {
                                                            $temp1 = $temp1 + $amount['sack']; 
                                                        } else {
                                                            
                                                        }
                                                    endforeach;
                                                    echo number_format($temp1 , 2, ',', '.') . ' sack'; 
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    foreach ($dataCartperItem as $amount) :
                                                        if ($amount['item_name'] == $items['item_name']) {
                                                            $temp2 = $temp2 + $amount['weight']; 
                                                        } else {
                                                            
                                                        }
                                                    endforeach;
                                                    echo number_format($temp2 , 2, ',', '.') . ' kg'; 
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                            $before = $items['item_name'];
                                            $total_sack = $total_sack + $temp1;
                                            $total_weight = $total_weight + $temp2;
                                            $temp = 0;
                                            $temp1 = 0;
                                            $temp2 = 0;
                                            $i++;
                                    } else {
                                    };
                                    endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="1"></td>
                                        <td class="text-right"><strong>Total</strong></td>
                                        <td><?= number_format($total_sack, 2, ',', '.') . ' sack'; ?></td>
                                        <!-- <td class="text-right"><strong>Total Weight</strong></td> -->
                                        <td><?= number_format($total_weight, 2, ',', '.') . ' kg'; ?></td>
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
        <div class="tab-pane fade" id="list-raw" role="tabpanel" aria-labelledby="list-raw-list">
            <?php if ($dataCart != null) {
                $i = 1;
                $subtotal = 0;
                $total_sack = 0;
                $total_weight = 0;
            ?>
            <div class="card rounded border-0 shadow mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table3" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Invoice</th>
                                        <th>Item Name</th>
                                        <th>Amount</th>
                                        <th>Unit Price</th>
                                        <th>Discount</th>
                                        <th>Subtotal</th>
                                        <th>Sack</th>
                                        <th>Weight</th>
                                        <th>Weight/Pack</th>
                                        <th>Weight/Sack</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dataCart as $items) : ?>
                                        <tr>
                                            <td><?= date('d F Y H:i', $items['date']); ?></td>
                                            <td><?= $items['name']; ?></td>
                                            <td><?= $items['ref']; ?></td>
                                            <td><?= $items['item_name']; ?></td>
                                            <td><?= number_format($items['qty'], 2, ',', '.') . ' ' . $items['unit']; ?></td>
                                            <td><?= number_format($items['price'], 2, ',', '.'); ?></td>
                                            <td><?= number_format($items['discount'], 2, ',', '.'); ?></td>
                                            <td><?= number_format($items['subtotal'], 2, ',', '.'); ?></td>
                                            <td><?= number_format($items['sack'], 2, ',', '.') . ' sack'; ?></td>
                                            <td><?= number_format($items['weight'], 2, ',', '.') . ' kg'; ?></td>
                                            <td>
                                                <?php
                                                    if($items['qty'] != 0){
                                                        $weightPerPack = $items['weight']/$items['qty'];
                                                    } else {
                                                        $weightPerPack = 0;
                                                    }
                                                    echo number_format($weightPerPack, 3, ',', '.') . ' kg'; 
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if($items['sack'] != 0){
                                                        $weightPerSack = $items['weight']/$items['sack'];
                                                    } else {
                                                        $weightPerSack = 0;
                                                    }
                                                    echo number_format($weightPerSack, 3, ',', '.') . ' kg'; 
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                            $before = $items['item_name'];
                                            $subtotal = $subtotal + $items['subtotal'];
                                            $total_sack = $total_sack + $items['sack'];
                                            $total_weight = $total_weight + $items['weight'];
                                            $i++;
                                    endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td class="text-right"><strong>Total</strong></td>
                                        <td><?= number_format($subtotal, 2, ',', '.'); ?></td>
                                        <td><?= number_format($total_sack, 2, ',', '.') . ' sack'; ?></td>
                                        <td><?= number_format($total_weight, 2, ',', '.') . ' kg'; ?></td>
                                        <td colspan="2"></td>
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
</div>

</div>
<!-- /.container-fluid -->

<script>
    var table = $('#table1').DataTable({
        order: [2, 'asc']
    });

    var table = $('#table2').DataTable({
        paging: true,
        columnDefs: [
            {
                targets:[0,1,2,3],
                orderable: true,
                searchable: true
            }
        ]
    });

    var table = $('#table3').DataTable({
        paging: true,
        columnDefs: [
            {
                targets:[0,1,2,3],
                orderable: true,
                searchable: true
            }
        ]
    });
</script>
