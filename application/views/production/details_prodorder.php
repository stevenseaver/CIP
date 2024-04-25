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
    <a href="<?= base_url('production/') ?>" class="btn btn-white btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left text-dark"></i>
        </span>
        <span class="text text-dark">Back</span>
    </a>

    <!-- view pdf PO  -->
    <a href="<?= base_url('production/createPDF/') . $getID['transaction_id']?>" class="btn btn-primary btn-icon-split mb-3" target="_blank" rel="noopener noreferrer">
        <span class="icon text-white-50">
            <i class="bi bi-eye"></i>
        </span>
        <span class="text">View Production Order</span>
    </a>

    <a href="<?= base_url('production/createPDF_prod/') . $po_id?>" class="btn btn-light btn-icon-split mb-3" target="_blank" rel="noopener noreferrer">
        <span class="icon text-white-50">
            <i class="bi bi-eye"></i>
        </span>
        <span class="text">Print for Staff</span>
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

    <div class="table-responsive my-3">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Item</th>
                    <th>Amount Used</th>
                    <th>Unit Price</th>
                    <th class="text-right">Subtotal</th>
                    <th>Mix Amount</th>
                    <th>Formula</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $temp = 0;
                $temp2 = 0;
                $temp3 = 0;
                ?>
                <?php foreach ($inventory_selected as $ms) : ?>
                    <?php
                    if ($ms['transaction_id'] != $po_id) {
                        continue;
                    } else {
                    }
                    $formula = $ms['outgoing']/($ms['item_desc'])
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= date('d F Y H:i:s', $ms['date']); ?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= number_format($ms['outgoing'], 2, ',', '.') . ' ' . $ms['unit_satuan']; ?></td>
                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                        <?php $subtotal = $ms['outgoing'] * $ms['price'] ?>
                        <td class="text-right"><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><?= $ms['item_desc'] ?></td>
                        <td><?= $formula ?></td>
                    </tr>
                    <?php 
                        $temp = $temp + $subtotal;
                        if($ms['categories'] == 1 or $ms['categories'] == 2 or $ms['categories'] == 3){
                            $temp2 = $temp2 + $ms['outgoing'];
                        }
                        else if ($ms['categories'] == 4 or $ms['categories'] == 5){
                            $temp3 = $temp3 + $ms['outgoing'];
                        } else {

                        };
                        $i++;
                endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="2"> </td>
                    <td class="right"><strong>Total Materials</strong></td>
                    <?php 
                        $totalValue = $temp; 
                        $totalWeight = $temp2;
                        $totalWeightOther = $temp3;
                        $grandTotalWeight = $temp2+$temp3;
                        if ($totalWeight != 0) {
                            $hpp = $totalValue/$grandTotalWeight;
                        } else { 
                            $hpp = 0;
                        }; 
                    ?>
                    <td class="text-left"><?= number_format($grandTotalWeight, '2', ',', '.');?> kg</td>
                    <td class=""><strong>Total Value</strong></td>
                    <td class="">IDR <?= number_format($totalValue, '2', ',', '.'); ?></td>
                    <td class=""><strong>Cost of Materials</strong></td>
                    <td class="text-left">IDR <?= number_format($hpp, '2', ',', '.'); ?></td>
                </tr>
                <!-- <tr class="align-items-center">
                    <td colspan="1"> </td>
                    <td class=""><strong>Other Materials</strong></td>
                    <td class="text-left"><?= number_format($totalWeightOther, '2', ',', '.'); ?> kg</td>
                </tr>
                <tr class="align-items-center">
                    <td colspan="1"> </td>
                    <td class=""><strong>Total Materials</strong></td>
                    <td class="text-left"><?= number_format($grandTotalWeight, '2', ',', '.'); ?> kg</td>
                </tr> -->
            </tfoot>
        </table>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->