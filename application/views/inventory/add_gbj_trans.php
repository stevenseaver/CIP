<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <a href="<?= base_url('inventory/gbj_wh') ?>" class="btn btn-white btn-icon-split mb-3">
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

    <?php 
        $tokenData = array(
            'token'  => md5(session_id() . time())
        );
        $this->session->set_userdata($tokenData);
        
        $token = $this->session->token;
    ?>
    <form action="<?= base_url('inventory/add_gbj_trans/') . $po_id . '/2/3/' ?>" method="post">
        <div class="row">                       
            <div class="col-lg-6" style="display: none">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="token" class="col-form-label">Token</label>
                    <input type="text" class="form-control mb-1" id="token" name="token" readonly value="<?= $_SESSION['token'] ?>">
                    <?= form_error('token', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
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
                    <input type="date" class="form-control" id="report_date" name="report_date" value="<?= set_value('report_date', $last_date); ?>">
                    <?= form_error('report_date', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5">
                <div class="form-group">
                    <!-- Item categories -->
                    <label for="gbjSelect" class="col-form-label">Item Name</label>
                    <input type="text" class="form-control" id="gbjSelect" name="gbjSelect" readonly value="<?= isset($last_record['name']) ? $last_record['name'] : set_value('gbjSelect'); ?>">
                    <?= form_error('gbjSelect', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <!-- GBJ code -->
                    <label for="code" class="col-form-label">Code</label>
                    <input type="text" class="form-control" id="code" name="code" readonly value="<?= isset($last_record['code']) ? $last_record['code'] : set_value('code'); ?>">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <!-- Material in stock -->
                    <label for="instock" class="col-form-label">In Stock</label>
                    <input type="text" class="form-control" id="instock" name="instock" readonly value="<?= isset($last_record['in_stock']) ? $last_record['in_stock'] : set_value('instock'); ?>">
                </div>
            </div>
            <div class="col-lg-1">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="pcsperpack" class="col-form-label">Packing</label>
                    <input type="text" class="form-control" id="pcsperpack" name="pcsperpack" value="<?= isset($last_record['pcsperpack']) ? $last_record['pcsperpack'] : set_value('pcsperpack'); ?>" readonly>
                    <?= form_error('pcsperpack', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-1">
                <div class="form-group">
                    <!-- Pack per sack -->
                    <label for="packpersack" class="col-form-label">Pack/sack</label>
                    <input type="text" class="form-control" id="packpersack" name="packpersack" readonly value="<?= isset($last_record['packpersack']) ? $last_record['packpersack'] : set_value('packpersack'); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="amount" class="col-form-label">Amount</label>
                    <div class="input-group">
                        <!-- Item code -->
                        <input type="number" step=".01" class="form-control" id="amount" name="amount" value="<?= set_value('amount'); ?>" placeholder="Production amount">
                        <div class="input-group-append">
                            <span id="unit" class="input-group-text"></span>
                        </div>
                    </div>
                    <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="price_gbj" class="col-form-label">Price</label>
                    <div class="input-group">
                        <!-- Item code -->
                        <div class="input-group-prepend">
                            <span class="input-group-text">IDR</span>
                        </div>
                        <input type="text" class="form-control" id="price_gbj" name="price_gbj" value="<?= isset($last_record['price']) ? $last_record['price'] : set_value('price_gbj'); ?>" placeholder="Input COGS per kg">
                    </div>
                    <small>Make sure this value is similar to COGS.</small>
                    <?= form_error('price', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <!-- Batch to be added to batch column for additional desc -->
            <div class="col-lg-4">
                <div class="form-group">
                    <!-- Item batch -->
                    <label for="batch" class="col-form-label">Descriptions</label>
                    <input type="text" class="form-control mb-1" id="batch" name="batch" placeholder="Description of this action" value="<?= isset($last_record['batch']) ? $last_record['batch'] : ''; ?>">
                    <?= form_error('batch', '<small class="text-danger pl-2">', '</small>') ?>
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
                                    <th>Unit</th>
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
                                        <td class="unit"><?= $fs['unit_satuan']; ?></td>
                                        <td class="price"><?= $fs['price']; ?></td>
                                        <td>
                                            <!-- link this with a javascript -->
                                            <a data-dismiss="modal" type="button" class="select-adj-gbj badge badge-primary">Add</a> 
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
                    <th>Amount</th>
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
                        <td><input id="gbjAmount-<?= $ms['id'] ?>" class="gbj-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-prodID="<?= $ms['transaction_id'] ?>" data-cat="<?= $ms['categories']?>" data-status="<?= $ms['transaction_status']?>" value="<?= number_format($ms['incoming'], 2, ',', '.'); ?>"><?= $ms['unit_satuan']?></td>
                        <?php 
                            $subtotal = $ms['price'] * $ms['incoming'];
                            $weightPerPack = $ms['before_convert'] / $ms['incoming'];
                        ?>
                        <td><input id="gbjPrice-<?= $ms['id'] ?>" class="gbj-price text-left form-control number" data-id="<?= $ms['id']; ?>" value="<?= number_format($ms['price'], 2, ',', '.'); ?>"></td>
                        <td><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><input id="gbjBatch-<?= $ms['id'] ?>" class="gbj-batch text-left form-control number" data-id="<?= $ms['id']; ?>" value="<?= $ms['batch'] ?>"></td>
                        <td><input id="gbjDesc-<?= $ms['id'] ?>" class="gbj-desc text-left form-control" data-id="<?= $ms['id']; ?>" value="<?= $ms['description']; ?>"></td>
                        <td>
                            <a data-toggle="modal" data-target="#deleteItemGBJ" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['incoming'] ?>" data-cat="<?= $ms['categories']?>" data-status="<?= $ms['transaction_status']?>" class="badge badge-danger clickable">Delete</a>
                        </td>
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
        </table>
    </div>
    
    <div class="footer text-right mb-3">
        <a href="<?= base_url('production/gbj_report') ?>" class="btn btn-primary">Save Report</a>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>
    $('.check-bulk').click(function(e){
        let sum = -20;

        $(":checked").each(function(){
            sum = sum + Number($(this).val());
        });

        id = $(this).data('id');
        
        id_check = JSON.stringify(id);
        $.ajax({
            type: 'POST',
            url: '<?= base_url("production/change_to_cut"); ?>', 
            data: {id_check: id_check}, 
            success: function(resp) { 
               
            }
        });

        const code = $(this).data('code');
        const transID = $(this).data('trxid');
        const batch = $(this).data('batch');

        // $('#cut_amount').value("Total Amount is : "+sum+" kg");  
        document.getElementById("roll_item").value = code;
        document.getElementById("trans_id").value = transID;
        document.getElementById("bulk_batch").value = batch;
        document.getElementById("cut_amount").value = sum;
    });

    function undo_status_change(){
        // var id = $(event.relatedTarget).data('id');
        id = $(this).data('id');
        id_check = JSON.stringify(id);

        $.ajax({
            type: 'POST',
            url: '<?= base_url("production/change_to_cut"); ?>', 
            data: {id_check: id_check}, 
            success: function(resp) { 
               alert('Undo change status success');
               console.log(id_check);
            }
        });
    };
</script>

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
            <form action="<?= base_url('inventory/delete_gbj_input') ?>" method="post">
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
    var table3 = $('#table4').DataTable({
        paging: false,
        searchable: true
    });
</script>