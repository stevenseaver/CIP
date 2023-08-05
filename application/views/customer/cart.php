<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

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
                                <th style="text-align:right">Item Price</th>
                                <th style="text-align:right">Sub Total</th>
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
                                        <?php if ($items['prod_cat'] != '6' or $items['prod_cat'] != '7') : ?>
                                            <input id="qtyAmount-<?= $items['id']; ?>" class="input-qty text-center form-control" data-item="<?= $items['item_name']; ?>" data-id="<?= $items['id']; ?>" data-price="<?= $items['price']; ?>" value="<?= $items['qty']; ?>">
                                            <p class="text-center">pack</p>
                                        <?php else : ?>
                                            <input id="qtyAmount-<?= $items['id']; ?>" class="input-qty text-center form-control" data-item="<?= $items['item_name']; ?>" data-id="<?= $items['id']; ?>" data-price="<?= $items['price']; ?>" value="<?= $items['qty']; ?>">
                                            <p class="text-center">kg</p>
                                        <?php endif; ?>
                                    </td>
                                    <td style=" text-align:right">IDR <?= $this->cart->format_number($items['price'], '0', ',', '.'); ?>
                                    </td>
                                    <td style="text-align:right">IDR <?= $this->cart->format_number($items['subtotal'], '0', ',', '.'); ?></td>
                                    <td style="text-align:left">
                                        <a data-toggle="modal" data-target="#deleteCartIndividualItem" data-id="<?= $items['id'] ?>" data-cust="<?= $user['name'] ?>" data-name="<?= $items['item_name']; ?>" data-amount="<?= $items['qty'] ?>" class="badge badge-danger clickable ml-3">Delete</a>
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
        <div class="row mx-1 justify-content-start align-items-center">
            <div class="d-flex my-2 mx-1">
                <a href="<?= base_url('customer/check_out/') ?>" class="btn btn-success rounded-pill btn-icon-split clickable">
                    <span class="icon text-white-50">
                        <i class="bi bi-cart-check"></i>
                    </span>
                    <span class="text">Checkout<span>
                </a>
            </div>
            <div class="d-flex my-2 mx-1">
                <a href="<?= base_url('customer') ?>" class="btn btn-primary rounded-pill btn-icon-split clickable">
                    <span class="icon text-white-50">
                        <i class="bi bi-plus"></i>
                    </span>
                    <span class="text">Add More<span>
                </a>
            </div>
            <div class="d-flex my-2 mx-1">
                <button for="input-qty" href="<?= base_url('customer/cart') ?>" class="btn btn-primary rounded-pill btn-icon-split clickable">
                    <span class="icon text-white-50">
                        <i class="bi bi-arrow-clockwise"></i>
                    </span>
                    <span class="text">Update<span>
                </button>
            </div>
            <div class="d-flex my-2 mx-1">
                <a data-toggle="modal" data-target="#deleteCartItem" data-id="<?= $user['id'] ?>" data-cust="<?= $user['name'] ?>" class="btn btn-danger rounded-pill btn-icon-split clickable">
                    <span class="icon text-white-50">
                        <i class="bi bi-trash"></i>
                    </span>
                    <span class="text">Clear All<span>
                </a>
            </div>
        </div>

    <?php
        echo form_close();
    else : ?>
         <div class="row mx-3 my-0 justify-content-center">
            <h1 class="text-gray-400"><i class="bi bi-bag-plus fa-5x"></i></h1>
        </div>
        <div class="row mx-3 justify-content-center">
            <div class="" role="alert">Your cart is empty! Let's fill it with some items <a href="<?= base_url('customer/') ?>">here. </a></div>
        </div>
    <? endif;
    ?>
</div>

</div>
<!-- /.container-fluid -->

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
            <form action="<?= base_url('customer/delete_cart_item') ?>" method="post">
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
            <form action="<?= base_url('customer/clear_cart') ?>" method="post">
                <div class="modal-body">
                    Watch out! You're about to delete all your cart's item. We are sad and you should too! Are you sure?
                    <div class="form-group">
                        <!-- Cust ID -->
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