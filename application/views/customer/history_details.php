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
    <a href="<?= base_url('customer/history/') ?>" class="btn btn-light btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left"></i>
        </span>
        <span class="text">Back</span>
    </a>

    <!-- view pdf Invoice  -->
    <a href="<?= base_url('customer/createPDF/') . $ref ?>" class="btn btn-primary btn-icon-split mb-3" target="_blank" rel="noopener noreferrer">
        <span class="icon text-white-50">
            <i class="bi bi-eye"></i>
        </span>
        <span class="text">View Invoice Preview</span>
    </a>

    <div class="card rounded bg-white shadow border-0 mb-3">
        <div class="card-body pb-1">
            <?php if ($status == 1) { ?>
                <div class="row justify-content-center mx-3 my-2">
                    <span class="icon text-primary mx-2">
                        <i class="bi bi-1-circle"></i>
                    </span>
                    <span class="text-primary">In Progress</span>

                    <!-- Separator -->
                    <span class="icon text-secondary mx-2">
                        <i class="bi bi-arrow-right"></i>
                    </span>
                    <!-- Separator -->

                    <span class="icon text-secondary mx-2">
                        <i class="bi bi-2-circle"></i>
                    </span>
                    <span class="text">Delivering</span>

                    <!-- Separator -->
                    <span class="icon text-secondary mx-2">
                        <i class="bi bi-arrow-right"></i>
                    </span>
                    <!-- Separator -->

                    <span class="icon text-secondary mx-2">
                        <i class="bi bi-3-circle"></i>
                    </span>
                    <span class="text">Goods Delivered</span>
                </div>
            <?php } else if ($status == 2) { ?>
                <div class="row justify-content-center mx-3 my-2">
                    <span class="icon text-secondary mx-2">
                        <i class="bi bi-1-circle"></i>
                    </span>
                    <span class="text-secondary">In Progress</span>

                    <!-- Separator -->
                    <span class="icon text-secondary mx-2">
                        <i class="bi bi-arrow-right"></i>
                    </span>
                    <!-- Separator -->

                    <span class="icon text-primary mx-2">
                        <i class="bi bi-2-circle"></i>
                    </span>
                    <span class="text-primary">Delivering</span>

                    <!-- Separator -->
                    <span class="icon text-secondary mx-2">
                        <i class="bi bi-arrow-right"></i>
                    </span>
                    <!-- Separator -->

                    <span class="icon text-secondary mx-2">
                        <i class="bi bi-3-circle"></i>
                    </span>
                    <span class="text">Goods Delivered</span>
                </div>
            <?php } else if ($status == 3) { ?>
                <div class="row justify-content-center mx-3 my-2">
                    <!-- Status = 1 payment -->
                    <span class="icon text-secondary mx-2">
                        <i class="bi bi-1-circle"></i>
                    </span>
                    <span class="text-secondary">In Progress</span>

                    <!-- Separator -->
                    <span class="icon text-secondary mx-2">
                        <i class="bi bi-arrow-right"></i>
                    </span>
                    <!-- Separator -->
                    <!-- Status = 2 delivering -->
                    <span class="icon text-secondary mx-2">
                        <i class="bi bi-2-circle"></i>
                    </span>
                    <span class="text-secondary">Delivering</span>

                    <!-- Separator -->
                    <span class="icon text-secondary mx-2">
                        <i class="bi bi-arrow-right"></i>
                    </span>
                    <!-- Separator -->
                    <!-- Status = 3 delivered -->
                    <span class="icon text-primary mx-2">
                        <i class="bi bi-3-circle"></i>
                    </span>
                    <span class="text-primary">Goods Delivered</span>
                </div>
            <?php } else if ($status == 4) { ?>
                <div class="row justify-content-center mx-3 my-2 h5">
                    <!-- Status = 4 delivered -->
                    <span class="icon text-danger mx-2">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </span>
                    <span class="text-danger">Declined</span>
                </div>
            <?php } ?>
            <p class="text-dark mb-1">Invoice Ref. : </p>
            <p class="text-dark font-weight-bold"> <?= $ref ?></p>
            <p class="text-dark mb-1">Date : </p>
            <p class="text-dark font-weight-bold"> <?= date('d F Y H:i', $date); ?></p>
            <p class="text-dark mb-1">Delivery Address:</p>
            <p class="text-dark font-weight-bold"><?= $address; ?></p>
        </div>
    </div>

    <?php if ($dataCart != null) : ?>
        <div class="card rounded border-0 shadow mb-3">
            <div class="card-body p-4">
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
                                if ($items['ref'] == $ref) {
                                    if ($items['status'] == '0') { //show other than status = 0
                                        continue;
                                    } else { ?>
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
                                            </td>
                                        </tr>
                                        <?php $temp = $temp + $items['subtotal']; ?>
                                        <?php $i++; ?>
                                <?php }
                                } else {
                                }
                                ?>
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
    <?php
    else : ?>
        <div class="alert alert-danger" role="alert">There's nothing here!</div>
    <?php endif;
    ?>
</div>

</div>
<!-- /.container-fluid -->