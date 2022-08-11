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
                                <th>Invoice Ref</th>
                                <th>Date</th>
                                <th>Item Description</th>
                                <th>Qty</th>
                                <th style="text-align:right">Item Price</th>
                                <th style="text-align:right">Sub-Total</th>
                            </tr>
                        </thead>

                        <?php $i = 1;
                        $temp = 0; ?>
                        <tbody>

                            <?php foreach ($dataCart as $items) : ?>
                                <?php
                                if ($items['customer'] != $user['id']) {
                                    continue;
                                } else {
                                    if ($items['status'] != '1') {
                                        continue;
                                    } else { ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $items['ref']; ?></td>
                                            <td><?= date('d F Y h:i', $items['date']); ?></td>
                                            <td><?= $items['name']; ?></td>
                                            <td><?= $items['qty']; ?></td>
                                            <td style=" text-align:right">IDR <?= $this->cart->format_number($items['price'], '0', ',', '.'); ?>
                                            </td>
                                            <td style="text-align:right">IDR <?= $this->cart->format_number($items['subtotal'], '0', ',', '.'); ?></td>
                                            </td>
                                        </tr>
                                        <?php $temp = $temp + $items['subtotal']; ?>
                                        <?php $i++; ?>
                                <? }
                                } ?>

                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="text-right align-items-center">
                                <td colspan="5"> </td>
                                <td class="right"><strong>Total Global Transaction</strong></td>
                                <?php $grandTotal = $temp; ?>
                                <td class="right">IDR <?= $this->cart->format_number($grandTotal, '0', ',', '.'); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    <?php
        echo form_close();
    else : ?>
        <div class="alert alert-danger" role="alert">Your cart is empty!</div>
    <? endif;
    ?>
</div>

</div>
<!-- /.container-fluid -->