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
        <span class="icon text-dark">
            <i class="bi bi-arrow-left"></i>
        </span>
        <span class="text text-dark">Back</span>
    </a>

    <!-- Button to add Item -->
    <a href="" class="btn btn-primary btn-icon-split mb-3 mx-1" data-toggle="modal" data-target="#newItem">
        <span class="icon text-white-50">
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
                    <p class="text-dark mb-1">Product : </p>
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
                                <table class="table" id="table0" width="100%" cellspacing="0">
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

            <form action="<?= base_url('production/add_item_prod_after_gbj/') . $po_id . '/3' ?>" method="post">
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
                            <label for="amount" class="col-form-label">Amount</label>
                            <div class="input-group">
                                <!-- Item code -->
                                <input type="number" step=".01" class="form-control" id="amount" name="amount" value="<?= set_value('amount'); ?>" placeholder="Use amount">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="unit_amount"></span>
                                </div>
                            </div>
                            <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
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

                                $tester = $IDCheck['description'];
                                if ($tester != 1){
                                    $batch = $IDCheck['description'];
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
                                if ($IDCheck['product_name'] != 1){
                                    $product_name = $IDCheck['product_name'];;
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

    <form action="<?= base_url('production/add_gbj_item/') . $po_id . '/2/2/' ?>" method="post">
        <div class="row">                       
            <div class="col-lg-6">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="po_id" class="col-form-label">Production Order ID</label>
                    <input type="text" class="form-control mb-1" id="po_id" name="po_id" readonly value="<?= $po_id ?>">
                    <?= form_error('po_id', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="report_date" class="col-form-label">Date</label>
                    <?php 
                        $month = date('m');
                        $day = date('d');
                        $year = date('Y');
                        $hour = date('H');
                        $minute = date('m');
                        
                        $today = $day . '/' . $month . '/' . $year . ',' . $hour . ':' . $minute;
                    ?>
                    <input type="datetime-local" class="form-control" id="report_date" name="report_date" value="<?= $today; ?>">
                    <?= form_error('report_date', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5">
            <div class="form-group">
                    <!-- Item categories -->
                    <label for="gbjSelect" class="col-form-label">Item Name</label>
                    <input type="text" class="form-control" id="gbjSelect" name="gbjSelect" readonly value="<?= set_value('gbjSelect'); ?>">
                    <?= form_error('gbjSelect', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <!-- GBJ code -->
                    <label for="code" class="col-form-label">Code</label>
                    <input type="text" class="form-control" id="code" name="code" readonly value="<?= set_value('code'); ?>">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Material in stock -->
                    <label for="instock" class="col-form-label">In Stock</label>
                    <input type="text" class="form-control" id="instock" name="instock" readonly value="<?= set_value('instock'); ?>">
                </div>
            </div>
            <div class="col-lg-1">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="pcsperpack" class="col-form-label">Packing</label>
                    <input type="text" class="form-control" id="pcsperpack" name="pcsperpack" value="<?= set_value('pcsperpack'); ?>" readonly>
                    <?= form_error('pcsperpack', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-1">
                <div class="form-group">
                    <!-- Pack per sack -->
                    <label for="packpersack" class="col-form-label">Pack/sack</label>
                    <input type="text" class="form-control" id="packpersack" name="packpersack" readonly value="<?= set_value('packpersack'); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="amount" class="col-form-label">Amount</label>
                    <div class="input-group">
                        <!-- Item code -->
                        <input type="number" step=".01" class="form-control" id="amount" name="amount" value="<?= set_value('amount'); ?>" placeholder="Production amount">
                        <div class="input-group-append">
                            <span class="input-group-text">kg</span>
                        </div>
                    </div>
                    <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="price_gbj" class="col-form-label">Price</label>
                    <div class="input-group">
                        <!-- Item code -->
                        <div class="input-group-prepend">
                            <span class="input-group-text">IDR</span>
                        </div>
                        <input type="text" class="form-control" id="price_gbj" name="price_gbj" value="<?= set_value('price_gbj'); ?>" placeholder="Input COGS per kg">
                    </div>
                    <small>Make sure this value is similar to COGS.</small>
                    <?= form_error('price', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="batch" class="col-form-label">Batch</label>
                    <input type="text" class="form-control mb-1" id="batch" name="batch" placeholder="Product name/batch number" value="<?= $getRollID['batch'] . '-' ?> ">
                    <?= form_error('batch', '<small class="text-danger pl-2">', '</small>') ?>
                    <small>Batch number YEARrandomWEEK-EL-S-Cutting Line. Mandatory to add Cutting Line (CL).</small>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="pack_no" class="col-form-label">Notes</label>
                    <input type="text" class="form-control mb-1" id="pack_no" name="pack_no" placeholder="Input additional description..">
                    <?= form_error('pack_no', '<small class="text-danger pl-2">', '</small>') ?>
                    <small>Packing description, description, or else. Alpha numerical. Mandatory</small>
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
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Item</th>
                                    <th>Code</th>
                                    <th>Pcs per Pack</th>
                                    <th>Pack per Sack</th>
                                    <th>In Stock</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                $temp = 0; ?>
                                <?php foreach ($gbjSelect as $fs) : ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td class="name"><?= $fs['name'] ?></td>
                                        <td class="code"><?= $fs['code'] ?></td>
                                        <td class="pcsperpack"><?= $fs['pcsperpack'];?></td>
                                        <td class="packpersack"><?= $fs['packpersack']; ?></td>
                                        <td class="in_stock"><?= $fs['in_stock']; ?></td>
                                        <td class="price"><?= $fs['price']; ?></td>
                                        <td>
                                            <!-- link this with a javascript -->
                                            <a data-dismiss="modal" type="button" class="select-item-gbj badge badge-primary">Add</a> 
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

    <div class="table-responsive my-3">
        <table class="table table-hover" id="table1" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <div class="h5 text-dark">Materials</div>
                    <th>No</th>
                    <th>Date</th>
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
                    $formula = $ms['outgoing']/($ms['item_desc'])
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= date('d F Y H:i', $ms['date']);?></td>
                        <td><?= $ms['name'] ?></td>
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
                        
                    }
                    $i++; ?>
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
    
    <div class="table-responsive my-3">
        <table class="table table-hover" id="table2" width="100%" cellspacing="0">
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
                ?>
                <?php foreach ($rollType as $ms) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= date('d F Y H:i', $ms['date']);?></td>
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
                        <!-- <td><input id="materialAmount-<?= $ms['id'] ?>" class="material-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-prodID="<?= $ms['transaction_id'] ?>" value="<?= number_format($ms['incoming'], 2, ',', '.'); ?>"></td> -->
                        <td><?= $ms['batch'] ?></td>
                        <td><?= $ms['transaction_desc'] ?></td>
                        <td>
                            <?php if($ms['status'] != 9) { ?>
                                <a data-toggle="modal" data-target="#cutRollItem" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['incoming'] ?>" class="badge badge-danger clickable">Cut</a>
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
                    <th>Pcs per pack</th>
                    <th>Pack per Sack</th>
                    <th>Amount</th>
                    <th>Weight of Packed Goods</th>
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
                    $plong_percent = 0;
                    $other_percent = 0;
                ?>
                <?php foreach ($gbjItems as $ms) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td style="width: 110px;"><?= date('d F Y H:i', $ms['date']);?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= $ms['code'] ?></td>
                        <td><?= number_format($ms['pcsperpack'], 0, ',', '.'); ?> </td>
                        <td><?= number_format($ms['packpersack'], 0, ',', '.'); ?> </td>
                        <?php if($ms['transaction_status'] != 2){  ?>  
                            <!-- IF trans status is other than 2 -->
                            <td><input id="gbjAmount-<?= $ms['id'] ?>" class="gbj-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-prodID="<?= $ms['transaction_id'] ?>" data-cat="<?= $ms['categories']?>" data-status="<?= $ms['transaction_status']?>" value="<?= number_format($ms['incoming'], 2, ',', '.'); ?>">kg</td>
                        <?php } else { ?>
                            <!-- IF product amount already converted into packs for product cat other than 6 or 7 -->
                            <td><input id="gbjAmount-<?= $ms['id'] ?>" class="gbj-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-prodID="<?= $ms['transaction_id'] ?>" data-cat="<?= $ms['categories']?>" data-status="<?= $ms['transaction_status']?>" value="<?= number_format($ms['incoming'], 2, ',', '.'); ?>"><?= $ms['unit_satuan']?></td>
                        <?php } 
                            $subtotal = $ms['price'] * $ms['incoming'];
                            $weightPerPack = $ms['before_convert'] / $ms['incoming'];
                        ?>
                        <td><?= $ms['before_convert'] . ' kg'?></td>
                        <td><?= $weightPerPack ?></td>
                        <!-- <td><?= number_format($ms['price'], 2, ',', '.'); ?></td> -->
                        <td><input id="gbjPrice-<?= $ms['id'] ?>" class="gbj-price text-left form-control number" data-id="<?= $ms['id']; ?>" value="<?= number_format($ms['price'], 2, ',', '.'); ?>"></td>
                        <td><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><input id="gbjBatch-<?= $ms['id'] ?>" class="gbj-batch text-left form-control number" data-id="<?= $ms['id']; ?>" value="<?= $ms['batch'] ?>"></td>
                        <td><input id="gbjDesc-<?= $ms['id'] ?>" class="gbj-desc text-left form-control" data-id="<?= $ms['id']; ?>" value="<?= $ms['description']; ?>"></td>
                        <?php if($ms['transaction_status'] != 2){  ?>
                            <?php if($ms['categories'] != 6 and $ms['categories'] != 7) { ?>
                            <td>
                                <a data-toggle="modal" data-target="#convertPack" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-name="<?= $ms['name'] ?>" data-code="<?= $ms['code']?>" data-amount="<?= $ms['incoming'] ?>" data-price=<?= $ms['price']?>  class="badge badge-primary clickable">Convert to <?= $ms['unit_satuan']?></a>
                                <a data-toggle="modal" data-target="#printDetailsGBJ" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-batch="<?= $ms['batch'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['incoming'] ?>" data-weight="<?= $ms['before_convert'] ?>" data-desc="<?= $ms['description']?>" class="badge badge-primary clickable">Print</a>
                                <a data-toggle="modal" data-target="#deleteItemGBJ" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['incoming'] ?>" data-cat="<?= $ms['categories']?>" data-status="<?= $ms['transaction_status']?>" class="badge badge-danger clickable">Delete</a>
                            </td>
                            <?php } else { ?>
                                <td>
                                    <a data-toggle="modal" data-target="#printDetailsGBJ" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-batch="<?= $ms['batch'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['incoming'] ?>" data-weight="<?= $ms['before_convert'] ?>" data-desc="<?= $ms['description']?>" class="badge badge-primary clickable">Print</a>
                                    <a data-toggle="modal" data-target="#deleteItemGBJ" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['incoming'] ?>" data-cat="<?= $ms['categories']?>" data-status="<?= $ms['transaction_status']?>" class="badge badge-danger clickable">Delete</a>
                                </td>
                            <?php }
                        } else { ?>
                            <td>
                                <a data-toggle="modal" data-target="#printDetailsGBJ" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-batch="<?= $ms['batch'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['incoming'] ?>" data-weight="<?= $ms['before_convert'] ?>" data-desc="<?= $ms['description']?>" class="badge badge-primary clickable">Print</a>    
                                <a data-toggle="modal" data-target="#deleteItemGBJ" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['incoming'] ?>" data-cat="<?= $ms['categories']?>" data-status="<?= $ms['transaction_status']?>" class="badge badge-danger clickable">Delete</a>
                            </td>
                        <?php } ?>
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
                    <td colspan="6"> </td>
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
                    <td colspan="6"> </td>
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
                    <td colspan="11"> </td>
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
    
    <div class="footer text-right mb-3">
        <a href="<?= base_url('production/gbj_report') ?>" class="btn btn-primary">Save Report</a>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal For Cut Roll Data -->
<div class="modal fade" id="cutRollItem" tabindex="-1" role="dialog" aria-labelledby="cutRollItemLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cutRollItemLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to cut this item. Are you sure?</p>
            <form action="<?= base_url('production/cut_roll') ?>" method="post">
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
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Cut</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal For Convert TO Pack Data Packed Goods -->
<div class="modal fade" id="convertPack" tabindex="-1" role="dialog" aria-labelledby="convertPackLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="convertPackLabel">Convert to Pack</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">Insert number of packs created from this cutting process.</p>
            <form action="<?= base_url('production/convert_to_pack/') . $po_id?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- prod id -->
                        <label for="url" class="col-form-label">Production Order ID</label>
                        <input type="text" class="form-control mb-1" id="po_id" name="po_id" readonly>
                        <!-- item name -->
                        <label for="url" class="col-form-label">Item</label>
                        <input type="text" class="form-control mb-1" id="name" name="name" readonly>
                        <!-- item id -->
                        <label for="url" class="col-form-label" style="display:none">ID</label>
                        <input type="text" class="form-control mb-1" id="id" name="id" style="display:none" readonly>
                        <!-- item code -->
                        <label for="url" class="col-form-label" style="display:none">Code</label>
                        <input type="text" class="form-control mb-1" id="code" name="code" style="display:none" readonly>
                        <!-- kg amount -->
                        <label for="url" class="col-form-label">Weight Amount</label>
                        <input type="text" class="form-control mb-1" id="kg_amount" name="kg_amount" readonly>
                        <!-- kg price -->
                        <label for="url" class="col-form-label">Price per Kg</label>
                        <input type="text" class="form-control mb-1" id="kg_price" name="kg_price" readonly>
                        <!-- pack amount -->
                        <label for="url" class="col-form-label">Pack Amount</label>
                        <input type="text" class="form-control mb-1" id="pack_amount" name="pack_amount">
                        <label for="url" class="small text-dark">Price per Pack = (Weight x Price per kg) / Pack Amount</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Convert</button>
                </div>
            </form>
        </div>
    </div>
</div>


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
            <form action="<?= base_url('production/print_ticket_gbj?type=1') ?>" method="post">
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

<!-- Modal For Delete Data -->
<div class="modal fade" id="deleteItemGBJ" tabindex="-1" role="dialog" aria-labelledby="deleteItemGBJLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteItemGBJLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">You're about to delete this item. Are you sure?</p>
            <form action="<?= base_url('production/delete_gbj_input') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- prod id -->
                        <label for="url" class="col-form-label">Production Order ID</label>
                        <input type="text" class="form-control" id="delete_po_id" name="delete_po_id" readonly>
                        <!-- item id -->
                        <label for="url" class="col-form-label" style="display:none">ID</label>
                        <input type="text" class="form-control" id="delete_id" name="delete_id" style="display:none" readonly>
                        <!-- transaction status -->
                        <label for="url" class="col-form-label" style="display:none">Trans Status</label>
                        <input type="text" class="form-control" id="trans_status" name="trans_status" style="display:none" readonly>
                        <!-- transaction status -->
                        <label for="url" class="col-form-label" style="display:none">Item Category</label>
                        <input type="text" class="form-control" id="item_cat" name="item_cat" style="display:none" readonly>
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

<script>
   var table0 = $('#table0').DataTable({
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