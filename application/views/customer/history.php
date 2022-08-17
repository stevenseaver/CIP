<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <?php if ($dataCart != null) {
        $i = 1;
        $temp = 0;
        $before = '';
        foreach ($dataCart as $items) : ?>
            <?php
            if ($items['status'] == '0') { //show other than status = 0
                continue;
            } else {
                if ($before != $items['ref']) { ?>
                    <div class="card rounded border-0 shadow mb-3">
                        <div class="card-body">
                            <div class="row text-left">
                                <div class="col-1 d-flex mx-2">
                                    <h1 class=""> <?= $i ?></h1>
                                </div>
                                <div class="col d-flex flex-column justify-content-center mb-0">
                                    <div class="">
                                        <h5 class="text-primary font-weight-bold mb-1"><?= $items['ref']; ?></h5>
                                    </div>
                                    <div class="">
                                        <p class="small mb-0"><?= date('d F Y H:i', $items['date']);  ?></p>
                                    </div>
                                </div>
                                <div class="col-1 d-flex justify-content-center align-items-center mx-3">
                                    <a href="<?= base_url('customer/history_details/') . $items['ref'] . '/' . $items['date'] . '/' . $items['status'] ?>">
                                        <i class="bi bi-list-check" style="font-size: 2rem;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                    $before = $items['ref'];
                    $i++;
                } else {
                }
            }
            ?>
        <?php endforeach; ?>
    <?php
    } else { ?>
        <div class="alert alert-danger" role="alert">Your haven't made any transaction! Let's make some <a href="<?= base_url('customer/') ?>">here. </a></div>
    <? }
    ?>
</div>

</div>
<!-- /.container-fluid -->

<!-- Modal For Add Data -->
<!-- <div class="modal fade" id="transDetail" tabindex="-1" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Transaction Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-4">
                <form name="form_invoice" action="" method="post">
                    <label for="url" class="col-form-label">Invoice No.</label>
                    <input type="text" class="form-control mb-3" id="ref" name="ref" readonly>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0" cellpadding="6">
                        <thead>
                            <tr class="">
                                <th>No</th>
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
                                // if ($items['ref'] == $inv) {
                                if ($items['status'] != '1') {
                                    continue;
                                } else { ?>
                                    <tr>
                                        <td><?= $i; ?></td>
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
                                // } else {
                                // }
                                ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="text-right align-items-center">
                                <td colspan="3"> </td>
                                <td class="right"><strong>Total Invoice Transaction</strong></td>
                                <?php $grandTotal = $temp; ?>
                                <td class="right">IDR <?= $this->cart->format_number($grandTotal, '0', ',', '.'); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> -->