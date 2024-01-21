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
    <a href="<?= base_url('production/gbj_report') ?>" class="btn btn-white btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left text-dark"></i>
        </span>
        <span class="text text-dark">Back</span>
    </a>

    <a href="<?= base_url('production/pdf_prodReport/') . $getID['transaction_id']?>" target="_blank" class="btn btn-primary btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-file-earmark-pdf"></i>
        </span>
        <span class="text">View PDF</span>
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
        </div>
    </div>

    <!-- prod order table -->
    <div class="table-responsive my-3">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <div class="h5 text-dark">Materials</div>
                <tr>
                    <th>No</th>
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
                    $formula = $ms['outgoing']/($ms['item_desc']*10)
                    ?>
                    <tr>
                        <td><?= $i ?></td>
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
                    <td colspan="2"> </td>
                    <td class="text-right"><strong>Total Weight</strong></td>
                    <?php $totalWeight = $temp_weight; ?>
                    <td class="text-left"><?= $this->cart->format_number($totalWeight, '2', ',', '.'); ?> kg</td>
                    <td class="text-right"><strong>Total Value</strong></td>
                    <?php $total = $temp; ?>
                    <td class="text-right">IDR <?= $this->cart->format_number($total, '2', ',', '.'); ?></td>
                    <td class="text-right"><strong>Cost of Materials</strong></td>
                    <?php $hpp = $total/$temp_weight; ?>
                    <td class="text-right">IDR <?= $this->cart->format_number($hpp, '2', ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <!-- roll table  -->
    <!-- roll table  -->
    <div class="table-responsive my-3">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <div class="h5 text-primary">Rolls</div>
                <tr>
                    <th>No</th>
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
                $percent_waste = 0;
                ?>
                <?php foreach ($rollType as $ms) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= $ms['code'] ?></td>
                        <td><?= $ms['weight'] ?></td>
                        <td><?= $ms['lipatan'] ?></td>
                        <td><?= number_format($ms['incoming'], 2, ',', '.'); ?> kg</td>
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
                    <?php $temp = $temp + $ms['incoming'];
                    $temp_value = $temp_value + $subtotal;
                    $i++;
                    ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="4"> </td>
                    <td class="text-left"><strong>Total Weight</strong></td>
                    <?php $total = $temp; ?>
                    <td class="text-left"><?= $this->cart->format_number($total, '2', ',', '.'); ?> kg</td>
                    <td class="text-right"><strong>Production Value</strong></td>
                    <?php $grandTotal = $temp_value; ?>
                    <td class="text-left">Rp <?= $this->cart->format_number($grandTotal, '2', ',', '.'); ?></td>
                    <td class="text-right"><strong>Process Waste</strong></td>
                    <?php $waste = $temp-$totalWeight;
                    $percent_waste = ($waste / $totalWeight) * 100 ?>
                    <td class="text-left"><?= $this->cart->format_number($waste, '2', ',', '.'); ?> kg or <?= $this->cart->format_number($percent_waste, '2', ',', '.'); ?>%</td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <!-- gbj table -->
    <!-- gbj table -->
    <div class="table-responsive my-3">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <div class="h5 text-success">Finished Goods</div>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Code</th>
                    <th>Pcs per pack</th>
                    <th>Pack per Sack</th>
                    <th>Amount</th>
                    <th>Sack Weight</th>
                    <th>Weight per Pack</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th>Batch</th>
                    <th>Pack Number</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $temp = 0;
                $percent_waste = 0;
                $temp_total = 0;
                ?>
                <?php foreach ($gbjItems as $ms) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= $ms['code'] ?></td>
                        <td><?= number_format($ms['pcsperpack'], 0, ',', '.'); ?> </td>
                        <td><?= number_format($ms['packpersack'], 0, ',', '.'); ?> </td>
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
                        <td><?= $weightPerPack ?></td>
                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                        <td><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><?= $ms['batch'] ?></td>
                        <td><?= $ms['description'] ?></td>
                    </tr>
                    <?php 
                        $temp = $temp + $ms['before_convert'];
                        $temp_total = $temp_total + $subtotal;
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
                    <td colspan="1"> </td>
                    <td class="text-left"><strong>Grand Total</strong></td>
                    <?php $grandTotal = $temp_total; ?>
                    <td class="text-left">IDR <?= number_format($grandTotal, '2', ',', '.'); ?></td>
                    <td class="text-left"><strong>Process Waste</strong></td>
                    <?php $waste = $temp-$totalWeight;
                    $percent_waste = ($waste / $totalWeight) * 100 ?>
                    <td class="text-left"><?= number_format($waste, '2', ',', '.'); ?> kg or <?= number_format($percent_waste, '2', ',', '.'); ?>%</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
