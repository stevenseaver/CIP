<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <?php if ($dataCart != null) : ?>
        <?php echo form_open('customer/cart'); ?>

        <div class="mx-3 my-3">
            <table cellpadding="6" cellspacing="1" style="width:100%" border="0">
                <tr calss="">
                    <th style="text-align:center">Qty</th>
                    <th>Item Description</th>
                    <th style="text-align:right">Item Price</th>
                    <th style="text-align:right">Sub-Total</th>
                </tr>

                <?php $i = 1;
                $temp = 0; ?>

                <?php foreach ($dataCart as $items) : ?>
                    <?php
                    if ($items['customer'] != $user['name']) {
                        continue;
                    } else {
                        if ($items['status'] != '1') {
                            continue;
                        } else { ?>
                            <tr>
                                <!-- <td><?php echo form_input(array('name' => $i . '[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?></td> -->
                                <td style="text-align:center"><?= $items['qty']; ?></td>
                                <td><?= $items['name']; ?></td>
                                <td style="text-align:right"><?= $this->cart->format_number($items['price'], '0', ',', '.'); ?></td>
                                <td style="text-align:right">IDR <?= $this->cart->format_number($items['subtotal'], '0', ',', '.'); ?></td>
                                <?php $temp = $temp + $items['subtotal']; ?>
                            </tr>
                            <?php $i++; ?>
                    <? }
                    } ?>

                <?php endforeach; ?>
                <tr>
                    <td colspan="2"> </td>
                    <td class="right"><strong>Total</strong></td>
                    <?php $grandTotal = $temp; ?>
                    <td class="right">IDR <?= $this->cart->format_number($grandTotal, '0', ',', '.'); ?></td>
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