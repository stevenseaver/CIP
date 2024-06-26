<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <?php
        // $date = time();
        // $year = date('y');
        // $month = date('m');
        // $day = date('d');
        // $serial = rand(1000, 9999);
        // //ref invoice
        // $po_id = 'PO-' . $year . $month . $day . '-' . $serial;
        $date = time();
        $year = date('y');
        $month = date('m');
        // $serial = rand(1000, 9999);

        // ref invoice
        // $po_id = 'PROD-' . $year . $month . $day . '-' . $serial;
        $n = 3;
        $result = bin2hex(random_bytes($n));
        $po_id = 'A' . $year . $month . $result;
    ?>

    <a href="<?= base_url('purchasing/add_po/') . $po_id ?>" class="btn btn-primary btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Purchase Order</span>
    </a>

    <?php if ($inventory_item != null) {
        $i = 1;
        $temp = 0;
        $before = '';
    ?>
        <div class="card border-left-primary mb-3">
            <div class="row mx-4 my-3">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-hover" id="table1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <!-- <th>No</th> -->
                                    <th>PO Number</th>
                                    <th>Date</th>
                                    <th>Supplier</th>
                                    <th>Reference</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                $temp = 0; ?>
                                <?php foreach ($inventory_item as $inv) :
                                    if ($before != $inv['transaction_id']) { ?>
                                        <tr>
                                            <!-- <td><?= $i ?></td> -->
                                            <td><?= $inv['transaction_id'] ?></td>
                                            <td><?= date('d F Y H:i:s', $inv['date']); ?></td>
                                            <td><?= $inv['supplier_name'] ?></td>
                                            <td><?= $inv['description'] ?></td>
                                            <?php $value = $inv['price'] * $inv['in_stock'];
                                            $temp = $temp + $value;  ?>
                                            <!-- <td><?= number_format($value, 0, ',', '.') ?></td> -->
                                            <td>
                                                <a href="<?= base_url('purchasing/po_details/') . $inv['transaction_id'] . '/' . $inv['supplier'] . '/' . $inv['date'] ?>" class="badge badge-primary"><i class="bi bi-info-circle-fill"> </i>Details</a>
                                                <a href="<?= base_url('purchasing/add_po/') . $inv['transaction_id'] ?>" class="badge badge-warning"><i class="bi bi-pencil-fill"> </i>Edit</a>
                                                <a href="<?= base_url('purchasing/transaction_status_change/') . $inv['transaction_id'] . '/' . $inv['supplier'] . '/' . $inv['date'] ?>" class="badge badge-success"><i class="bi bi-box-arrow-in-down"> </i>Receive Item</a>
                                                <a data-toggle="modal" data-target="#deletePOModal" data-po="<?= $inv['transaction_id']  ?>" class="badge badge-danger"><i class="bi bi-trash-fill"> </i>Delete PO</a>
                                            </td>
                                        </tr>
                                    <?php
                                        $before = $inv['transaction_id'];
                                        $i++;
                                    } else {
                                    } ?>
                                <?php endforeach; ?>
                            </tbody>
                            <!-- <tfoot>
                            <tr class="text-right align-items-center">
                                <td colspan="7"> </td>
                                <td class="right"><strong>Total</strong></td>
                                <?php $grandTotal = $temp; ?>
                                <td class="right">IDR <?= $this->cart->format_number($grandTotal, '-', ',', '.'); ?></td>
                            </tr>
                        </tfoot> -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else { ?>
        <div class="alert alert-danger" role="alert">There's no transaction! </a></div>
    <?php }
    ?>
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

<script>
    var table = $('#table1').DataTable({
        order: [1, 'asc']
    });
</script>