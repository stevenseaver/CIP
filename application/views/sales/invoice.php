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
                                    <th>Amount</th>
                                    <th>Delivery Address</th>
                                    <th>Reference</th>
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

<script>
    var table = $('#table1').DataTable({
        order: [2, 'asc']
    });
</script>