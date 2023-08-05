<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <!-- back button -->
    <a href="<?= base_url('purchasing/') ?>" class="btn btn-white btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left text-dark"></i>
        </span>
        <span class="text text-dark">Back</span>
    </a>

    <!-- assign tax value-->
    <?php 
        $data['purchase_tax'] = $this->db->get_where('settings', ['parameter' => 'purchase_tax'])->row_array();
        $purchase_tax = $data['purchase_tax']['value'];

        if ($getID['tax'] == 1) {
            $tax = $purchase_tax;
        } else {
            $tax = 0;
        } 
    ?>

    <!-- view pdf PO  -->
    <a href="<?= base_url('purchasing/createPDF/1/') . $po_id . '/' . urldecode($sup_name) . '/' . $date . '/' . $tax ?>" class="btn btn-primary btn-icon-split mb-3" target="_blank" rel="noopener noreferrer">
        <span class="icon text-white-50">
            <i class="bi bi-eye"></i>
        </span>
        <span class="text">View Purchase Order Preview</span>
    </a>

    <div class="card rounded shadow border-0 mb-3">
        <div class="card-body mb-0">
            <p class="text-dark mb-1">PO Ref : </p>
            <p class="text-dark font-weight-bold"> <?= $getID['transaction_id'] ?></p>
            <p class="text-dark mb-1">Weighting Doc. : </p>
            <p class="text-dark font-weight-bold"> <?= $getID['description'] ?></p>
            <p class="text-dark mb-1">Date : </p>
            <p class="text-dark font-weight-bold"> <?= date('d F Y H:i:s', $getID['date']) ?></p>
            <p class="text-dark mb-1">Supplier : </p>
            <p class="text-dark font-weight-bold"> <?= $sup_name ?></p>
            <p class="text-dark mb-1">Tax : </p>
            <p class="text-dark font-weight-bold"> <?= $tax ?>% </p>
        </div>
    </div>

    <div class="table-responsive my-3">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th class="text-right">Subtotal</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $temp = 0;
                ?>
                <?php foreach ($inventory_selected as $ms) : ?>
                    <?php
                    if ($ms['transaction_id'] != $po_id) {
                        continue;
                    } else {
                    }
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= number_format($ms['incoming'], 2, ',', '.'); ?></td>
                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                        <?php $subtotal = $ms['incoming'] * $ms['price'] ?>
                        <td class="text-right"><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><?= $ms['item_desc'] ?></td>
                    </tr>
                    <?php $temp = $temp + $subtotal; ?>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="3"> </td>
                    <td class="right"><strong>Total</strong></td>
                    <?php $total = $temp; ?>
                    <td class="right">IDR <?= $this->cart->format_number($total, '2', ',', '.'); ?></td>
                </tr>
                <tr class="align-items-center">
                    <td colspan="3"> </td>
                    <td class="right"><strong>Tax <?= $tax ?>%</strong></td>
                    <?php
                    $total_tax = $tax / 100 * $total;
                    $grandTotal = $total + $total_tax; ?>
                    <td class="right">IDR <?= $this->cart->format_number($total_tax, '2', ',', '.'); ?></td>
                </tr>
                <tr class="align-items-center">
                    <td colspan="3"> </td>
                    <td class="right"><strong>Grand Total</strong></td>
                    <td class="right">IDR <?= $this->cart->format_number($grandTotal, '2', ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->