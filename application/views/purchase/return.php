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
                    <a class="dropdown-item" href="<?= base_url('purchasing/purchase_return?start_date=' . $per['start_date'] . '&end_date=' . $per['end_date'] . '&name=' . $per['id'])?>" onclick="select_date($per['id'])"><?= $per['period'];?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <p class="h5 text-gray-800">Received Purchase Order</p>
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
                                <th>Supplier</th>
                                <th>Amount</th>
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
                                        <?php $value = $inv_rcv['price'] * $inv_rcv['in_stock'];
                                        $temp = $temp + $value;  ?>
                                        <!-- <td><?= number_format($value, 0, ',', '.') ?></td> -->
                                        <td>
                                            <a href="<?= base_url('purchasing/return_details/') . $inv_rcv['transaction_id'] . '/' . $inv_rcv['supplier'] . '/' . $inv_rcv['date'] ?>" class="badge badge-primary"><i class="bi bi-backspace-fill"> </i>Apply Return Order</a>
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