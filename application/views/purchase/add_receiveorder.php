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
    <a href="<?= base_url('purchasing/receiveorder') ?>" class="btn btn-secondary btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left"></i>
        </span>
        <span class="text">Back</span>
    </a>

    <?php if ($getID['tax'] == 1) {
        $tax = 11;
    } else {
        $tax = 0;
    }
    ?>

    <!-- view pdf PO  -->
    <a href="<?= base_url('purchasing/createPDF/2/') . $poID . '/' . urldecode($sup_name) . '/' . $date . '/' . $tax ?>" class="btn btn-primary btn-icon-split mb-3" target="_blank" rel="noopener noreferrer">
        <span class="icon text-white-50">
            <i class="bi bi-eye"></i>
        </span>
        <span class="text">View Purchase Order Invoice</span>
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
    <!-- <?= form_open_multipart('purchasing/tes'); ?> -->
    <!-- <form action="<?= base_url('purchasing/tes') ?>" method="post"> -->
    <div class="table-responsive my-3">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Receive Amount</th>
                    <th>Price</th>
                    <th class="text-right">Subtotal</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $temp = 0;
                $received = 0;
                ?>
                <?php foreach ($inventory_selected as $ms) : ?>
                    <?php
                    if ($ms['transaction_id'] != $poID) {
                        continue;
                    } else {
                    }
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><input id="receiveAmount-<?= $ms['id'] ?>" class="receive-qty text-left form-control" data-id="<?= $ms['id']; ?>" value="<?= number_format($ms['incoming'], 2, ',', '.'); ?>"></td>
                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                        <?php $subtotal = $ms['incoming'] * $ms['price'] ?>
                        <td class="text-right"><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><?= $ms['item_desc'] ?></td>
                        <?php if ($ms['transaction_status'] == 1) { ?>
                            <td>
                                <p class="badge badge-warning">Not Received</p>
                            </td>
                        <? } else if ($ms['transaction_status'] == 2) { ?>
                            <td>
                                <p class="badge badge-primary">Confirmed</p>
                            </td>
                        <? } ?>
                        <?php if ($ms['transaction_status'] == 1) { ?>
                            <td>
                                <a href=" <?= base_url('purchasing/receiveItem/') . $ms['id'] ?>" class="badge badge-success clickable">Confirm</a>
                            </td>
                        <? } else if ($ms['transaction_status'] == 2) { ?>
                            <td>
                                <!-- <a href=" <?= base_url('purchasing/receiveItem/') . $ms['id'] ?>" class="badge badge-success" style="disable:true">Confirm</a> -->
                            </td>
                        <? } ?>
                    </tr>
                    <?php $temp = $temp + $subtotal;
                    $i++;
                    if ($ms['transaction_status'] == 2) {
                        $received = 1;
                    } else {
                        $received = 0;
                    } ?>
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
    <?php if ($received == 1) { ?>
        <div class="footer text-right">
            <a href="<?= base_url('purchasing/receiveorder') ?>" class="btn btn-primary">Save PO</a>
        </div>
    <? } else { ?>
        <div class="footer text-right">
            <a data-toggle="modal" data-target="#deletePOModal" data-po="<?= $poID ?>" class="btn text-danger">Close and delete data</a>
            <a href="<?= base_url('purchasing/receiveorder') ?>" class="btn btn-primary">Save PO</a>
        </div>
    <? } ?>
    <!-- </form> -->
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal For Delete Data -->
<div class="modal fade" id="deletePOModal" tabindex="-1" role="dialog" aria-labelledby="deletePOModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePOModalLabel">Whoops!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">Closing this window will delete all PO data you've entered. Are you sure?</p>
            <form action="<?= base_url('purchasing/delete_all_po/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- item id -->
                        <label for="url" class="col-form-label">PO ID</label>
                        <input type="text" class="form-control" id="delete_po_id" name="delete_po_id" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>