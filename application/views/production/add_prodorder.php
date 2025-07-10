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

    <a href="<?= base_url('production/index?start_date=' . $start_date . '&end_date=' . $end_date .'&name=' . $date_ID . '') ?>" class="btn btn-white btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left text-dark"></i>
        </span>
        <span class="text text-dark">Back</span>
    </a>

    <!-- Button to add Item -->
    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newItem">
        <span class="icon text-white-50">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Item</span>
    </a>

    <!-- view pdf PO  -->
    <a href="<?= base_url('production/createPDF/') . $po_id?>" class="btn btn-secondary btn-icon-split mb-3" target="_blank" rel="noopener noreferrer">
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
    <?php 
        $tester = $getID['description'];
        if ($tester != 1){ ?>
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
    <?php
        } else {
            
        };
    ?>
    
    <form action="<?= base_url('production/add_item_prod/') . $po_id . '/3' ?>" method="post">
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
                    <input type="date" class="form-control" id="report_date" name="report_date" value="<?= isset($last_date) ? $last_date : set_value('report_date'); ?>">
                    <?= form_error('report_date', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
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
                        <input type="currency" class="form-control" id="price" name="price" value="<?= set_value('price'); ?>">
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
                        <input type="number" step=".001" class="form-control" id="amount" name="amount" value="<?= set_value('amount'); ?>" placeholder="Use amount">
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

                        $tester = $getID['description'];
                        if ($tester != 1){
                            $batch = $getID['description'];
                        } else {
                            $batch = $year . $result . $week;
                        };
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
                    <i type="button" class="small text-primary bi bi-question-circle" data-toggle="tooltip" data-placement="right" title="Selalu isi dengan [NAMA PRODUK][GRAMATUR][LIPATAN]">
                    </i>
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
                    <small>Formula mixing number (total material/10), numerical. Mandatory</small>
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
                                                <!-- link this with a javascript -->
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
    </div>

    <div class="table-responsive my-3">
        <table class="table table-hover" id="table0" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Item</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th class="text-right">Subtotal</th>
                    <th>Mix Amount</th>
                    <th>Formula</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $temp = 0;
                $temp2 = 0;
                $temp3 = 0;
                $temp4 = 0;
                $isTax = 0;
                $tax = 0;
                ?>
                <?php foreach ($material_selected as $ms) : ?>
                    <?php
                    if ($ms['transaction_id'] != $po_id) {
                        continue;
                    } else {
                    }
                    $formula = $ms['outgoing']/($ms['item_desc'])
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= date('d F Y H:i:s', $ms['date']);?></td>
                        <td><?= $ms['name']; ?></td>
                        <!-- <td><?= number_format($ms['outgoing'], 2, ',', '.'); ?></td> -->
                        <td><input id="materialAmount-<?= $ms['id'] ?>" class="material-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-prodID="<?= $ms['transaction_id'] ?>" value="<?= number_format($ms['outgoing'], 2, ',', '.'); ?>"></td>
                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                        <?php $subtotal = $ms['outgoing'] * $ms['price'] ?>
                        <td class="text-right"><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><input id="descAmount-<?= $ms['id'] ?>" class="desc-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-prodID="<?= $ms['transaction_id'] ?>" value="<?= number_format($ms['item_desc'], 1, ',', '.'); ?>"></td>
                        <td><?= $formula ?></td>
                        <td>
                            <a data-toggle="modal" data-target="#deleteItemProdOrder" data-po="<?= $po_id ?>" data-id="<?= $ms['id'] ?>" data-name="<?= $ms['name'] ?>" data-amount="<?= $ms['outgoing'] ?>" class="badge badge-danger clickable">Delete</a>
                        </td>
                    </tr>
                    <?php 
                        $temp = $temp + $subtotal;
                        if($ms['categories'] == 1 or $ms['categories'] == 2 or $ms['categories'] == 3) {
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
                    <td class="right"><strong>Main Materials</strong></td>
                    <?php 
                        $totalWeight = $temp2;
                        $totalValue = $temp; 
                        $totalWeightOther = $temp3;
                        $grandTotalWeight = $temp2+$temp3;
                        if ($totalWeight != 0) {
                            $hpp = $totalValue/$grandTotalWeight;
                        } else { 
                            $hpp = 0;
                        }; 
                    ?>
                    <td class="text-left"><?= number_format($totalWeight, '2', ',', '.'); ?> kg</td>
                    <td class=""><strong>Total Value</strong></td>
                    <td class="">IDR <?= number_format($totalValue, '2', ',', '.'); ?></td>
                    <td class=""><strong>Cost of Materials</strong></td>
                    <td class="text-left">IDR <?= number_format($hpp, '2', ',', '.'); ?></td>
                </tr>
                <tr class="align-items-center">
                    <td colspan="2"> </td>
                    <td class=""><strong>Other Materials</strong></td>
                    <td class="text-left"><?= number_format($totalWeightOther, '2', ',', '.'); ?> kg</td>
                </tr>
                <tr class="align-items-center">
                    <td colspan="2"> </td>
                    <td class=""><strong>Total Materials</strong></td>
                    <td class="text-left"><?= number_format($grandTotalWeight, '2', ',', '.'); ?> kg</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="footer text-right mb-3">
        <!-- <a href="<?= base_url('production/delete_all_po/') . $po_id ?>" class="btn text-danger">Close and delete data</a> -->
        <a data-toggle="modal" data-target="#deletePOModal" data-po="<?= $po_id ?>" class="btn text-danger">Close and delete data</a>
        <a href="<?= base_url('production/') ?>" class="btn btn-primary">Save Order</a>
    </div>
</div>
<!-- /.container-fluid -->
<!-- End of Main Content -->

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
            <form action="<?= base_url('production/delete_item_prod_order') ?>" method="post">
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
<div class="modal fade" id="deletePOModal" tabindex="-1" role="dialog" aria-labelledby="deletePOModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePOModalLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">Closing this window will delete all production order data you've entered. Are you sure?</p>
            <form action="<?= base_url('production/delete_all_prod_order/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- item id -->
                        <label for="url" class="col-form-label">Production Order ID</label>
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
    //js for setting purchase tax input onchange
    function change_purchase_tax($amount){
        window.location.href = "<?= site_url('admin/update_purchase_tax/');?>"+amount;
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    var table0 = $('#table0').DataTable({
        paging: false
    });
</script>