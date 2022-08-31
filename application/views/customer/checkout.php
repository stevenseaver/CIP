<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <!-- back button -->
    <a href="<?= base_url('customer/cart/') ?>" class="btn btn-primary btn-icon-split mb-3">
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
            <p class="text-dark mb-1">Delivery Address:</p>
            <p class="text-dark font-weight-bold"><?= $address; ?></p>
            <a href="" data-toggle="modal" data-target="#addNewAddress" class="btn btn-light mb-1">Use another address</a>
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
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $items['item_name']; ?></td>
                                    <td><?= $items['qty']; ?></td>
                                    <td style=" text-align:right">IDR <?= $this->cart->format_number($items['price'], '0', ',', '.'); ?>
                                    </td>
                                    <td style="text-align:right">IDR <?= $this->cart->format_number($items['subtotal'], '0', ',', '.'); ?></td>
                                </tr>
                                <?php $temp = $temp + $items['subtotal']; ?>
                                <?php $i++; ?>
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
            <?= form_open_multipart(base_url('Customer/payment/') . $ref . '/' . $user['id'] . '/0'); ?>
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
                    <button type="submit" class="btn btn-success btn-icon-split clickable">
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


<!-- Modal For Add Data -->
<div class="modal fade" id="addNewAddress" tabindex="-1" aria-labelledby="addNewAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewAddressModalLabel">Transaction Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-4">
                <form action="<?= base_url('customer/check_out/') ?>" method="post">
                    <div class="form-group row">
                        <!-- edit address -->
                        <div class="col">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?= $user['address']; ?>">
                            <?= form_error('address', '<small class="text-danger pl-2">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col mb-1">
                            <label for="address" class="form-label">City</label>
                            <input type="text" class="form-control form-control-user" id="city" name="city" placeholder="City" value="<?= $user['city']; ?>">
                            <?= form_error('city', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- state/province -->
                        <div class="col mb-1">
                            <label for="address" class="form-label">Province</label>
                            <input type="text" class="form-control form-control-user" id="province" name="province" placeholder="Province or State" value="<?= $user['province']; ?>">
                            <?= form_error('province', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-8 mb-2">
                            <label for="address" class="form-label">Country</label>
                            <input type="text" class="form-control form-control-user" id="country" name="country" placeholder="Country" value="<?= $user['country']; ?>">
                            <?= form_error('country', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- zipcode -->
                        <div class="col-4 mb-2">
                            <label for="address" class="form-label">Postal</label>
                            <input type="text" class="form-control form-control-user" id="postal" name="postal" placeholder="Postal Code" value="<?= $user['postal']; ?>">
                            <?= form_error('postal', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Address</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>