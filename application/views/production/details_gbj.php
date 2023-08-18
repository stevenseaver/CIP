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

    <div class="card rounded shadow border-0 mb-3">
        <div class="card-body mb-0">
            <p class="text-dark mb-1">Prod Order Ref : </p>
            <p class="text-dark font-weight-bold"> <?= $getID['transaction_id'] ?></p>
            <p class="text-dark mb-1">Date : </p>
            <p class="text-dark font-weight-bold"> <?= date('d F Y H:i:s', $getID['date']) ?></p>
            <p class="text-dark mb-1">Batch : </p>
            <p class="text-dark font-weight-bold"> <?= $getID['description'] ?></p>
        </div>
    </div>

    <!-- prod order table -->
    <!-- prod order table -->
    <div class="table-responsive my-3">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <div class="h5 text-dark">Materials</div>
                <tr>
                    <th>No</th>
                    <th>Item</th>
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
                    if ($ms['transaction_id'] != $po_id) {
                        continue;
                    } else {
                    }
                    $formula = $ms['outgoing']/($ms['item_desc']*10)
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= number_format($ms['outgoing'], 2, ',', '.') . ' ' . $ms['unit_satuan'];; ?></td>
                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                        <?php $subtotal = $ms['outgoing'] * $ms['price'] ?>
                        <td class="text-right"><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><?= $ms['item_desc'] ?></td>
                        <td><?= $formula ?></td>
                    </tr>
                    <?php $temp = $temp + $subtotal; 
                    $temp_weight = $temp_weight + $ms['outgoing'] ?>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="1"> </td>
                    <td class="text-right"><strong>Total Weight</strong></td>
                    <?php $totalWeight = $temp_weight; ?>
                    <td class="text-left"><?= $this->cart->format_number($totalWeight, '2', ',', '.'); ?> kg</td>
                    <td class="text-right"><strong>Total</strong></td>
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
                    <th>Lipatan</th>
                    <th>Amount</th>
                    <th>Batch</th>
                    <th>Roll Number</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $temp = 0;
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
                        <!-- <td><input id="materialAmount-<?= $ms['id'] ?>" class="material-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-prodID="<?= $ms['transaction_id'] ?>" value="<?= number_format($ms['incoming'], 2, ',', '.'); ?>"></td> -->
                        <td><?= $ms['batch'] ?></td>
                        <td><?= $ms['transaction_desc'] ?></td>
                    </tr>
                    <?php $temp = $temp + $ms['incoming'];
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
                    <td class="text-left"><strong>Waste</strong></td>
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
                    <th>Batch</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $temp = 0;
                $percent_waste = 0;
                ?>
                <?php foreach ($gbjItems as $ms) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= $ms['code'] ?></td>
                        <td><?= number_format($ms['pcsperpack'], 0, ',', '.'); ?> </td>
                        <td><?= number_format($ms['packpersack'], 0, ',', '.'); ?> </td>
                        <!-- <td><?= number_format($ms['incoming'], 2, ',', '.'); ?> kg</td> -->
                        <?php if($ms['transaction_status'] != 2){  ?>  
                            <!-- IF trans status is other than 2 -->
                            <td><?= number_format($ms['incoming'], 2, ',', '.'); ?> kg</td>
                        <?php } else { ?>
                            <!-- IF product amount already converted into packs for product cat other than 6 or 7 -->
                            <td><?= number_format($ms['incoming'], 2, ',', '.'); ?> pack</td>
                        <?php } ?>
                        <!-- <td><input id="materialAmount-<?= $ms['id'] ?>" class="material-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-prodID="<?= $ms['transaction_id'] ?>" value="<?= number_format($ms['incoming'], 2, ',', '.'); ?>"></td> -->
                        <td><?= $ms['batch'] ?></td>
                    </tr>
                    <?php $temp = $temp + $ms['incoming'];
                    $i++;
                    ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="2"> </td>
                    <td class="text-left"><strong>Total Weight</strong></td>
                    <?php $total = $temp; ?>
                    <td class="text-left"><?= $this->cart->format_number($total, '2', ',', '.'); ?> kg</td>
                    <td class="text-left"><strong>Waste</strong></td>
                    <?php $waste = $temp-$totalWeight;
                    $percent_waste = ($waste / $totalWeight) * 100 ?>
                    <td class="text-left"><?= $this->cart->format_number($waste, '2', ',', '.'); ?> kg or <?= $this->cart->format_number($percent_waste, '2', ',', '.'); ?>%</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
