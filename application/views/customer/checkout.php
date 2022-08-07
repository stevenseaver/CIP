<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <div class="card rounded bg-white shadow border-0 mb-3">
        <div class="card-body pb-1">
            <p class="text-dark mb-1">Invoice Ref. : </p>
            <p class="text-dark font-weight-bold"> <?= $ref ?></p>
            <p class="text-dark mb-1">Date : </p>
            <p class="text-dark font-weight-bold"> <?= date('d F Y h:i', $date); ?></p>
        </div>
    </div>

    <?php if ($dataCart != null) : ?>
        <div class="card rounded border-0 shadow mb-3">
            <div class="card-body pb-0">
                <div class="table-responsive">
                    <table class="table table-hover" width="100%" cellspacing="0" cellpadding="6">
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
                                if ($items['customer'] != $user['name']) {
                                    continue;
                                } else {
                                    if ($items['status'] != '0') {
                                        continue;
                                    } else { ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $items['name']; ?></td>
                                            <td><?= $items['qty']; ?></td>
                                            <td style=" text-align:right">IDR <?= $this->cart->format_number($items['price'], '0', ',', '.'); ?>
                                            </td>
                                            <td style="text-align:right">IDR <?= $this->cart->format_number($items['subtotal'], '0', ',', '.'); ?></td>

                                        </tr>
                                        <?php $temp = $temp + $items['subtotal']; ?>
                                        <?php $i++; ?>
                                <? }
                                } ?>

                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="text-right align-items-center">
                                <td colspan="3"> </td>
                                <td class="right"><strong>Total</strong></td>
                                <?php $grandTotal = $temp; ?>
                                <td class="right">IDR <?= $this->cart->format_number($grandTotal, '0', ',', '.'); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="row mx-3 justify-content-start align-items-center">
            <?= form_open_multipart(base_url('Customer/payment/') . $ref . '/' . $user['name'] . '/0'); ?>
            <div class="form-group row">
                <!-- edit profile picture -->
                <div class="d-flex text-dark mr-3 mb-3">Upload Payment Confirmation</div>
                <div class="col-lg-6 mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                        <small class="text-primary">Maximum 2 MB of JPG, PNG, or GIF file</small>
                        <?= form_error('image', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="form-group ml-2">
                    <button type="submit" class="btn btn-success rounded-pill btn-icon-split clickable">
                        <span class="icon text-white-50">
                            <i class="bi bi-currency-dollar"></i>
                        </span>
                        <span class="text">Confirm Payment<span>
                    </button>
                </div>
            </div>
            </form>
        </div>

    <?php
    else : ?>
        <div class="alert alert-danger" role="alert">Your cart is empty!</div>
    <? endif;
    ?>
</div>

</div>
<!-- /.container-fluid -->