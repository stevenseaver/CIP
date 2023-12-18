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
            <!-- <a href="" data-toggle="modal" data-target="#addNewAddress" class="btn btn-light mb-1">Use another address</a> -->
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
                                    <?php if ($items['prod_cat'] == '6' or $items['prod_cat'] == '7') : ?>
                                        <td><?= $items['qty'] . ' kg(s)'; ?></td>
                                    <?php else : ?>
                                        <td><?= $items['qty'] . ' pack(s)'; ?></td>
                                    <?php endif; ?>
                                    <td style=" text-align:right">IDR <?= $this->cart->format_number($items['price'], '0', ',', '.'); ?>
                                    </td>
                                    <td style="text-align:right">IDR <?= $this->cart->format_number($items['subtotal'], '0', ',', '.'); ?></td>
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
        <div class="row text-right">
            <div class="col-lg">
                <form action="<?= base_url('Customer/submitPayment') ?>" method="post">
                    <p style="display:none"> External ID : 
                        <input type="text" name="external_id" id="external_id" value="<?= $ref ?>">
                    </p>     
                    <p style="display:none"> Amount : 
                        <input type="text" name="amount" id="amount" value="<?= $grandTotal?>">
                    </p>           
                    <p  style="display:none"> Name : 
                        <input type="text" name="name" id="name" value="TESTING">
                    </p>           
                    <div class="d-flex mb-3 text-secondary text-justify">
                        <p>We accept payemnt with virtual account, debit or credit card, e-wallet/QRIS, retail merchant payment, and BRI direct debit. This service is provided by Xendit, please read their <a href="https://www.xendit.co/en-id/terms-and-conditions/" target="_blank">terms and conditions</a>.</p>
                    </div>
                    <button type="submit" class="btn btn-success btn-icon-split clickable">
                        <span class="icon text-white-50">
                            <i class="bi bi-currency-dollar"></i>
                        </span>
                        <span class="text">Continue to payment<span>
                    </button>
                </form>
            </div>
        </div>
        <!-- <div class="row mx-3 justify-content-start align-items-center">
            <?= form_open_multipart(base_url('Customer/payment/') . $ref . '/' . $user['id'] . '/0'); ?>
            <div class="row">
                <div class="d-flex mb-3 text-primary">
                    We currently accept Bank Transfer to BCA Account Number 465 001 7777 (name: PT. PLASTIK DAUR ULANG BERSAMA) only. Additional payment method to be added in the future!
                </div>
            </div>
            <div class="form-group row">
                <div class="d-flex text-dark mb-3">Upload Payment Confirmation</div>
                <div class="col-lg mb-3">
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
        </div> -->
    <?php
    else : ?>
        <div class="alert alert-danger" role="alert">Your cart is empty!</div>
    <?php endif;
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