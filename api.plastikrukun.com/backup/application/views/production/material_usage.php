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
                    <a class="dropdown-item" href="<?= base_url('production/usage?start_date=' . $per['start_date'] . '&end_date=' . $per['end_date'] . '&name=' . $per['id'])?>" onclick="select_date($per['id'])"><?= $per['period'];?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="list-group list-group-flush mb-3" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action active" id="list-Material-list" data-toggle="list" href="#list-Material" role="tab" aria-controls="general">Materials Usage</a>
        <a class="list-group-item list-group-item-action" id="list-Roll-list" data-toggle="list" href="#list-Roll" role="tab" aria-controls="backup">Roll Produced</a>
        <a class="list-group-item list-group-item-action" id="list-FG-list" data-toggle="list" href="#list-FG" role="tab" aria-controls="backup">Finished Goods Produced</a>
    </div>
    
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="list-Material" role="tabpanel" aria-labelledby="list-Material-list">
            <?php if ($materialUsage != null) {
                $i = 1;
                $temp = 0;
                $temp1 = 0;
                $total_weight = 0;
                $total_item = 0;
                $subtotal = 0;
                $grandTotal = 0;
                $before = '';
            ?>
            <div class="card rounded border-0 shadow mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Production Usage</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($materialUsage as $items) :
                                        if ($before != $items['name']) { ?>
                                        <tr>
                                            <td><?= $items['name']; ?></td>
                                            <td>
                                                <?php 
                                                    foreach ($materialUsage as $amount) :
                                                        if ($amount['name'] == $items['name'] and $amount['unit_satuan'] == 'kg') {
                                                            $temp = $temp + $amount['outgoing'];
                                                        } else if($amount['name'] == $items['name']){
                                                            $temp1 = $temp1 + $amount['outgoing'];
                                                        };
                                                    endforeach;
                                                    if($temp != 0){
                                                        echo number_format($temp, 2, ',', '.') . ' '. $items['unit_satuan']; 
                                                    } else {
                                                        echo number_format($temp1, 2, ',', '.') . ' '. $items['unit_satuan']; 
                                                    };
                                                ?>
                                            </td>
                                            <?php
                                                $price = $items['price'];
                                                if($temp != 0){
                                                    $subtotal = $temp * $price;
                                                } else {
                                                    $subtotal = $temp1 * $price;
                                                };
                                                $grandTotal = $grandTotal + $subtotal;
                                            ?>
                                            <td><?= number_format($price, 2, ',', '.'); ?></td>
                                            <td><?= number_format($subtotal, 2, ',', '.'); ?></td>
                                        </tr>
                                        <?php
                                            $before = $items['name'];
                                            $total_weight = $total_weight + $temp;
                                            $total_item = $total_item + $temp1;
                                            $temp = 0;
                                            $temp1 = 0;
                                            $subtotal = 0;
                                            $i++;
                                    } else {
                                    };
                                    endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right"><strong>Total</strong></td>
                                        <td><?= number_format($total_weight, 2, ',', '.') . ' kg and ' . number_format($total_item, 2, ',', '.') . ' pcs'; ?></td>
                                        <td></td>
                                        <td><?= 'Rp '. number_format($grandTotal, 2, ',', '.'); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } else { ?>
                <div class="alert alert-danger" role="alert">There's no transaction! </a></div>
            <?php }; ?>
        </div>
        <div class="tab-pane fade" id="list-Roll" role="tabpanel" aria-labelledby="list-Roll-list">
            <?php if ($rollProduced != null) {
                $i = 1;
                $temp = 0;
                $temp1 = 0;
                $total_weight = 0;
                $total_item = 0;
                $subtotal = 0;
                $grandTotal = 0;
                $before = '';
            ?>
            <div class="card rounded border-0 shadow mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table2" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Production Made</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rollProduced as $items) :
                                        //only shown if status == 3 or 9
                                        if ($items['status'] == 1 or $items['status'] == 7) {
                                            continue;
                                        } else {
                                            if ($before != $items['name']) { ?>
                                            <tr>
                                                <td><?= $items['name']; ?></td>
                                                <td>
                                                    <?php 
                                                        foreach ($rollProduced as $amount) :
                                                            if ($amount['name'] == $items['name']) {
                                                                $temp = $temp + $amount['incoming']; 
                                                            } else {
                                                                
                                                            };
                                                        endforeach;
                                                        echo number_format($temp , 2, ',', '.') . ' kg'; 
                                                        ?>
                                                </td>
                                                <?php
                                                    $price = $items['price'];
                                                    $subtotal = $temp * $price;
                                                    $grandTotal = $grandTotal + $subtotal;
                                                ?>
                                                <td><?= number_format($price, 2, ',', '.'); ?></td>
                                                <td><?= number_format($subtotal, 2, ',', '.'); ?></td>
                                            </tr>
                                            <?php
                                                $before = $items['name'];
                                                $total_weight = $total_weight + $temp;
                                                $temp = 0;
                                                $subtotal = 0;
                                                $i++;
                                            } else {
                                            };
                                        };
                                    endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right"><strong>Total</strong></td>
                                        <td><?= number_format($total_weight, 2, ',', '.') . ' kg'; ?></td>
                                        <td></td>
                                        <td><?= 'Rp '. number_format($grandTotal, 2, ',', '.'); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } else { ?>
                <div class="alert alert-danger" role="alert">There's no transaction! </a></div>
            <?php }; ?>
        </div>
        <div class="tab-pane fade" id="list-FG" role="tabpanel" aria-labelledby="list-FG-list">
            <?php if ($fgProduced != null) {
                $i = 1;
                $temp = 0;
                $total_weight = 0;
                $total_item = 0;
                $subtotal = 0;
                $grandTotal = 0;
                $before = '';
            ?>
            <div class="card rounded border-0 shadow mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table1" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Production Made</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($fgProduced as $items) :
                                        if ($before != $items['name']) { ?>
                                            <tr>
                                                <td><?= $items['name']; ?></td>
                                                <td>
                                                    <?php 
                                                        foreach ($fgProduced as $amount) :
                                                            if ($amount['name'] == $items['name']) {
                                                                $temp = $temp + $amount['before_convert']; 
                                                            } else {

                                                            };
                                                        endforeach;
                                                        echo number_format($temp , 2, ',', '.') . ' kg'; 
                                                    ?>
                                                </td>
                                                <?php
                                                    $price = $items['price'];
                                                    $subtotal = $temp * $price;
                                                    $grandTotal = $grandTotal + $subtotal;
                                                ?>
                                                <td><?= number_format($price, 2, ',', '.'); ?></td>
                                                <td><?= number_format($subtotal, 2, ',', '.'); ?></td>
                                            </tr>
                                            <?php
                                                $before = $items['name'];
                                                $total_weight = $total_weight + $temp;
                                                $temp = 0;
                                                $subtotal = 0;
                                                $i++;
                                        } else {
                                        };
                                    endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right"><strong>Total</strong></td>
                                        <td><?= number_format($total_weight, 2, ',', '.') . ' kg'; ?></td>
                                        <td></td>
                                        <td><?= 'Rp '. number_format($grandTotal, 2, ',', '.'); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } else { ?>
                <div class="alert alert-danger" role="alert">There's no transaction! </a></div>
            <?php }; ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>
    function left_click() {
        document.getElementById("periode_show").innerHTML = 'LEFT';
    }

    function right_click() {
        document.getElementById("periode_show").innerHTML = 'RIGHT';
    }

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
</script>