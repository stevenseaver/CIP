<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
            <div id="po-alert" class="d-none"></div>
            <div id="roll-alert" class="d-none"></div>
        </div>
    </div>

    <!-- back button -->
    <?php $periode = getPeriodeByDate($getID['date']); ?>
    <a href="<?= base_url('production/inputRoll/index?' . http_build_query(['start_date' => $periode['start_date'], 'end_date'   => $periode['end_date'], 'name' => $periode['id'],])) ?>" class="btn btn-white btn-icon-split mb-3">
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
        <span class="text">Tambah Item Roll Baru Manual</span>
    </a>

    <!-- <div class="card rounded shadow border-0 mb-3">
        <div class="card-body mb-0">
            <div class="row">
                <div class="col-lg-6"><script>
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
            </div>
        </div>
    </div> -->
    
    <form action="<?= base_url('production/add_roll_general') ?>" method="post">
        <div class="row">                       
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="po_id" class="col-form-label">ID Order Produksi</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="po_id" name="po_id" readonly value="<?= isset($last_po_id) ? $last_po_id : '' ?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="btn-scan">
                                <i class="fa fa-qrcode"></i> Scan
                            </button>
                        </div>
                    </div>
                    <?= form_error('po_id', '<small class="text-danger pl-2">', '</small>') ?>

                    <!-- Scanner container, hidden by default -->
                    <div id="qr-scanner-container" style="display:none; max-width: 25rem;">
                        <div id="qr-reader" style="width:100%;"></div>
                        <button class="btn btn-sm btn-danger mt-1" type="button" id="btn-stop-scan">
                            <i class="fa fa-times"></i> Tutup Scanner
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="report_date" class="col-form-label">Tanggal</label>
                    <input type="date" class="form-control" id="report_date" name="report_date" value="<?= isset($lastRoll['date']) ? $last_date : set_value('report_date'); ?>">
                    <?= form_error('report_date', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <!-- Item categories -->
                    <label for="rollName" class="col-form-label">Nama Roll</label>
                    <!-- <input type="text" class="form-control" id="rollName" name="rollName" readonly value="<?= set_value('rollName'); ?>"> -->
                    <input type="text" class="form-control" id="rollName" name="rollName" value="<?= isset($lastRoll['name']) ? $lastRoll['name'] : set_value('rollName'); ?>" readonly>
                    <?= form_error('rollName', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group"> 
                    <label for="code" class="col-form-label">Kode</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="code" name="code" readonly 
                            value="<?= isset($lastRoll['code']) ? $lastRoll['code'] : set_value('code'); ?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="btn-scan-roll">
                                <i class="fa fa-qrcode"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Roll scanner container -->
                    <div id="qr-roll-scanner-container" style="display:none; max-width:300px;">
                        <div id="qr-roll-reader" style="width:100%;"></div>
                        <button class="btn btn-sm btn-danger mt-1" type="button" id="btn-stop-scan-roll">
                            <i class="fa fa-times"></i> Tutup Scanner
                        </button>
                    </div>
                    <?= form_error('code', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="weight" class="col-form-label">Gramatur</label>
                    <input type="text" class="form-control" id="weight" name="weight" value="<?= isset($lastRoll['weight']) ? $lastRoll['weight'] : set_value('weight'); ?>" readonly>
                    <?= form_error('weight', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="lipatan" class="col-form-label">Lipatan</label>
                    <input type="text" class="form-control" id="lipatan" name="lipatan" readonly value="<?= isset($lastRoll['lipatan']) ? $lastRoll['lipatan'] : set_value('lipatan'); ?>">
                    <?= form_error('lipatan', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Item price -->
                    <label for="price" class="col-form-label">Harga</label>
                    <div class="input-group">
                        <!-- Item price -->
                        <div class="input-group-prepend">
                            <span class="input-group-text">IDR</span>
                        </div>
                        <input type="text" class="form-control" id="price_roll" name="price_roll" readonly value="<?= isset($lastRoll['price']) ? $lastRoll['price'] : set_value('price'); ?>">
                    </div>
                    <?= form_error('price', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-2 mb-2">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body py-3">
                        <div class="form-group mb-0">
                            <label for="gross" class="font-weight-bold text-secondary mb-2">
                                Berat Roll Total
                            </label>

                            <div class="input-group input-group-lg">
                                <input 
                                    type="number"
                                    step=".01"
                                    class="form-control font-weight-bold text-center"
                                    id="gross"
                                    name="gross"
                                    value="<?= set_value('gross'); ?>"
                                    placeholder="0.00"
                                    onchange="calculate()"
                                >

                                <div class="input-group-append">
                                    <span class="input-group-text font-weight-bold">
                                        kg
                                    </span>
                                </div>
                            </div>

                            <?= form_error('gross', '<small class="text-danger d-block mt-1">', '</small>') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 mb-2">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body py-3">
                        <div class="form-group mb-0">
                            <label for="bobin" class="font-weight-bold text-secondary mb-2">
                                Berat Bobin
                            </label>

                            <div class="input-group input-group-lg">
                                <input 
                                    type="number"
                                    step="1"
                                    class="form-control font-weight-bold text-center"
                                    id="bobin"
                                    name="bobin"
                                    value="<?= set_value('bobin'); ?>"
                                    placeholder="0"
                                    onchange="calculate()"
                                >

                                <div class="input-group-append">
                                    <span class="input-group-text font-weight-bold">
                                        gram
                                    </span>
                                </div>
                            </div>

                            <?= form_error('bobin', '<small class="text-danger d-block mt-1">', '</small>') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 mb-2">
                <div class="card shadow border-primary h-100">
                    <div class="card-body py-3">
                        <div class="form-group mb-0">
                            <label for="amount" class="font-weight-bold text-primary mb-2">
                                Berat Neto
                            </label>

                            <div class="input-group input-group-lg">
                                <input 
                                    type="number"
                                    step=".01"
                                    class="form-control font-weight-bold text-center text-primary"
                                    id="amount"
                                    name="amount"
                                    value="<?= set_value('amount'); ?>"
                                    placeholder="0.00"
                                    readonly
                                >

                                <div class="input-group-append">
                                    <span class="input-group-text font-weight-bold bg-primary text-white">
                                        kg
                                    </span>
                                </div>
                            </div>

                            <?= form_error('amount', '<small class="text-danger d-block mt-1">', '</small>') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <!-- Item batch -->
                    <label for="batch" class="col-form-label">Keterangan</label>
                    <input type="text" class="form-control mb-1" id="batch" name="batch" value="<?= isset($lastRoll['batch']) ? $lastRoll['batch'] : $getID['description'] . '-' ?>">
                    <?= form_error('batch', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Item roll number -->
                    <label for="roll_no" class="col-form-label">Deskripsi/Nomor Roll</label>
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

    <!-- Roll data -->
    <!-- Roll data -->
    <div class="table-responsive my-3">
        <table class="table table-hover" id="table1" width="100%" cellspacing="0">
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
                            <td style="width: 100px"><input id="rollAmount-<?= $ms['id'] ?>" class="roll-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-prodid="<?= $ms['transaction_id'] ?>" value="<?= number_format($ms['incoming'], 2, ',', '.'); ?>"></td> 
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
                            <a data-toggle="modal" data-target="#printDetails" data-po="<?= $ms['transaction_id'] ?>" data-id="<?= $ms['id'] ?>" data-batch="<?= $ms['batch'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['incoming'] ?>" data-weight="<?= $ms['weight'] ?>" data-lipatan="<?= $ms['lipatan']?>" data-desc="<?= $ms['transaction_desc']?>" class="badge badge-primary clickable">Print</a>
                            <?php if ($ms['status'] != 9){ ?>
                                <a data-toggle="modal" data-target="#deleteItemProdOrder" data-po="<?= $ms['transaction_id'] ?>" data-id="<?= $ms['id'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['incoming'] ?>" class="badge badge-danger clickable">Delete</a>
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
                </tr>
                <tr class="align-items-center">
                    <td colspan="5"> </td>
                    <td class="text-left"><strong>Net Roll Weight</strong></td>
                    <?php $net_weight = $total - $waste; ?>
                    <td class="text-left text-primary"><?= number_format($net_weight, '2', ',', '.'); ?> kg</td>
                    <td colspan="2"> </td>
                    <td class="text-right"><strong>Extrusion Waste</strong></td>
                    <?php
                    if ($percent_waste >= $max_waste) {?>
                        <td class="text-left text-danger"><?= number_format($waste, '2', ',', '.'); ?> kg</td>
                    <?php } else { ?>
                        <td class="text-left text-success"><?= number_format($waste, '2', ',', '.'); ?> kg</td>
                    <?php }?>
                </tr>
            </tfoot>
        </table>
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
                        <input type="text" class="form-control" id="print_batch" name="batch" readonly>
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
            <form action="<?= base_url('production/delete_item_roll_general_form') ?>" method="post">
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

<script>
    function calculate() {
        const gross_weight = parseFloat(document.getElementById('gross').value) || 0;
        const bobin_weight = parseFloat(document.getElementById('bobin').value) || 0;

        const net_weight = (gross_weight * 1000) - bobin_weight;

        document.getElementById('amount').value = (net_weight / 1000).toFixed(2);
    }

    var table1 = $('#table1').DataTable({
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

    // =====================
    // PO ID SCANNER
    // =====================
    let html5QrCode = null;

    document.getElementById('btn-scan').addEventListener('click', function () {
        const container = document.getElementById('qr-scanner-container');
        container.style.display = 'block';
        this.disabled = true;

        html5QrCode = new Html5Qrcode("qr-reader");

        html5QrCode.start(
            { facingMode: "user" },
            { fps: 10, qrbox: { width: 150, height: 150 } 
            },
            function (decodedText) {
                document.getElementById('po_id').value = decodedText;
                checkPoId(decodedText);
                stopScanner();
            },
            function (errorMessage) {}
        ).then(function () {
            // After camera starts, fix the mirror on front camera
            const video = document.querySelector('#qr-reader video');
            if (video) {
                video.style.transform = 'scaleX(-1)';
            }
        }).catch(function (err) {
            console.error("Camera error:", err);
            alert("Tidak dapat mengakses kamera. Pastikan izin kamera diberikan.");
            stopScanner();
        });
    });

    document.getElementById('btn-stop-scan').addEventListener('click', stopScanner);

    function stopScanner() {
        if (html5QrCode && html5QrCode.isScanning) {
            html5QrCode.stop().then(function () {
                html5QrCode.clear();
                document.getElementById('qr-scanner-container').style.display = 'none';
                document.getElementById('btn-scan').disabled = false;
            }).catch(function (err) {
                console.error("Stop error:", err);
            });
        } else {
            document.getElementById('qr-scanner-container').style.display = 'none';
            document.getElementById('btn-scan').disabled = false;
        }
    }

    // =====================
    // PO ID VALIDATION
    // =====================
    function showPoAlert(type, message) {
        const el = document.getElementById('po-alert');
        el.className = 'alert alert-' + type + ' alert-dismissible fade show mt-1';
        el.innerHTML = message +
            '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>';
    }

    let lastValidPoId = '';

    document.addEventListener('DOMContentLoaded', function () {
        const poInput = document.getElementById('po_id');
        lastValidPoId = poInput.value;

        if (poInput.value) {
            checkPoId(poInput.value);
        }
    });

    function checkPoId(po_id) {
        if (!po_id) return;

        showPoAlert('secondary',
            '<i class="fas fa-spinner fa-spin mr-1"></i> Memeriksa ID <strong>' + po_id + '</strong>...'
        );

        fetch('<?= base_url('production/check_po_id') ?>?po_id=' + encodeURIComponent(po_id))
            .then(response => response.json())
            .then(function (res) {

            console.log(res);
                if (res.status === 'found') {
                    lastValidPoId = po_id;
                    showPoAlert('success',
                        '<i class="fas fa-check-circle mr-1"></i>' +
                        'ID <strong>' + po_id + '</strong> ditemukan' +
                        (res.data.product_name ? ' &mdash; <span>' + res.data.product_name + '</span>' : '')
                    );
                    document.querySelector('input[type="submit"]').disabled = false;
                } else {
                    // restore previous valid PO ID
                    document.getElementById('po_id').value = lastValidPoId;

                    showPoAlert('danger',
                        '<i class="fas fa-times-circle mr-1"></i>' +
                        'ID <strong>"' + po_id + '"</strong> tidak ditemukan di database.'
                    );
                    document.querySelector('input[type="submit"]').disabled = true;
                }
            })
            .catch(function (err) {
                console.error('Check PO error:', err);
                document.getElementById('po_id').value = lastValidPoId;
                showPoAlert('warning',
                    '<i class="fas fa-exclamation-triangle mr-1"></i>' +
                    'Gagal memeriksa ID. Periksa koneksi dan coba lagi.'
                );
            });
    }

    // Also check if po_id already has a value on page load (persisted via flashdata)
    document.addEventListener('DOMContentLoaded', function () {
        const existingPoId = document.getElementById('po_id').value;
        if (existingPoId) checkPoId(existingPoId);
    });
        
    // =====================
    // ROLL ITEM SCANNER
    // =====================             
    let html5QrCodeRoll = null;

    document.getElementById('btn-scan-roll').addEventListener('click', function () {
        const container = document.getElementById('qr-roll-scanner-container');
        container.style.display = 'block';
        this.disabled = true;

        html5QrCodeRoll = new Html5Qrcode("qr-roll-reader");
        html5QrCodeRoll.start(
            { facingMode: "user" },
            { fps: 10, qrbox: { width: 150, height: 150 } },
            function (decodedText) {
                stopRollScanner();
                lookupRollByCode(decodedText);
            },
            function (errorMessage) {}
        ).then(function () {
            const video = document.querySelector('#qr-roll-reader video'); // ← add this block
            if (video) {
                video.style.transform = 'scaleX(-1)';
            }
        }).catch(function (err) {
            console.error("Camera error:", err);
            alert("Tidak dapat mengakses kamera. Pastikan izin kamera diberikan.");
            stopRollScanner();
        });
    });

    document.getElementById('btn-stop-scan-roll').addEventListener('click', stopRollScanner);

    function stopRollScanner() {
        if (html5QrCodeRoll && html5QrCodeRoll.isScanning) {
            html5QrCodeRoll.stop().then(function () {
                html5QrCodeRoll.clear();
                document.getElementById('qr-roll-scanner-container').style.display = 'none';
                document.getElementById('btn-scan-roll').disabled = false;
            }).catch(function (err) {
                console.error("Stop error:", err);
            });
        } else {
            document.getElementById('qr-roll-scanner-container').style.display = 'none';
            document.getElementById('btn-scan-roll').disabled = false;
        }
    }

    // =====================
    // ROLL ITEM VALIDATION
    // =====================
    function showRollAlert(type, message) {
        const el = document.getElementById('roll-alert');
        el.className = 'alert alert-' + type + ' alert-dismissible fade show';
        el.innerHTML = message +
            '<button type="button" class="close" data-dismiss="alert">' +
            '<span>&times;</span>' +
            '</button>';
    }

    function lookupRollByCode(code) {
        fetch('<?= base_url('production/get_roll_by_code') ?>?code=' + encodeURIComponent(code))
            .then(response => response.json())
            .then(function (res) {
                if (res.status === 'found') {
                    const roll = res.data;
                    document.getElementById('rollName').value   = roll.name    ?? '';
                    document.getElementById('code').value       = roll.code    ?? '';
                    document.getElementById('weight').value     = roll.weight  ?? '';
                    document.getElementById('lipatan').value    = roll.lipatan ?? '';
                    document.getElementById('price_roll').value = roll.price   ?? '';

                    showRollAlert('success',
                        '<i class="fas fa-check-circle mr-1"></i>' +
                        '<strong>' + roll.name + '</strong> ditemukan &mdash; Kode: <strong>' + roll.code + '</strong>'
                    );
                } else {
                    document.getElementById('rollName').value   = '';
                    document.getElementById('code').value       = '';
                    document.getElementById('weight').value     = '';
                    document.getElementById('lipatan').value    = '';
                    document.getElementById('price_roll').value = '';

                    showRollAlert('danger',
                        '<i class="fas fa-times-circle mr-1"></i>' +
                        'Roll dengan kode <strong>"' + code + '"</strong> tidak ditemukan.'
                    );
                }
            })
            .catch(function (err) {
                console.error('Lookup error:', err);
                showRollAlert('warning',
                    '<i class="fas fa-exclamation-triangle mr-1"></i>' +
                    'Gagal mengambil data roll. Periksa koneksi dan coba lagi.'
                );
            });
    }
</script>