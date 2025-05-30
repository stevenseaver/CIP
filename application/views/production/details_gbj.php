<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <!-- back button -->
    <!-- url : http://localhost/cip/production/index?start_date=1727715600&end_date=1730393999&name=22 -->
    <!-- <a href="<?= base_url('production/') ?>" class="btn btn-white btn-icon-split mb-3"> -->
    <?php 
        $date_to_check = $getID['date'];
        // $current_month = date('m', $date_to_check);
        $current_year = date('Y', $date_to_check);
        $periode_count = $this->db->get_where('periode_counter', ['year =' => $current_year])->result_array();
            
        foreach($periode_count as $per) :
            if ($date_to_check >= $per['start_date'] and $date_to_check <= $per['end_date']){
                $date_ID = $per['id'];
                $start_date = $per['start_date'];
                $end_date = $per['end_date'];
            };
        endforeach;
    ?>

    <a href="<?= base_url('production/gbj_report/index?start_date=' . $start_date . '&end_date=' . $end_date .'&name=' . $date_ID . '') ?>" class="btn btn-white btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left text-dark"></i>
        </span>
        <span class="text text-dark">Back</span>
    </a>

    <a href="<?= base_url('production/add_gbj/') . $po_id?>" class="btn btn-light border-warning btn-icon-split mb-3" rel="noopener noreferrer">
        <span class="icon text-white">
            <i class="bi bi-pencil-fill"></i>
        </span>
        <span class="text">Edit</span>
    </a>

    <a href="<?= base_url('production/pdf_prodReport/') . $getID['transaction_id']?>" target="_blank" class="btn btn-primary btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-file-earmark-pdf"></i>
        </span>
        <span class="text">View PDF</span>
    </a>

    <a href="<?= base_url('production/changeStatus/index?status=') . '2&prodID=' . $getID['transaction_id'] ?>" class="btn btn-info btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-file-earmark-pdf"></i>
        </span>
        <span class="text">Roll Started</span>
    </a>

    <a href="<?= base_url('production/changeStatus/index?status=') . '3&prodID=' . $getID['transaction_id'] ?>" class="btn btn-primary btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-file-earmark-pdf"></i>
        </span>
        <span class="text">Roll Completed</span>
    </a>
    
    <a href="<?= base_url('production/changeStatus/index?status=') . '4&prodID=' . $getID['transaction_id'] ?>" class="btn btn-warning btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-file-earmark-pdf"></i>
        </span>
        <span class="text">Cutting Started</span>
    </a>

    <a href="<?= base_url('production/changeStatus/index?status=') . '5&prodID=' . $getID['transaction_id']?>" class="btn btn-success btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-file-earmark-pdf"></i>
        </span>
        <span class="text">Finished Goods Completed</span>
    </a>

    <a href="<?= base_url('production/changeStatus/index?status=') . '6&prodID=' . $getID['transaction_id']?>" class="btn btn-danger btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-file-earmark-pdf"></i>
        </span>
        <span class="text">Need Attention</span>
    </a>

    <div class="card rounded shadow border-0 mb-3">
        <div class="card-body mb-0">
            <p class="text-dark mb-1">Prod Order Ref : </p>
            <p class="text-dark font-weight-bold"> <?= $getID['transaction_id'] ?></p>
            <p class="text-dark mb-1">Date : </p>
            <p class="text-dark font-weight-bold"> <?= date('d F Y H:i:s', $getID['date']) ?></p>
            <p class="text-dark mb-1">Product : </p>
            <p class="text-dark font-weight-bold"> <?= $getID['product_name'] ?></p>
            <p class="text-dark mb-1">Batch : </p>
            <p class="text-dark font-weight-bold"> <?= $getID['description'] ?></p>
            <p class="text-dark mb-1">Status : </p>
            <?php if($getID['transaction_status'] == 1){ ?>
                <td><p class="badge badge-secondary">Order dibuat</p></td>
            <?php } else if($getID['transaction_status'] == 2){ ?>
                <td><p class="badge badge-info">Mulai roll</p></td>
            <?php } else if($getID['transaction_status'] == 3){ ?>
                <td><p class="badge badge-primary">Roll selesai</p></td>   
            <?php } else if($getID['transaction_status'] == 4){ ?>
                <td><p class="badge badge-warning">Mulai potong</p></td>   
            <?php } else if($getID['transaction_status'] == 5){ ?>
                <td><p class="badge badge-success">Selesai</p></td>   
            <?php } else if($getID['transaction_status'] == 6){ ?>
                <td><p class="badge badge-danger">Butuh perhatian</p></td>   
            <?php }; ?>
        </div>
    </div>

    <!-- prod order table -->
    <div class="table-responsive my-3">
        <table class="table table-hover" id="table1" width="100%" cellspacing="0">
            <thead>
                <div class="h5 text-dark">Materials</div>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Item</th>
                    <th>Code</th>
                    <th>Amount Used</th>
                    <th>Price (IDR)</th>
                    <th class="text-right">Subtotal (IDR)</th>
                    <th>Mix Amount</th>
                    <th>Formula</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $temp = 0;
                $temp_weight= 0;
                ?>
                <?php foreach ($inventory_selected as $ms) : ?>
                    <?php
                    $formula = $ms['outgoing']/($ms['item_desc'])
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= date('d F Y H:i', $ms['date']);?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= $ms['code'] ?></td>
                        <td><?= number_format($ms['outgoing'], 2, ',', '.') . ' ' . $ms['unit_satuan'];; ?></td>
                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                        <?php $subtotal = $ms['outgoing'] * $ms['price'] ?>
                        <td class="text-right"><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><?= $ms['item_desc'] ?></td>
                        <td><?= $formula ?></td>
                    </tr>
                    <?php 
                    $temp = $temp + $subtotal;  
                    if($ms['unit_satuan'] == 'kg') {
                        $temp_weight = $temp_weight + $ms['outgoing'];
                    } else {
                        
                    } ?>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="3"> </td>
                    <td class="text-right"><strong>Total Weight</strong></td>
                    <?php $totalWeight = $temp_weight; ?>
                    <td class="text-left"><?= number_format($totalWeight, '2', ',', '.'); ?> kg</td>
                    <td class="text-right"><strong>Total Value</strong></td>
                    <?php $total = $temp; ?>
                    <td class="text-right">IDR <?= number_format($total, '2', ',', '.'); ?></td>
                    <td class="text-right"><strong>Cost of Materials</strong></td>
                    <?php $hpp = $total/$temp_weight; ?>
                    <td class="text-right">IDR <?= number_format($hpp, '2', ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <!-- roll table  -->
    <!-- roll table  -->
    <div class="table-responsive my-3">
        <table class="table table-hover" id="table2" width="100%" cellspacing="0">
            <thead>
                <div class="h5 text-primary">Rolls</div>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Item</th>
                    <th>Code</th>
                    <th>Weight</th>
                    <th>Gusset</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th>Batch</th>
                    <th>Roll Number</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $temp = 0;
                $temp_value = 0;
                $waste = 0;
                $percent_waste = 0;
                $depretiation = 0;
                $percent_depretiation = 0;

                $data['items'] = $this->db->get_where('settings', ['parameter' => 'process_waste'])->row_array();
                $max_process_waste = $data['items']['value'];
                $data['items'] = $this->db->get_where('settings', ['parameter' => 'max_waste'])->row_array();
                $max_waste = $data['items']['value'];

                ?>
                <?php foreach ($rollType as $ms) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= date('d F Y H:i', $ms['date']);?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= $ms['code'] ?></td>
                        <td><?= $ms['weight'] ?></td>
                        <td><?= $ms['lipatan'] ?></td>
                        <?php if($ms['transaction_desc'] == 'Bulk cut'){ ?>
                            <td class="text-danger">-<?= number_format($ms['outgoing'], 2, ',', '.'); ?> kg</td>
                        <? } else {  ?>
                            <td class="text-primary"><?= number_format($ms['incoming'], 2, ',', '.'); ?> kg</td>
                        <?php }; ?>
                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                        <?php 
                            $subtotal = $ms['incoming'] * $ms['price'];
                        ?>
                        <td><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <!-- <td><?= number_format($ms['price'], 2, ',', '.'); ?></td> -->
                        <!-- <td><input id="materialAmount-<?= $ms['id'] ?>" class="material-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-prodID="<?= $ms['transaction_id'] ?>" value="<?= number_format($ms['incoming'], 2, ',', '.'); ?>"></td> -->
                        <td><?= $ms['batch'] ?></td>
                        <td><?= $ms['transaction_desc'] ?></td>
                        <td>
                            <?php if($ms['status'] != 9) { ?>
                                <badge class="badge badge-danger">Not yet cut</badge>
                            <?php } else { ?>
                                <badge class="badge badge-primary">Already Cut</badge>
                            <?php } ?>    
                        </td>
                    </tr>
                    <?php 
                        $temp = $temp + $ms['incoming'];
                        $temp_value = $temp_value + $subtotal;

                        $avalan = "avalan";
                        $prongkolan = "prongkolan";
                        $avalan_name = "AVALAN ROLL";
                        $prongkolan_name = "PRONGKOLAN ROLL";

                        $sim_av = similar_text($ms['transaction_desc'], $avalan, $percent_av);
                        $sim_prong = similar_text($ms['transaction_desc'], $prongkolan, $percent_prong);

                        if($percent_av > 50 or $percent_prong > 50 or $ms['name'] == $avalan_name or $ms['name'] == $prongkolan_name){
                            $waste = $waste + $ms['incoming'];
                        };

                        $i++;
                    ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="5"> </td>
                    <td class="text-left"><strong>Total Weight</strong></td>
                    <?php $total = $temp; ?>
                    <td class="text-left"><?= number_format($total, '2', ',', '.'); ?> kg</td>
                    <td class="text-right"><strong>Production Value</strong></td>
                    <?php $grandTotal = $temp_value; ?>
                    <td class="text-left">Rp <?= number_format($grandTotal, '2', ',', '.'); ?></td>
                    <td class="text-right"><strong>Process Waste</strong></td>
                    <?php $depretiation = $temp-$totalWeight;
                        if($totalWeight != 0){ 
                            $percent_depretiation = ($depretiation / $totalWeight) * 100;
                        } else { ?>
                            <td class="text-left">No data</td>
                        <?php };
                    if ($percent_depretiation <= $max_process_waste) {?>
                        <td class="text-left text-danger"><?= number_format($depretiation, '2', ',', '.'); ?> kg or <?= number_format($percent_depretiation, '2', ',', '.'); ?>%</td>
                    <?php } else { ?>
                         <td class="text-left text-success"><?= number_format($depretiation, '2', ',', '.'); ?> kg or <?= number_format($percent_depretiation, '2', ',', '.'); ?>%</td>
                    <?php }?>
                </tr>
                <tr class="align-items-center">
                    <td colspan="5"> </td>
                    <td class="text-left"><strong>Net Roll Weight</strong></td>
                    <?php $net_weight = $total - $waste; ?>
                    <td class="text-left text-primary"><?= number_format($net_weight, '2', ',', '.'); ?> kg</td>
                    <td colspan="2"> </td>
                    <td class="text-right"><strong>Extrusion Waste</strong></td>
                    <?php 
                        if($totalWeight != 0){ 
                            $percent_waste = ($waste / $totalWeight) * 100; 
                        } else { ?>
                           <td class="text-left">No data</td>
                        <?php };
                    if ($percent_waste >= $max_waste) {?>
                        <td class="text-left text-danger"><?= number_format($waste, '2', ',', '.'); ?> kg or <?= number_format($percent_waste, '2', ',', '.'); ?>%</td>
                    <?php } else { ?>
                        <td class="text-left text-success"><?= number_format($waste, '2', ',', '.'); ?> kg or <?= number_format($percent_waste, '2', ',', '.'); ?>%</td>
                    <?php };?>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <!-- gbj table -->
    <!-- gbj table -->
    <div class="table-responsive my-3">
        <table class="table table-hover" id="table3" width="100%" cellspacing="0">
            <thead>
                <div class="h5 text-success">Finished Goods</div>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Item</th>
                    <th>Code</th>
                    <!-- <th>Pcs per pack</th>
                    <th>Pack per Sack</th> -->
                    <th>Amount</th>
                    <th>Sack Weight</th>
                    <th>Weight per Pack</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th>Batch</th>
                    <th>Pack Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                    $temp = 0;
                    $waste_roll = 0;
                    $waste_plong = 0;
                    $waste_other = 0;
                    $temp_total = 0;
                    $percent_waste = 0;
                    $percent_plong = 0;
                    $percent_other = 0;
                foreach ($gbjItems as $ms) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= date('d F Y H:i', $ms['date']);?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= $ms['code'] ?></td>
                        <!-- <td><?= number_format($ms['pcsperpack'], 0, ',', '.'); ?> </td>
                        <td><?= number_format($ms['packpersack'], 0, ',', '.'); ?> </td> -->
                        <?php if($ms['transaction_status'] != 2){  ?>  
                            <!-- IF trans status is other than 2 -->
                            <td><?= number_format($ms['incoming'], 2, ',', '.'); ?> kg</td>
                        <?php } else { ?>
                            <!-- IF product amount already converted into packs for product cat other than 6 or 7 -->
                            <td><?= number_format($ms['incoming'], 2, ',', '.') .' '. $ms['unit_satuan']; ?></td>
                            <!-- <td><?= number_format($ms['incoming'], 2, ',', '.'); ?> pack</td> -->
                        <?php };
                            $weightPerPack = $ms['before_convert'] / $ms['incoming'];
                            $subtotal = $ms['price'] * $ms['incoming'];
                        ?>
                        <td><?= $ms['before_convert'] . ' kg'?></td>
                        <td><?= number_format($weightPerPack, 4, ',', '.') . ' kg'; ?></td>
                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                        <td><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><?= $ms['batch'] ?></td>
                        <td><?= $ms['description'] ?></td>
                        <td><a data-toggle="modal" data-target="#printDetailsGBJ" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-batch="<?= $ms['batch'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['incoming'] ?>" data-weight="<?= $ms['before_convert'] ?>" data-desc="<?= $ms['description']?>" class="badge badge-primary clickable">Print</a></td>
                    </tr>
                    <?php 
                        $temp = $temp + $ms['before_convert'];
                        $temp_total = $temp_total + $subtotal;
                        
                        $avalan = "avalan roll";
                        $avalan1 = "prongkolan roll";
                        $plong = "plong";
                        $sortir = "sortir";
                        $alas = "alas";
                        $tarik = "tarik";

                        $sim_av = similar_text($ms['description'], $avalan, $percent_av);
                        $sim_prong = similar_text($ms['description'], $avalan1, $percent_prong);
                        $sim_plong = similar_text($ms['description'], $plong, $percent_plong);
                        $sim_sortir = similar_text($ms['description'], $sortir, $percent_sortir);
                        $sim_alas = similar_text($ms['description'], $alas, $percent_alas);
                        $sim_tarik = similar_text($ms['description'], $tarik, $percent_tarik);

                        if($percent_av > 60 or $percent_prong > 60){
                            $waste_roll = $waste_roll + $ms['incoming'];
                        } else if($percent_plong > 60){
                            $waste_plong = $waste_plong + $ms['incoming'];
                        } else if($percent_sortir > 50 or $percent_alas > 50 or $percent_tarik > 50){
                            $waste_other = $waste_other + $ms['incoming'];
                        };

                        $i++;
                    ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="4"> </td>
                    <td class="text-left"><strong>Total Weight</strong></td>
                    <?php $total = $temp; ?>
                    <td class="text-left"><?= number_format($total, '2', ',', '.'); ?> kg</td>
                    <td colspan="1"> </td>
                    <td class="text-left"><strong>Grand Total</strong></td>
                    <?php $grandTotal = $temp_total; ?>
                    <td class="text-left">IDR <?= number_format($grandTotal, '2', ',', '.'); ?></td>
                    <td class="text-left"><strong>Roll Waste</strong></td>
                    <?php
                        if($totalWeight != 0){
                            $percent_waste = ($waste_roll / $totalWeight) * 100;
                            if ($percent_waste >= $max_waste) {?>
                                <td class="text-left text-danger"><?= number_format($waste_roll, '2', ',', '.'); ?> kg or <?= number_format($percent_waste, '2', ',', '.'); ?>%</td>
                            <?php } else { ?>
                                <td class="text-left text-success"><?= number_format($waste_roll, '2', ',', '.'); ?> kg or <?= number_format($percent_waste, '2', ',', '.'); ?>%</td>
                                <?php };
                        } else { ?>
                            <td class="text-left">No data</td>
                        <?php };
                    ?>
                </tr>
                <tr>
                    <td colspan="4"> </td>
                    <td class="text-left"><strong>Net Item Weight</strong></td>
                    <?php $net_weight_gbj = $total - $waste_roll - $waste_plong - $waste_other; ?>
                    <td class="text-left text-primary"><?= number_format($net_weight_gbj, '2', ',', '.'); ?> kg</td>
                    <td colspan="3"> </td>
                    <td class="text-left"><strong>Plong Waste</strong></td>
                    <?php
                        if($total != 0){
                            $percent_plong = ($waste_plong / $total) * 100; ?>
                            <td class="text-left"><?= number_format($waste_plong, '2', ',', '.'); ?> kg or <?= number_format($percent_plong, '2', ',', '.'); ?>%</td>
                        <?php } else {?>
                            <td class="text-left">No data</td>
                        <?php };
                      ?>
                </tr>
                <tr>
                    <td colspan="9"> </td>
                    <td class="text-left"><strong>Other Waste</strong></td>
                    <?php 
                        $data['items'] = $this->db->get_where('settings', ['parameter' => 'other_waste'])->row_array();
                        $max_other_waste = $data['items']['value'];
                        
                        if($total != 0){
                            $percent_other = ($waste_other / $total) * 100;
                            if ($percent_other <= $max_other_waste) {?>
                                <td class="text-left text-success"><?= number_format($waste_other, '2', ',', '.'); ?> kg or <?= number_format($percent_other, '2', ',', '.'); ?>%</td>
                            <?php } else { ?>
                                <td class="text-left text-danger"><?= number_format($waste_other, '2', ',', '.'); ?> kg or <?= number_format($percent_other, '2', ',', '.'); ?>%</td>
                            <?php };
                        } else { ?>
                            <td class="text-left">No data</td>
                        <?php };
                    ?>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal For Print -->
<div class="modal fade" id="printDetailsGBJ" tabindex="-1" role="dialog" aria-labelledby="printDetailsGBJLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printDetailsGBJLabel">Print</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-1">Double check the details.</p>
            <form action="<?= base_url('production/print_ticket_gbj?type=2') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- prod id -->
                        <label for="po_id" class="col-form-label">Production Order ID</label>
                        <input type="text" class="form-control" id="po_id" name="po_id" readonly>
                        <!-- item id -->
                        <!-- <label for="id" class="col-form-label" style="display:none">ID</label>
                        <input type="text" class="form-control" id="id" name="id" style="display:none" readonly> -->
                        <!-- item batch ID -->
                        <label for="batch" class="col-form-label">Batch</label>
                        <input type="text" class="form-control" id="batch" name="batch" readonly>
                        <!-- item name -->
                        <label for="name" class="col-form-label">Item</label>
                        <input type="text" class="form-control" id="name" name="name" readonly>
                        <!-- item net weight -->
                        <label for="weight" class="col-form-label">Net Weight</label>
                        <div class="input-group">
                            <input type="number" step=".01" class="form-control" id="weight" name="weight" value="<?= set_value('amount'); ?>" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                        <!-- item net amount -->
                        <label for="amount" class="col-form-label">Pack Amount</label>
                        <div class="input-group">
                            <input type="number" step=".01" class="form-control" id="amount" name="amount" value="<?= set_value('amount'); ?>" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">pack</span>
                            </div>
                        </div>
                        <!-- item desc -->
                        <label for="desc" class="col-form-label">Description</label>
                        <input type="text" class="form-control" id="desc" name="desc" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Print</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var table1 = $('#table1').DataTable({
        paging: true,
        select: {
            style: 'single'
        },
        columnDefs: [
            {
                targets:[0,1,2,3],
                orderable: true,
                searchable: true
            }
        ]

    });
    var table2 = $('#table2').DataTable({
        paging: true,
        select: {
            style: 'single'
        },
        columnDefs: [
            {
                targets:[0,1,2,3],
                orderable: true,
                searchable: true
            }
        ]

    });
    var table3 = $('#table3').DataTable({
        paging: true,
        select: {
            style: 'single'
        },
        columnDefs: [
            {
                targets:[0,1,2,3],
                orderable: true,
                searchable: true
            }
        ]

    });
</script>