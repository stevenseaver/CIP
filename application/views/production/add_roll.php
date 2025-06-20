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

    <a href="<?= base_url('production/inputRoll/index?start_date=' . $start_date . '&end_date=' . $end_date .'&name=' . $date_ID . '') ?>" class="btn btn-white btn-icon-split mb-3">
        <span class="icon text-dark">
            <i class="bi bi-arrow-left text-dark"></i>
        </span>
        <span class="text text-dark">Back</span>
    </a>

    <!-- Button to add Item -->
    <a href="" class="btn btn-primary btn-icon-split mb-3 mx-1" data-toggle="modal" data-target="#newItem">
        <span class="icon text-white-70">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Item</span>
    </a>

    <a href="" class="btn btn-light btn-icon-split mb-3" data-toggle="collapse" data-target="#addMaterial" aria-expanded="false" aria-controls="addMaterial">
        <span class="icon text-dark">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add Additional Materials</span>
    </a>

    <div class="card rounded shadow border-0 mb-3">
        <div class="card-body mb-0">
            <div class="row">
                <div class="col-lg-6">
                    <p class="text-dark mb-0">Product : </p>
                    <p id="product_name" class="text-dark font-weight-bold mb-0"> 
                        <?= $getID['product_name']; ?>
                        <i type="button" id="editNameButton" class="small text-primary bi bi-pencil-fill"></i>
                    </p>
                    <input style="display:none" id="change_product_name" class="change_prod_name text-left form-control"  data-id="<?= $getID['id']; ?>" value="<?= $getID['product_name']; ?>">
                    <script>
                        const button = document.getElementById('editNameButton');
                        const div = document.getElementById('change_product_name');

                        // define the function to change the HTML content
                        function changeContent() {
                            document.getElementById('change_product_name').style.display = 'block';
                            document.getElementById('product_name').style.display = 'none';
                        }

                        // add event listener to the button
                        button.addEventListener('click', changeContent);
                    </script>
                </div>
                <div class="col-lg-6">
                    <p class="text-dark mb-0">Status : </p>
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
        </div>
    </div>

    <!-- Input aditional materials here -->
    <!-- Input aditional materials here -->
    <div class="collapse" id="addMaterial">
        <div class="card card-body">
            <!-- Button to add Item -->
            <div class="row">
                <div class="col-lg-4">
                    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newMaterial">
                        <span class="icon text-white-50">
                            <i class="bi bi-search"></i>
                        </span>
                        <span class="text">Search Item</span>
                    </a>
                </div>
            </div>

            <!-- Modal for add items -->
            <div class="modal fade" id="newMaterial" tabindex="-1" aria-labelledby="newMaterialLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newMaterialLabel">Add Additional Materials</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table" id="table2" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="display:none">ID</th>
                                            <th>Material Item</th>
                                            <th>Code</th>
                                            <th>Stock</th>
                                            <th>Unit</th>
                                            <th>Unit Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        $temp = 0; ?>
                                        <?php foreach ($material as $fs) : ?>
                                            <tr>
                                                <td style="display:none" class="id"><?= $fs['id'] ?></td>
                                                <td class="name"><?= $fs['name'] ?></td>
                                                <td class="code"><?= $fs['code'] ?></td>
                                                <td class="in_stock"><?= number_format($fs['in_stock'], 2, ',', '.');?></td>
                                                <td class="unit"><?= $fs['unit_satuan']; ?></td>
                                                <td class="price"><?= $fs['price']; ?></td>
                                                <td>
                                                    <a data-dismiss="modal" type="button" class="select-item-prod badge badge-primary">Add</a> 
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="<?= base_url('production/add_item_prod_after_roll/') . $po_id . '/3' ?>" method="post">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="po_id" class="col-form-label">Production Order ID</label>
                    <input type="text" class="form-control mb-1" id="po_id" name="po_id" readonly value="<?= $po_id ?>">
                    <?= form_error('po_id', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <!-- Item categories -->
                            <label for="materialName" class="col-form-label">Material Name</label>
                            <input type="text" class="form-control" id="materialName" name="materialName" readonly value="<?= set_value('materialName'); ?>">
                            <?= form_error('materialName', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-1" style="display:none">
                        <div class="form-group">
                            <!-- Item categories -->
                            <label for="materialSelect" class="col-form-label">ID</label>
                            <input type="text" class="form-control" id="materialSelect" name="materialSelect" readonly value="<?= set_value('materialSelect'); ?>">
                            <?= form_error('materialSelect', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <!-- Item code -->
                            <label for="price" class="col-form-label">Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="currency" class="form-control" id="price" name="price" value="<?= set_value('price'); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <!-- Material in stock -->
                            <label for="stock" class="col-form-label">In Stock</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="stock" name="stock" readonly value="<?= set_value('stock'); ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="unit_instock"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <!-- Item code -->
                            <label for="mat_amount" class="col-form-label">Amount</label>
                            <div class="input-group">
                                <!-- Item code -->
                                <input type="number" step=".01" class="form-control" id="mat_amount" name="mat_amount" value="<?= set_value('mat_amount'); ?>" placeholder="Use amount">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="unit_amount"></span>
                                </div>
                            </div>
                            <?= form_error('mat_amount', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <!-- Item code -->
                            <?php 
                                $date = time();
                                $year = date('y');
                                $week = date('W');

                                $n = 2;
                                $result = bin2hex(random_bytes($n));

                                $tester = $getID['description'];
                                if ($tester != 1){
                                    $batch = $getID['description'];
                                } else {
                                    $batch = $year . $result . $week;
                                }
                            ?>
                            <label for="description" class="col-form-label">Batch ID</label>
                            <input type="text" class="form-control mb-1" id="description" name="description" readonly value="<?= $batch;?>">
                            <?= form_error('description', '<small class="text-danger pl-2">', '</small>') ?>
                            <small>Batch number. Automatically.</small>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <!-- Item code -->
                            <?php 
                                if ($getID['product_name'] != 1){
                                    $product_name = $getID['product_name'];;
                                } else {
                                    $product_name = '';
                                }
                            ?>
                            <label for="product_name" class="col-form-label">Product Name</label>
                            <input type="text" class="form-control mb-1" id="product_name" name="product_name" value="<?= $product_name?>">
                            <?= form_error('product_name', '<small class="text-danger pl-2">', '</small>') ?>
                            <small>Product name. Always input on each material.</small>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <!-- Item code -->
                            <label for="campuran" class="col-form-label">Mixing Formula</label>
                            <input type="text" min="1" max="100" class="form-control mb-1" id="campuran" name="campuran" placeholder="Mix amount">
                            <?= form_error('campuran', '<small class="text-danger pl-2">', '</small>') ?>
                            <small>Formula mixing number (x10 kg), numerical. Mandatory</small>
                        </div>
                    </div>
                </div>

                <input class="btn-add-item btn btn-primary mb-3" type="submit"></input>
                <p class="align-items-center">Data input are automatically saved.</p>
            </form>
        </div>
    </div>

    <form action="<?= base_url('production/add_roll_item/') . $po_id . '/2/2/' ?>" method="post">
        <div class="form-group">
            <!-- Item code -->
            <label for="po_id" class="col-form-label">Production Order ID</label>
            <input type="text" class="form-control mb-1" id="po_id" name="po_id" readonly value="<?= $po_id ?>">
            <?= form_error('po_id', '<small class="text-danger pl-2">', '</small>') ?>
        </div>
        <!-- <div class="row">                       
            <div class="col-lg-6">
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="report_date" class="col-form-label">Date</label>
                    <input type="datetime-local" class="form-control" id="report_date" name="report_date" value="<?= set_value('report_date') ?>">
                    <?= form_error('report_date', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <!-- Item categories -->
                    <label for="rollName" class="col-form-label">Item Name</label>
                    <!-- <input type="text" class="form-control" id="rollName" name="rollName" readonly value="<?= set_value('rollName'); ?>"> -->
                    <input type="text" class="form-control" id="rollName" name="rollName" value="<?= isset($lastRoll['name']) ? $lastRoll['name'] : set_value('rollName'); ?>" readonly>
                    <?= form_error('rollName', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group"> 
                    <!-- Material in stock -->
                    <label for="code" class="col-form-label">Code</label>
                    <input type="text" class="form-control" id="code" name="code" readonly value="<?= isset($lastRoll['code']) ? $lastRoll['code'] : set_value('code'); ?>">
                    <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="weight" class="col-form-label">Weight</label>
                    <input type="text" class="form-control" id="weight" name="weight" value="<?= isset($lastRoll['weight']) ? $lastRoll['weight'] : set_value('weight'); ?>" readonly>
                    <?= form_error('weight', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <!-- Material in stock -->
                    <label for="lipatan" class="col-form-label">Lipatan</label>
                    <input type="text" class="form-control" id="lipatan" name="lipatan" readonly value="<?= isset($lastRoll['lipatan']) ? $lastRoll['lipatan'] : set_value('lipatan'); ?>">
                    <?= form_error('lipatan', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Item net amount -->
                    <label for="gross" class="col-form-label">Gross Amount</label>
                    <div class="input-group">
                        <!-- Item net amount -->
                        <input type="number" step=".01" class="form-control" id="gross" name="gross" value="<?= set_value('gross'); ?>" placeholder="Gross roll weight" onchange="calculate()">
                        <div class="input-group-append">
                            <span class="input-group-text">kg</span>
                        </div>
                    </div>
                    <?= form_error('gross', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Item net amount -->
                    <label for="bobin" class="col-form-label">Bobin Weight</label>
                    <div class="input-group">
                        <!-- Item net amount -->
                        <input type="number" step=".01" class="form-control" id="bobin" name="bobin" value="<?= set_value('bobin'); ?>" placeholder="Bobin used" onchange="calculate()">
                        <div class="input-group-append">
                            <span class="input-group-text">kg</span>
                        </div>
                    </div>
                    <?= form_error('bobin', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Item net amount -->
                    <label for="amount" class="col-form-label">Net Weight</label>
                    <div class="input-group">
                        <!-- Item net amount -->
                        <input type="number" step=".01" class="form-control" id="amount" name="amount" value="<?= set_value('amount'); ?>" placeholder="Amount produced">
                        <div class="input-group-append">
                            <span class="input-group-text">kg</span>
                        </div>
                    </div>
                    <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Item price -->
                    <label for="price" class="col-form-label">Price</label>
                    <div class="input-group">
                        <!-- Item price -->
                        <div class="input-group-prepend">
                            <span class="input-group-text">IDR</span>
                        </div>
                        <input type="text" class="form-control" id="price_roll" name="price_roll" value="<?= isset($lastRoll['price']) ? $lastRoll['price'] : set_value('price'); ?>">
                    </div>
                    <small>Make sure the COGS is similar with the materials cost.</small>
                    <?= form_error('price', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Item batch -->
                    <label for="batch" class="col-form-label">Batch</label>
                    <input type="text" class="form-control mb-1" id="batch" name="batch" value="<?= isset($lastRoll['batch']) ? $lastRoll['batch'] : $getID['description'] . '-' ?>">
                    <?= form_error('batch', '<small class="text-danger pl-2">', '</small>') ?>
                    <small>Batch number YEARrandomWEEK-Extruder Line-Shift. Mandatory to add Extruder Line (ES) and shift (S).</small>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Item roll number -->
                    <label for="roll_no" class="col-form-label">Roll Number/Description</label>
                    <input type="text" class="form-control mb-1" id="roll_no" name="roll_no" placeholder="Input roll description (number, type, etc).." value="<?php 
                        if(isset($lastRoll['transaction_desc'])){
                            if(is_numeric($lastRoll['transaction_desc'])){
                                echo $lastRoll['transaction_desc']+1;
                            } else {
                                echo $lastRoll['transaction_desc'];
                            }
                        } else {
                            echo set_value('transaction_desc'); }
                        ?>">
                    <?= form_error('roll_no', '<small class="text-danger pl-2">', '</small>') ?>
                    <small>Alpha numerical.</small>
                </div>
            </div>
        </div>
        <input class="btn-add-item btn btn-primary mb-3" type="submit"></input>
        <p class="align-items-center">Data input are automatically saved.</p>
    </form>

    <!-- Modal for add items -->
    <div class="modal fade" id="newItem" tabindex="-1" aria-labelledby="newItemLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newItemLabel">Add New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Roll Item</th>
                                        <th>Code</th>
                                        <th>Weight</th>
                                        <th>Folding</th>
                                        <th>In Stock</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    $temp = 0; ?>
                                    <?php foreach ($rollSelect as $fs) : ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td class="name"><?= $fs['name'] ?></td>
                                            <td class="code"><?= $fs['code'] ?></td>
                                            <td class="weight"><?= $fs['weight'];?></td>
                                            <td class="lipatan"><?= $fs['lipatan']; ?></td>
                                            <td class="in_stock"><?= $fs['in_stock']; ?></td>
                                            <td class="price"><?= $fs['price'];  ?></td>
                                            <td>
                                                <!-- link this with a javascript -->
                                                <a data-dismiss="modal" type="button" class="select-item-roll badge badge-primary">Add</a> 
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Material data -->
    <!-- Material data -->
    <div class="table-responsive my-3">
        <table class="table table-hover" id="table0" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <div class="h5 text-primary">Materials</div>
                    <th>No</th>
                    <th>Date</th>
                    <th>Item</th>
                    <th>Amount Used</th>
                    <th>Price (IDR)</th>
                    <th class="text-right">Subtotal (IDR)</th>
                    <th>Mix Amount</th>
                    <th>Formula</th>
                    <th>Used/Mixed</th>
                    <th>Remaining</th>
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
                    $formula = $ms['outgoing']/($ms['item_desc'])
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= date('d F Y H:i', $ms['date']);?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= number_format($ms['outgoing'], 2, ',', '.') . ' ' . $ms['unit_satuan']; ?></td>
                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                        <?php 
                            $subtotal = $ms['outgoing'] * $ms['price'];
                            $remaining = $ms['item_desc'] - $ms['term']; 
                        ?>
                        <td class="text-right"><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><?= $ms['item_desc'] ?></td>
                        <td><?= $formula ?></td>
                        <td><input id="usageAmount-<?= $ms['id'] ?>" class="usage-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-prodID="<?= $ms['transaction_id'] ?>" value="<?= number_format($ms['term'], 2, ',', '.'); ?>"></td>
                        <td><?= $remaining ?></td>
                        <!-- Column term is used so no additional column to check the materials mixing usage -->
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

    <!-- Roll data -->
    <!-- Roll data -->
    <div class="table-responsive my-3">
        <table class="table table-hover" id="table3" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <div class="h5 text-primary">Rolls</div>
                    <th>No</th>
                    <th>Date</th>
                    <th>Item</th>
                    <th>Code</th>
                    <th>Weight</th>
                    <th>Lipatan</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th>Batch</th>
                    <th>Roll Number</th>
                    <th>Action</th>
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

                // $max_process_waste = -0.5; //change to setting reading
                // $max_waste = 1.5; //change to setting reading
                ?>
                <?php foreach ($rollType as $ms) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td style="width: 110px"><?= date('d F Y H:i', $ms['date']);?></td>
                        <td><?= $ms['name']; ?></td>
                        <td><?= $ms['code']; ?></td>
                        <td><?= $ms['weight']; ?></td>
                        <td><?= $ms['lipatan']; ?></td>
                        <?php if ($ms['status'] != 9){ ?>
                            <td style="width: 100px"><input id="rollAmount-<?= $ms['id'] ?>" class="roll-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-prodID="<?= $ms['transaction_id'] ?>" value="<?= number_format($ms['incoming'], 2, ',', '.'); ?>"></td> 
                        <?php } else {
                            if($ms['transaction_desc'] == 'Bulk cut'){ ?>
                                <td class="text-danger">-<?= number_format($ms['outgoing'], 2, ',', '.'); ?> kg</td>
                            <? } else {  ?>
                                <td class="text-primary"><?= number_format($ms['incoming'], 2, ',', '.'); ?> kg</td>
                            <?php };
                        };
                        $subtotal = $ms['incoming'] * $ms['price'];
                        ?>
                        <td style="width: 110px"><input id="rollPrice-<?= $ms['id'] ?>" class="roll-price text-left form-control" data-id="<?= $ms['id']; ?>" value="<?= number_format($ms['price'], 2, ',', '.'); ?>"></td>
                        <td><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><input id="rollBatch-<?= $ms['id'] ?>" class="roll-batch text-left form-control" data-id="<?= $ms['id']; ?>" value="<?= $ms['batch']; ?>"></td>
                        <td><input id="rollDesc-<?= $ms['id'] ?>" class="roll-desc text-left form-control" data-id="<?= $ms['id']; ?>" value="<?= $ms['transaction_desc']; ?>"></td>
                        <td>
                            <a data-toggle="modal" data-target="#printDetails" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-batch="<?= $ms['batch'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['incoming'] ?>" data-weight="<?= $ms['weight'] ?>" data-lipatan="<?= $ms['lipatan']?>" data-desc="<?= $ms['transaction_desc']?>" class="badge badge-primary clickable">Print</a>
                            <?php if ($ms['status'] != 9){ ?>
                                <a data-toggle="modal" data-target="#deleteItemProdOrder" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['incoming'] ?>" class="badge badge-danger clickable">Delete</a>
                            <?php } else { 

                            }; ?>
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
                    $percent_depretiation = ($depretiation / $totalWeight) * 100;
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
                    <?php $percent_waste = ($waste / $totalWeight) * 100; 
                    if ($percent_waste >= $max_waste) {?>
                        <td class="text-left text-danger"><?= number_format($waste, '2', ',', '.'); ?> kg or <?= number_format($percent_waste, '2', ',', '.'); ?>%</td>
                    <?php } else { ?>
                        <td class="text-left text-success"><?= number_format($waste, '2', ',', '.'); ?> kg or <?= number_format($percent_waste, '2', ',', '.'); ?>%</td>
                    <?php }?>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="footer text-right my-3">
        <!-- <a href="<?= base_url('production/delete_all_po/') . $po_id ?>" class="btn text-danger">Close and delete data</a> -->
        <a data-toggle="modal" data-target="#deleteRollModal" data-po="<?= $po_id ?>" class="btn text-danger">Close and delete data</a>
        <a href="<?= base_url('production/inputRoll') ?>" class="btn btn-primary">Save Order</a>
    </div>
</div>
</div>
<!-- /.container-fluid -->

<!-- End of Main Content -->

<!-- Modal For Print -->
<div class="modal fade" id="printDetails" tabindex="-1" role="dialog" aria-labelledby="printDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printDetailsLabel">Print</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-1">Double check the details.</p>
            <form action="<?= base_url('production/print_ticket?type=2') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- prod id -->
                        <label for="po_id" class="col-form-label">Production Order ID</label>
                        <input type="text" class="form-control" id="po_id" name="po_id" readonly>
                        <!-- item id -->
                        <label for="id" class="col-form-label" style="display:none">ID</label>
                        <input type="text" class="form-control" id="id" name="id" style="display:none" readonly>
                        <!-- item batch ID -->
                        <label for="batch" class="col-form-label">Batch</label>
                        <input type="text" class="form-control" id="batch" name="batch" readonly>
                        <!-- item name -->
                        <label for="name" class="col-form-label">Item</label>
                        <input type="text" class="form-control" id="name" name="name" readonly>
                        <!-- item weight -->
                        <label for="gram" class="col-form-label">Gramature</label>
                        <input type="text" class="form-control" id="gram" name="gram" readonly>
                        <!-- item lipatan -->
                        <label for="guest" class="col-form-label">Gusset</label>
                        <input type="text" class="form-control" id="guset" name="guset" readonly>
                        <!-- item net amount -->
                        <label for="amount" class="col-form-label">Net Amount</label>
                        <div class="input-group">
                        <!-- Item code -->
                            <input type="number" step=".01" class="form-control" id="amount" name="amount" value="<?= set_value('amount'); ?>" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">kg</span>
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

<!-- Modal For Delete Data -->
<div class="modal fade" id="deleteItemProdOrder" tabindex="-1" role="dialog" aria-labelledby="deleteItemProdOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteItemProdOrderLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('production/delete_item_roll') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- prod id -->
                        <label for="url" class="col-form-label">Production Order ID</label>
                        <input type="text" class="form-control" id="delete_po_id" name="delete_po_id" readonly>
                        <!-- item id -->
                        <label for="url" class="col-form-label" style="display:none">ID</label>
                        <input type="text" class="form-control" id="delete_id" name="delete_id" style="display:none" readonly>
                        <!-- item name -->
                        <label for="url" class="col-form-label">Item</label>
                        <input type="text" class="form-control" id="delete_name" name="delete_name" readonly>
                        <!-- item amount -->
                        <label for="url" class="col-form-label">Amount</label>
                        <input type="text" class="form-control" id="delete_amount" name="delete_amount" readonly>
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

<!-- Modal For Delete Data -->
<div class="modal fade" id="deleteRollModal" tabindex="-1" role="dialog" aria-labelledby="deleteRollModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRollModalLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">Closing this window will delete all production order data you've entered. Are you sure?</p>
            <form action="<?= base_url('production/delete_all_roll/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- item id -->
                        <label for="url" class="col-form-label">Production Order ID</label>
                        <input type="text" class="form-control" id="delete_roll_id" name="delete_roll_id" readonly>
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
    function calculate(){
        const gross_weight = document.getElementById('gross').value;
        const bobin_weight = document.getElementById('bobin').value;
        const net_weight = gross_weight - bobin_weight;
        document.getElementById('amount').value = net_weight; 
    }
</script>

<script>
    var table0 = $('#table0').DataTable({
        paging: false
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

    var table2 = $('#table2').DataTable({
        paging: false,
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
        paging: false,
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