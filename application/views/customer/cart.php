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
                <table cellpadding="6" cellspacing="1" style="width:100%">
                    <tr class="">
                        <th>No</th>
                        <th>Item Description</th>
                        <th style="text-align:center">Qty</th>
                        <th style="text-align:right">Item Price</th>
                        <th style="text-align:right">Sub-Total</th>
                        <th style="text-align:center">Action</th>
                    </tr>

                    <?php $i = 1;
                    $temp = 0; ?>

                    <?php foreach ($dataCart as $items) : ?>
                        <?php
                        if ($items['customer'] != $user['name']) {
                            continue;
                        } else {
                            if ($items['status'] != '0') {
                                continue;
                            } else { ?>
                                <tr>
                                    <!-- <td><?php echo form_input(array('name' => $i . '[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?></td> -->
                                    <td><?= $i; ?></td>
                                    <td><?= $items['name']; ?></td>
                                    <td class="my-3" style="text-align:center">
                                        <div class="form-control">
                                            <input class="input-qty" type="number" data-item="<?= $items['name']; ?>" data-id="<?= $items['id']; ?>" data-qty="10" data-price="<?= $items['price']; ?>" value="<?= $items['qty']; ?>">
                                        </div>
                                    </td>
                                    <td style=" text-align:right"><?= $this->cart->format_number($items['price'], '0', ',', '.'); ?>
                                    </td>
                                    <td style="text-align:right">IDR <?= $this->cart->format_number($items['subtotal'], '0', ',', '.'); ?></td>
                                    <td style="text-align:center">
                                        <a data-toggle="modal" data-target="#deleteCartIndividualItem" data-cust="<?= $user['name'] ?>" data-name="<?= $items['name']; ?>" class="badge badge-danger clickable ml-3">Delete</a>
                                    </td>
                                </tr>
                                <?php $temp = $temp + $items['subtotal']; ?>
                                <?php $i++; ?>
                        <? }
                        } ?>

                    <?php endforeach; ?>
                    <tr class="align-items-right">
                        <td colspan="2"> </td>
                        <td class="right"><strong>Total</strong></td>
                        <?php $grandTotal = $temp; ?>
                        <td class="right">IDR <?= $this->cart->format_number($grandTotal, '0', ',', '.'); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <a href="<?= base_url('customer/check_out') ?>" class="btn btn-success rounded-pill clickable"><i class="bi bi-cart-check"></i> Checkout</a>
        <a href="<?= base_url('customer') ?>" class="btn btn-primary rounded-pill clickable mx-1"><i class="bi bi-plus"></i> Add More</a>
        <button for="input-qty" href="<?= base_url('customer/update_cart') ?>" class="btn btn-primary rounded-pill clickable mx-1"><i class="bi bi-arrow-clockwise"></i> Update</button>
        <a data-toggle="modal" data-target="#deleteCartItem" data-name="<?= $user['name'] ?>" class="btn btn-danger rounded-pill clickable"><i class="bi bi-trash"></i> Clear All</a>

    <?php
        echo form_close();
    else : ?>
        <div class="alert alert-danger" role="alert">Your cart is empty!</div>
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
                    Watch out folks! You're about to delete this one item! Are you sure?
                    <div class="form-group">
                        <!-- Cust Name -->
                        <label for="url" class="col-form-label">Item Name</label>
                        <input type="text" class="form-control mb-1" readonly id="delete_ind_item" name="delete_ind_item" placeholder="Item Name">
                        <!-- iTEM Name -->
                        <label for="url" class="col-form-label" style="display:none">Item Name</label>
                        <input type="text" class="form-control mb-1" readonly id="cust_name" name="cust_name" placeholder="Item Name" style="display:none">
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
                    Watch out folks! You're about to delete all your cart's item. We are sad and you should too! Are you sure?
                    <div class="form-group" style="display:none">
                        <!-- cUST Name -->
                        <label for="url" class="col-form-label">Item Name</label>
                        <input type="text" class="form-control mb-1" readonly id="delete_name" name="delete_name" placeholder="Item Name">
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>') ?>
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