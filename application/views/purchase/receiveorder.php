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
                            <a class="dropdown-item" href="<?= base_url('purchasing/receiveorder?start_date=' . $per['start_date'] . '&end_date=' . $per['end_date'] . '&name=' . $per['id'])?>" onclick="select_date($per['id'])"><?= $per['period'];?></a>
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

    <?php if ($inventory_item != null) {
        $i = 1;
        $temp = 0;
        $before = '';
    ?>
        <div class="card border-left-primary mb-3">
            <div class="row mx-4 my-3">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-hover" id="table1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <!-- <th>No</th> -->
                                    <th>PO Number</th>
                                    <th>Date</th>
                                    <th>Supplier</th>
                                    <th>Amount</th>
                                    <th>Reference</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                $temp = 0;
                                $tax = 0; ?>
                                <?php foreach ($inventory_item as $inv) :
                                    if ($before != $inv['transaction_id']) { ?>
                                        <tr>
                                            <!-- <td><?= $i ?></td> -->
                                            <td><?= $inv['transaction_id'] ?></td>
                                            <td><?= date('d F Y H:i:s', $inv['date']); ?></td>
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
                                            <?php $value = $inv['price'] * $inv['in_stock'];
                                            $temp = $temp + $value;  ?>
                                            <td><?= $inv['description'] ?></td>
                                            <!-- <td><?= number_format($value, 0, ',', '.') ?></td> -->
                                            <td>
                                                <a href="<?= base_url('purchasing/receive_details/') . $inv['transaction_id'] . '/' . $inv['supplier'] . '/' . $inv['date'] ?>" class="badge badge-primary"><i class="bi bi-info-circle-fill"> </i>Details</a>
                                            </td>
                                        </tr>
                                    <?php
                                        $before = $inv['transaction_id'];
                                        $temp = 0;
                                        $tax = 0;
                                        $i++;
                                    } else {
                                    } ?>
                                <?php endforeach; ?>
                            </tbody>
                            <!-- <tfoot>
                            <tr class="text-right align-items-center">
                                <td colspan="7"> </td>
                                <td class="right"><strong>Total</strong></td>
                                <?php $grandTotal = $temp; ?>
                                <td class="right">IDR <?= $this->cart->format_number($grandTotal, '-', ',', '.'); ?></td>
                            </tr>
                        </tfoot> -->
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
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal For Delete Data -->
<div class="modal fade" id="deletePOModal" tabindex="-1" role="dialog" aria-labelledby="deletePOModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePOModalLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">Closing this window will delete all PO data you've entered. Are you sure?</p>
            <form action="<?= base_url('purchasing/delete_all_po/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- item id -->
                        <label for="url" class="col-form-label">PO ID</label>
                        <input type="text" class="form-control" id="delete_po_id" name="delete_po_id" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var table = $('#table1').DataTable({
        order: [1, 'asc']
    });
</script>