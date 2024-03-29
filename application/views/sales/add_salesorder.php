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
                <p class="text-dark mb-1">Date : </p>
                <p class="text-dark font-weight-bold"> <?= date('d F Y h:i', $date); ?></p>
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
                            <?= form_error('cust_name', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-8">
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
                    <div class="col-lg-4">
                        <div class="form-group">
                            <!-- GBJ item name -->
                            <label for="name" class="col-form-label">Item Name</label>
                            <input type="text" class="form-control" id="name" name="name" readonly value="<?= set_value('name'); ?>">
                            <?= form_error('cust_name', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <!-- GBJ code -->
                            <label for="code" class="col-form-label">Code</label>
                            <input type="text" class="form-control" id="code" name="code" readonly value="<?= set_value('code'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <!-- Item stock -->
                            <label for="instock" class="col-form-label">In Stock</label>
                            <input type="text" class="form-control" id="instock" name="instock" readonly value="<?= set_value('instock'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <!-- Item price -->
                            <label for="price" class="col-form-label">Price</label>
                            <input type="text" class="form-control" id="price" name="price" readonly value="<?= set_value('price'); ?>">
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
                                <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <!-- Item price -->
                            <label for="notes" class="col-form-label">Notes</label>
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
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0" cellpadding="6">
                            <thead>
                                <tr class="">
                                    <th>No</th>
                                    <th>Item Description</th>
                                    <th style="text-align:center">Qty</th>
                                    <th style="text-align:right">Unit Price (IDR)</th>
                                    <th style="text-align:right">Sub Total (IDR)</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                            </thead>

                            <?php $i = 1;
                            $temp = 0; ?>
                            <tbody>
                                <?php foreach ($dataCart as $items) : ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $items['item_name']; ?></td>
                                        <td style="width: 100px">
                                            <?php if ($items['prod_cat'] != '6' and $items['prod_cat'] != '7') { ?>
                                                <input id="qtyAmount-<?= $items['id']; ?>" class="input-qty-so text-center form-control" data-item="<?= $items['item_name']; ?>" data-id="<?= $items['id']; ?>" data-price="<?= $items['price']; ?>" data-ref="<?= $ref?>" value="<?= $this->cart->format_number($items['qty'], '2', ',', '.'); ?>">
                                                <p class="text-center">pack</p>
                                            <?php } else { ?>
                                                <input id="qtyAmount-<?= $items['id']; ?>" class="input-qty-so text-center form-control" data-item="<?= $this->cart->format_number($items['item_name'], '2', ',', '.'); ?>" data-id="<?= $items['id']; ?>" data-price="<?= $items['price']; ?>" data-ref="<?= $ref?>" value="<?= $items['qty']; ?>">
                                                <p class="text-center">kg</p>
                                            <?php }?>
                                        </td>
                                        <!-- <td style=" text-align:right">IDR <?= $this->cart->format_number($items['price'], '0', ',', '.'); ?> -->
                                        <td style="width: 150px">
                                            <input id="priceAmount-<?= $items['id']; ?>" class="input-price-so text-center form-control" data-item="<?= $items['item_name']; ?>" data-id="<?= $items['id']; ?>" data-amount="<?= $items['qty']; ?>" data-ref="<?= $ref?>" value="<?= $items['price']; ?>">
                                        </td>
                                        <td style="text-align:right">IDR <?= $this->cart->format_number($items['subtotal'], '0', ',', '.'); ?></td>
                                        <td style="text-align:left">
                                            <a data-toggle="modal" data-target="#deleteCartIndividualItem" data-id="<?= $items['id'] ?>" data-cust="<?= $items['customer_id'] ?>" data-name="<?= $items['item_name']; ?>" data-amount="<?= $items['qty'] ?>" class="badge badge-danger clickable ml-3">Delete</a>
                                        </td>
                                    </tr>
                                    <?php $temp = $temp + $items['subtotal']; ?>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                            <?php
                                $data['sales_tax'] = $this->db->get_where('settings', ['parameter' => 'sales_tax'])->row_array();
                                $sales_tax = $data['sales_tax']['value'];
                            ?>
                            <tfoot>
                                <tr class="text-right align-items-center">
                                    <td colspan="3"> </td>
                                    <td class="right"><strong>Total</strong></td>
                                    <?php $total = $temp; ?>
                                    <td class="right">IDR <?= $this->cart->format_number($total, '-', ',', '.'); ?></td>
                                </tr>
                                <tr class="text-right align-items-center">
                                    <td colspan="3"> </td>
                                    <td class="right"><strong>Tax <?= $sales_tax ?>%</strong></td>
                                    <?php
                                    $total_tax = $sales_tax / 100 * $total;
                                    $grandTotal = $total + $total_tax; ?>
                                    <td class="right">IDR <?= $this->cart->format_number($total_tax, '2', ',', '.'); ?></td>
                                </tr>
                                <tr class="text-right align-items-center">
                                    <td colspan="3"> </td>
                                    <td class="right"><strong>Grand Total</strong></td>
                                    <td class="right">IDR <?= $this->cart->format_number($grandTotal, '2', ',', '.'); ?></td>
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
            <h1 class="text-gray-400"><i class="bi bi-bag-plus fa-5x"></i></h1>
        </div>
        <div class="row mx-3 justify-content-center">
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
                <h5 class="modal-title" id="newCustomerLabel">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table2 table-responsive">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
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