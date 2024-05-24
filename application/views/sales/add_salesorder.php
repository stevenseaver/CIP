    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-900"><?= $title ?></h1>
        <div class="row">
            <div class="col mb-0">
                <?= $this->session->flashdata('message'); ?>
            </div>
        </div>

        <a href="<?= base_url('sales')  ?>" class="btn btn-light btn-icon-split mb-3">
            <span class="icon text-white-50">
                <i class="bi bi-arrow-left"></i>
            </span>
            <span class="text">Back</span>
        </a>

        <div class="card rounded bg-white shadow border-0 mb-3">
            <div class="card-body">
                <p class="text-dark mb-1">Invoice Ref. : </p>
                <p class="text-dark font-weight-bold"> <?= $ref ?></p>
                <?php if ($date) { ?>
                    <p class="text-dark mb-1">Date : </p>
                    <p class="text-dark font-weight-bold"> <?= date('d F Y H:i', $date); ?></p>
                <?php } else { ?>
                <?php } ?>
            </div>
        </div>
        
        <!-- Button to add Item -->
        <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newItem">
            <span class="icon text-white-50">
                <i class="bi bi-bag-plus-fill"></i>
            </span>
            <span class="text">Add New Item</span>
        </a>

        <!-- Button to add customer -->
        <a href="" class="btn btn-light btn-icon-split mb-3" data-toggle="modal" data-target="#newCustomer">
            <span class="icon text-white-50">
                <i class="fas fa-fw fa-user-plus"></i>
            </span>
            <span class="text">Select Customer</span>
        </a>
        
        <!-- Clear cart -->
        <a class="btn btn-danger btn-icon-split mb-3" data-toggle="modal" data-target="#deleteCartItem" data-id="<?= $ref?>" class="btn btn-danger rounded-pill btn-icon-split clickable">
            <span class="icon text-white-50">
                <i class="bi bi-trash"></i>
            </span>
            <span class="text">Clear All<span>
        </a>

        <!-- Item selected to be added -->
        <div>
            <form action="<?= base_url('sales/add_salesorder/' . $ref) ?>" method="post">
                <div class="row">
                    <?php if ($date) { ?>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="so_date" class="col-form-label">Date</label>
                                <input readonly type="text" class="form-control" id="so_date" name="so_date" value="<?= $date ?>">
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="so_date" class="col-form-label">Date</label>
                                <input type="datetime-local" class="form-control" id="so_date" name="so_date" value="<?= set_value('so_date'); ?>">
                                <?= form_error('so_date', '<small class="text-danger pl-2">', '</small>') ?>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <div class="col-lg-3">
                        <div class="form-group">
                            <!-- Customer Name -->
                            <label for="cust_name" class="col-form-label">Customer</label>
                            <?php if ($input_cust_name) { ?>
                                <input type="text" class="form-control" id="cust_name" name="cust_name" readonly value="<?= $input_cust_name; ?>">
                            <?php } else { ?>
                                <input type="text" class="form-control" id="cust_name" name="cust_name" readonly value="<?= set_value('cust_name'); ?>">
                            <?php } ?>
                            <?= form_error('cust_name', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <!-- customer ID -->
                            <label for="cust_id" class="col-form-label">Cust ID</label>
                            <?php if ($input_cust_id) { ?>
                                <input type="text" class="form-control" id="cust_id" name="cust_id" readonly value="<?= $input_cust_id ?>">
                            <?php } else { ?>
                                <input type="text" class="form-control" id="cust_id" name="cust_id" readonly value="<?= set_value('customer_id'); ?>">
                            <?php } ?>
                            <?= form_error('cust_id', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <!-- customer address -->
                            <label for="address" class="col-form-label">Address</label>
                            <?php if ($input_cust_address) { ?>
                                <input type="text" class="form-control" id="address" name="address" readonly value="<?= $input_cust_address ?>">
                            <?php } else { ?>
                                <input type="text" class="form-control" id="address" name="address" readonly value="<?= set_value('address'); ?>">
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <!-- GBJ item name -->
                            <label for="name" class="col-form-label">Item Name</label>
                            <input type="text" class="form-control" id="name" name="name" readonly value="<?= set_value('name'); ?>">
                            <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
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
                            <!-- Item stock -->
                            <label for="instock" class="col-form-label">In Stock</label>
                            <input type="text" class="form-control" id="instock" name="instock" readonly value="<?= set_value('instock'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <!-- Item code -->
                            <label for="pcsperpack" class="col-form-label">Pcs/pack</label>
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
                    <div class="col-lg-2">
                        <div class="form-group">
                            <!-- Item code -->
                            <label for="amount" class="col-form-label">Amount</label>
                            <div class="input-group">
                                <!-- Item code -->
                                <input type="number" step=".01" class="form-control" id="amount" name="amount" value="<?= set_value('amount'); ?>" placeholder="Ordered amount">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="unit" name="unit">unit(s)</span>
                                </div>
                            </div>
                            <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <!-- Item price -->
                            <label for="price" class="col-form-label">Price</label>
                            <input type="text" class="form-control" id="price" name="price" value="<?= set_value('price'); ?>" placeholder="Input price per unit">
                            <?= form_error('price', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <!-- Item price -->
                            <label for="discount" class="col-form-label">Discount</label>
                            <div class="input-group">
                                <!-- Item code -->
                                <input type="number" step=".01" class="form-control" id="percent_discount" name="percent_discount" value="<?= set_value('discount'); ?>" placeholder="Percentage discount" onchange="calculate_nom_discount()">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="unit" name="unit">%</span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="unit" name="unit">IDR</span>
                                </div>
                                <input type="number" step=".01" class="form-control" id="discount" name="discount" value="<?= set_value('discount'); ?>" placeholder="Nominal discount">
                                <?= form_error('discount', '<small class="text-danger pl-2">', '</small>') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <!-- Item price -->
                            <label for="discount" class="col-form-label">Weight</label>
                            <div class="input-group">
                                <!-- Item code -->
                                <input type="number" step=".01" class="form-control" id="bal" name="bal" value="<?= set_value('bal'); ?>" placeholder="Sack amount">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="unit" name="unit">sack</span>
                                </div>
                                <input type="number" step=".01" class="form-control" id="weight" name="weight" value="<?= set_value('weight'); ?>" placeholder="Weight">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="unit" name="unit">Kg</span>
                                </div>
                            </div>
                            <?= form_error('weight', '<small class="text-danger pl-2">', '</small>') ?>
                            <?= form_error('bal', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <!-- Item price -->
                            <label for="notes" class="col-form-label">Reference</label>
                            <i type="button" class="small text-primary bi bi-question-circle" data-toggle="tooltip" data-placement="right" title="Isi dengan nomor dokumen AK">
                            </i>
                            <input type="text" class="form-control" id="notes" name="notes" value="<?= set_value('notes'); ?>">
                            <?= form_error('notes', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                </div>
                <input class="btn-add-item btn btn-primary mb-3" type="submit"></input>
                <p class="align-items-center">Data input are automatically saved.</p>
            </form>
        </div>

        <!-- Data from cart, item added to sales order -->
        <?php if ($dataCart != null) :
            echo form_open('customer/cart'); ?>
            <div class="card rounded border-0 shadow mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="table2" width="100%" cellspacing="0" cellpadding="6">
                            <thead>
                                <tr class="">
                                    <th>No</th>
                                    <th>Item Description</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Discount</th>
                                    <th class="text-right">Subtotal</th>
                                    <th>Weight/Sack</th>
                                    <th>Weight/Pack</th>
                                    <th>Reference</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <?php 
                                $i = 1;
                                $temp = 0;
                                $temp1 = 0; 
                            ?>
                            <tbody>
                                <?php foreach ($dataCart as $items) : ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $items['item_name']; ?></td>
                                        <td style="width: 100px">
                                            <?php if ($items['prod_cat'] != '6' and $items['prod_cat'] != '7') { ?>
                                                <input id="qtyAmount-<?= $items['id']; ?>" class="input-qty-so text-center form-control" data-item="<?= $items['item_name']; ?>" data-id="<?= $items['id']; ?>" data-price="<?= $items['price']; ?>" data-discount="<?= $items['discount']?>" data-sack="<?= $items['sack']?>" data-weight="<?= $items['weight'] ?>" data-description="<?= $items['description']; ?>"  data-ref="<?= $ref?>" value="<?= number_format($items['qty'], '2', ',', '.'); ?>">
                                                <p class="text-center">pack</p>
                                            <?php } else { ?>
                                                <input id="qtyAmount-<?= $items['id']; ?>" class="input-qty-so text-center form-control" data-item="<?= $items['item_name']; ?>" data-id="<?= $items['id']; ?>" data-price="<?= $items['price']; ?>" data-discount="<?= $items['discount']?>" data-sack="<?= $items['sack']?>" data-weight="<?= $items['weight'] ?>" data-description="<?= $items['description']; ?>"  data-ref="<?= $ref?>" value="<?= number_format($items['qty'], '2', ',', '.'); ?>">
                                                <p class="text-center">kg</p>
                                            <?php }?>
                                        </td>
                                        <td style="width: 150px">
                                            <input id="priceAmount-<?= $items['id']; ?>" class="input-price-so text-center form-control" data-item="<?= $items['item_name']; ?>" data-id="<?= $items['id']; ?>" data-amount="<?= $items['qty']; ?>" data-discount="<?= $items['discount']?>" data-sack="<?= $items['sack']?>" data-weight="<?= $items['weight'] ?>" data-description="<?= $items['description'];?>"  data-ref="<?= $ref?>" value="<?= number_format($items['price'], '2', ',', '.'); ?>">
                                        </td>
                                        <td style="width: 120px"> 
                                            <input id="discountAmount-<?= $items['id']; ?>" class="input-discount-so text-center form-control" data-item="<?= $items['item_name']; ?>" data-id="<?= $items['id']; ?>" data-amount="<?= $items['qty']; ?>" data-price="<?= $items['price']; ?>" data-sack="<?= $items['sack']?>" data-weight="<?= $items['weight'] ?>" data-description="<?= $items['description'];?>"   data-ref="<?= $ref?>" value="<?= number_format($items['discount'], '2', ',', '.'); ?>">
                                        </td>
                                        <td class="text-right">IDR <?= number_format($items['subtotal'], '2', ',', '.'); ?></td>
                                        <td class="text-center">
                                            <?php
                                                if ($items['sack']!=0){
                                                    $calculate_weight_persack = $items['weight']/$items['sack'];
                                                } else {
                                                    $calculate_weight_persack = 0;
                                                };
                                                echo number_format($calculate_weight_persack, '2', ',', '.'). ' kg/sack'; 
                                            ?>
                                            <input id="sackEdit-<?= $items['id']; ?>" class="input-sack-so text-center form-control" data-item="<?= $items['item_name']; ?>" data-id="<?= $items['id']; ?>" data-amount="<?= $items['qty']; ?>" data-price="<?= $items['price']; ?>" data-weight="<?= $items['weight'] ?>" data-discount="<?= $items['discount']?>" data-description="<?= $items['description'];?>" data-ref="<?= $ref?>" value="<?= $items['sack']; ?>">
                                        </td>
                                        <td class="text-center">
                                            <?php
                                                if ($items['sack']!=0){
                                                    $calculate_weight_perpack = $items['weight']/$items['qty'];
                                                } else {
                                                    $calculate_weight_perpack = 0;
                                                };
                                                echo number_format($calculate_weight_perpack, '2', ',', '.') . ' kg/pack'; 
                                            ?>
                                            <input id="weightEdit-<?= $items['id']; ?>" class="input-weight-so text-center form-control" data-item="<?= $items['item_name']; ?>" data-id="<?= $items['id']; ?>" data-amount="<?= $items['qty']; ?>" data-price="<?= $items['price']; ?>" data-discount="<?= $items['discount']?>" data-sack="<?= $items['sack']?>" data-description="<?= $items['description'];?>" data-ref="<?= $ref?>" value="<?= $items['weight']; ?>">
                                        </td>
                                        <td style="width:110px" class="text-right">
                                            <input id="referenceEdit-<?= $items['id']; ?>" class="input-reference-so text-center form-control" data-item="<?= $items['item_name']; ?>" data-id="<?= $items['id']; ?>" data-amount="<?= $items['qty']; ?>" data-price="<?= $items['price']; ?>" data-discount="<?= $items['discount']?>" data-sack="<?= $items['sack']?>" data-weight="<?= $items['weight'] ?>" data-ref="<?= $ref?>" value="<?= $items['description']; ?>">
                                        </td>
                                        <td>
                                            <a data-toggle="modal" data-target="#deleteCartIndividualItem" data-id="<?= $items['id'] ?>" data-cust="<?= $items['customer_id'] ?>" data-name="<?= $items['item_name']; ?>" data-amount="<?= $items['qty'] ?>" class="badge badge-danger clickable ml-3">Delete</a>
                                        </td>
                                    </tr>
                                    <?php 
                                        $temp = $temp + $items['subtotal']; 
                                        $temp1 = $temp1 + ($items['qty'] * $items['discount']); 
                                        $i++; 
                                    endforeach; 
                                    ?>
                            </tbody>
                            <?php
                                $data['sales_tax'] = $this->db->get_where('settings', ['parameter' => 'sales_tax'])->row_array();
                                $sales_tax = $data['sales_tax']['value'];
                            ?>
                            <tfoot>
                                <tr class="text-right align-items-center">
                                    <td colspan="4"> </td>
                                    <td class="right"><strong>Total</strong></td>
                                    <?php $total = $temp; ?>
                                    <td class="right">IDR <?= number_format($total, 2, ',', '.'); ?></td>
                                </tr>
                                <tr class="text-right align-items-center">
                                    <td colspan="4"> </td>
                                    <td class="right"><strong>Tax <?= $sales_tax ?>%</strong></td>
                                    <?php
                                    $total_tax = $sales_tax / 100 * $total;
                                    $grandTotal = $total + $total_tax; ?>
                                    <td class="right">IDR <?= number_format($total_tax, '2', ',', '.'); ?></td>
                                </tr>
                                <tr class="text-right align-items-center">
                                    <td colspan="4"> </td>
                                    <td class="right"><strong>Grand Total</strong></td>
                                    <td class="right">IDR <?= number_format($grandTotal, '2', ',', '.'); ?></td>
                                </tr>      
                                <tr class="text-right align-items-center">
                                    <td colspan="4"> </td>
                                    <td class="right"><strong>Discount</strong></td>
                                    <?php $total_disc = $temp1; ?>
                                    <td class="right">IDR <?= $this->cart->format_number($total_disc, '-', ',', '.'); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
            echo form_close();
            else : ?>
        </div>
        <div class="row mx-3 my-0 justify-content-center">
            <i class="text-gray-400"><i class="bi bi-bag-plus fa-5x"></i></i>
        </div>
        <div class="row mx-3 mb-3 justify-content-center">
            <div class="" role="alert">Sales order is empty.</a></div>
        </div>
        <?php endif;
        ?>
    </div>
    <!-- /.container-fluid -->

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
                <div class="table table-responsive">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Finished Good</th>
                                    <th>Code</th>
                                    <th>Stock</th>
                                    <th>Unit</th>
                                    <th>Pcs per Pack</th>
                                    <th>Pack per Sack</th>
                                    <th>Unit Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                $temp = 0; ?>
                                <?php foreach ($gbjData as $fs) : ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td class="name"><?= $fs['name'] ?></td>
                                        <td class="code"><?= $fs['code'] ?></td>
                                        <td class="in_stock"><?= number_format($fs['in_stock'], 2, ',', '.'); ?></td>
                                        <td class="unit"><?= $fs['unit_satuan']; ?></td>
                                        <td class="pcsperpack"><?= $fs['pcsperpack']; ?></td>
                                        <td class="packpersack"><?= $fs['packpersack']; ?></td>
                                        <td class="price"><?= $fs['price']; ?></td>
                                        <td>
                                            <!-- link this with a javascript -->
                                            <a data-dismiss="modal" type="button" class="select-item badge badge-primary">Add</a> 
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

<!-- Modal for add customer -->
<div class="modal fade" id="newCustomer" tabindex="-1" aria-labelledby="newCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCustomerLabel">Add New Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table2 table-responsive">
                    <div class="table-responsive">
                        <table class="table table-hover" id="table3" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Customer</th>
                                    <th>Address</th>
                                    <th>ID</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                $temp = 0; ?>
                                <?php foreach ($custData as $cd) : ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td class="cust_name"><?= $cd['name'] ?></td>
                                        <td class="address"><?= $cd['address'] . ', ' . $cd['city'] . ', ' . $cd['province'] . ', ' . $cd['country'] . ', ' . $cd['postal'] ?></td>
                                        <td class="id"><?= $cd['id'] ?></td>
                                        <td>
                                            <!-- link this with a javascript -->
                                            <a data-dismiss="modal" type="button" class="select-customer badge badge-primary">Add</a> 
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

<!-- Modal For Delete Individual Data -->
<div class="modal fade" id="deleteCartIndividualItem" tabindex="-1" aria-labelledby="deleteCartIndividualItemLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCartIndividualItemLabel">Delete Cart Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('sales/delete_cart_item/') . $ref ?>" method="post">
                <div class="modal-body">
                    <p class="mb-2">Watch out! You're about to delete this item! Are you sure?</p>
                    <div class="form-group">
                        <!-- Item ID -->
                        <input type="text" class="form-control mb-1" readonly id="delete_item_id" name="delete_item_id" placeholder="Item ID" style="display:none">
                        <!-- Item Name -->
                        <input type="text" class="form-control mb-1" readonly id="delete_item_name" name="delete_item_name" placeholder="Item Name">
                        <!-- Customer Name -->
                        <input type="text" class="form-control mb-1" readonly id="cust_name" name="cust_name" placeholder="Customer Name" style="display:none">
                        <!-- Item Amount -->
                        <input type="text" class="form-control mb-1" readonly id="item_amount" name="item_amount">
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
<div class="modal fade" id="deleteCartItem" tabindex="-1" aria-labelledby="deleteCartItemLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCartItemLabel">Delete Cart Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('sales/clear_cart/') ?>" method="post">
                <div class="modal-body">
                    Watch out! You're about to delete all your sales order item. I am sad and you should too! Are you sure?
                    <div class="form-group">
                        <!-- Transaction Ref ID -->
                        <input type="text" class="form-control mb-1" readonly id="delete_id" name="delete_id" style="display:none">
                        <!-- Customer Name -->
                        <input type="text" class="form-control mb-1" readonly id="cust_name" name="cust_name" placeholder="Customer Name" style="display:none">
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
    function calculate_nom_discount(){
        const price = document.getElementById('price').value;
        const percent = document.getElementById('percent_discount').value;
        const nom_discount = (percent/100) * price;
        document.getElementById('discount').value = nom_discount; 
    }

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
    
    //js for setting purchase tax input onchange
    function change_purchase_tax($amount){
        window.location.href = "<?= site_url('admin/update_purchase_tax/');?>"+amount;
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>