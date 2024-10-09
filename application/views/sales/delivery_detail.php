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
    <a href="<?= base_url('sales/deliveryorder') ?>" class="btn btn-light btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left"></i>
        </span>
        <span class="text">Back</span>
    </a>

    <!-- view pdf DO  -->
    <a href="<?= base_url('sales/createPDF/2/') . $ref  ?>" class="btn btn-primary btn-icon-split mb-3" target="_blank" rel="noopener noreferrer">
        <span class="icon text-white-50">
            <i class="bi bi-eye"></i>
        </span>
        <span class="text">View Delivery Order Preview</span>
    </a>

    <div class="card rounded bg-white shadow border-0 mb-3">
        <div class="card-body pb-1">
            <?php if ($status == 1) { ?>
                <div class="row justify-content-center mx-3 my-2">
                    <span class="icon text-primary mx-2">
                        <i class="bi bi-1-circle"></i>
                    </span>
                    <span class="text-primary">Payment Confirmation</span>

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
                    <span class="text-secondary">Payment Confirmation</span>

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
                    <span class="text-secondary">Payment Confirmation</span>

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
            <?php } ?>
            <p class="text-dark mb-1">Customer Name. : </p>
            <p class="text-dark font-weight-bold"> <?= $customer; ?></p>
            <p class="text-dark mb-1">Invoice Ref. : </p>
            <p class="text-dark font-weight-bold"> <?= $ref; ?></p>
            <p class="text-dark mb-1">Date : </p>
            <p class="text-dark font-weight-bold"> <?= date('d F Y H:i', $date); ?></p>
            <p class="text-dark mb-1">Delivery Address:</p>
            <p class="text-dark font-weight-bold"><?= $address; ?></p>
            <p class="text-dark mb-1">Reference:</p>
            <p id="ref_item" class="text-dark font-weight-bold mb-3"> 
                <?= $reference; ?>
                <i type="button" id="editRefNameplate" class="small text-primary bi bi-pencil-fill"></i>
            </p>
            <input style="display:none" id="change_ref_sales" class="change_ref_sales text-left form-control mb-3"  data-id="<?= $ref; ?>" value="<?= $reference; ?>">
            <script>
                const button = document.getElementById('editRefNameplate');
                const div = document.getElementById('change_ref_sales');

                // define the function to change the HTML content
                function changeContent() {
                    document.getElementById('change_ref_sales').style.display = 'block';
                    document.getElementById('ref_item').style.display = 'none';
                }

                // add event listener to the button
                button.addEventListener('click', changeContent);
            </script>
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
                                <th style="text-align:right">Discount</th>
                                <th style="text-align:right">Sub-Total</th>
                                <th>Weight/Sack</th>
                                <th>Weight/Pack</th>
                            </tr>
                        </thead>

                        <?php 
                            $i = 1;
                            $temp = 0;
                            $temp1 = 0; 
                        ?>
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
                                            <td><?= number_format($items['qty'], '2', ',', '.') . ' ' . $items['unit']; ?></td>
                                            <td style=" text-align:right">IDR <?= number_format($items['price'], '2', ',', '.'); ?></td>
                                            <td style=" text-align:right">IDR <?= number_format($items['discount'], '2', ',', '.'); ?></td>
                                            <td style="text-align:right">IDR <?= number_format($items['subtotal'], '2', ',', '.'); ?></td>
                                            <td class="text-left">
                                                <?php
                                                    if ($items['sack']!=0){
                                                        $calculate_weight_persack = $items['weight']/$items['sack'];
                                                    } else {
                                                        $calculate_weight_persack = 0;
                                                    };
                                                    echo number_format($calculate_weight_persack, '2', ',', '.'). ' kg/sack'; 
                                                ?>
                                            </td>
                                            <td class="text-left">
                                                <?php
                                                    if ($items['sack']!=0){
                                                        $calculate_weight_perpack = $items['weight']/$items['qty'];
                                                    } else {
                                                        $calculate_weight_perpack = 0;
                                                    };
                                                    echo number_format($calculate_weight_perpack, '2', ',', '.') . ' kg/pack'; 
                                                ?>
                                            </td>
                                        </tr>
                                        <?php 
                                            $temp = $temp + $items['subtotal']; 
                                            $temp1 = $temp1 + ($items['qty'] * $items['discount']); 
                                            $i++; 
                                    }
                                } else {
                                };
                            endforeach; ?>
                        </tbody>
                        <?php
                            $data['sales_tax'] = $this->db->get_where('settings', ['parameter' => 'sales_tax'])->row_array();
                            $sales_tax = $data['sales_tax']['value'];
                        ?>
                        <tfoot>
                            <tr class="text-right align-items-center">
                                <td colspan="4"> </td>
                                <td class="right"><strong>Total Invoice Transaction</strong></td>
                                <?php $total = $temp; ?>
                                <td class="right">IDR <?= $this->cart->format_number($total, '-', ',', '.'); ?></td>
                            </tr>
                            <tr class="text-right align-items-center">
                                <td colspan="4"> </td>
                                <td class="right"><strong>Tax <?= $sales_tax ?>%</strong></td>
                                <?php
                                $total_tax = $sales_tax / 100 * $total;
                                $grandTotal = $total + $total_tax; ?>
                                <td class="right">IDR <?= $this->cart->format_number($total_tax, '2', ',', '.'); ?></td>
                            </tr>
                            <tr class="text-right align-items-center">
                                <td colspan="4"> </td>
                                <td class="right"><strong>Grand Total</strong></td>
                                <td class="right">IDR <?= $this->cart->format_number($grandTotal, '2', ',', '.'); ?></td>
                            </tr>     
                            <tr class="text-right align-items-center">
                                <td colspan="4"> </td>
                                <td class="right"><strong>Discount</strong></td>
                                <?php $total_disc = $temp1; ?>
                                <td class="right">IDR <?= $this->cart->format_number($total_disc, '-', ',', '.'); ?></td>
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