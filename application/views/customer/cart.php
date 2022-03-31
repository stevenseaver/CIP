<!-- Begin Page Content -->
<div class="container-fluid">
    <?php if ($cart = $this->cart->contents()) : ?>
        <?php echo form_open('customer/cart'); ?>

        <div class="mx-3 my-3">
            <table cellpadding="6" cellspacing="1" style="width:100%" border="0">
                <tr calss="">
                    <th>Qty</th>
                    <th>Item Description</th>
                    <th style="text-align:right">Item Price</th>
                    <th style="text-align:right">Sub-Total</th>
                </tr>

                <?php $i = 1; ?>

                <?php foreach ($this->cart->contents() as $items) : ?>

                    <?php echo form_hidden($i . '[rowid]', $items['rowid']); ?>

                    <tr>
                        <td><?php echo form_input(array('name' => $i . '[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?></td>
                        <td>
                            <?php echo $items['name']; ?>

                            <?php if ($this->cart->has_options($items['rowid']) == TRUE) : ?>

                                <p>
                                    <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value) : ?>

                                        <strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br />

                                    <?php endforeach; ?>
                                </p>

                            <?php endif; ?>

                        </td>
                        <td style="text-align:right"><?php echo $this->cart->format_number($items['price'], '0', ',', '.'); ?></td>
                        <td style="text-align:right">$<?php echo $this->cart->format_number($items['subtotal'], '0', ',', '.'); ?></td>
                    </tr>

                    <?php $i++; ?>

                <?php endforeach; ?>

                <tr>
                    <td colspan="2"> </td>
                    <td class="right"><strong>Total</strong></td>
                    <td class="right">IDR <?php echo $this->cart->format_number($this->cart->total(), '0', ',', '.'); ?></td>
                </tr>
            </table>

            <button class="btn rounded-pill btn-primary" type="submit">
                <i class="bi bi-arrow-clockwise"></i> Update
            </button>

        <?php
        echo form_close();
    else : ?>
            <div class="alert alert-danger" role="alert">Your cart is empty!</div>
        <? endif;
        ?>
        </div>

</div>
<!-- /.container-fluid -->