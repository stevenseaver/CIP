<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <p class="h3 mb-4 text-gray-800"><?= $title ?></p>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <!-- show uncompleted purchase order -->
    <p class="h5 text-gray-800">Standing Purchase Order</p>
    <?php if ($inventory_item != null) {
        $i = 1;
        $temp = 0;
        $before = '';
    ?>
        <div class="card border-left-primary mb-3">
            <div class="row mx-4 my-3">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>PO Number</th>
                                <th>Date</th>
                                <th>Supplier</th>
                                <!-- <th>Value</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            $temp = 0; ?>
                            <?php foreach ($inventory_item as $inv) :
                                if ($before != $inv['transaction_id']) { ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $inv['transaction_id'] ?></td>
                                        <td><?= date('d F Y H:i:s', $inv['date']); ?></td>
                                        <td><?= $inv['supplier_name'] ?></td>
                                        <?php $value = $inv['price'] * $inv['incoming'];
                                        $temp = $temp + $value; ?>
                                        <!-- <td><?= number_format($temp, 0, ',', '.') ?></td> -->
                                        <td>
                                            <a href="<?= base_url('purchasing/po_details/') . $inv['transaction_id'] . '/' . $inv['supplier'] . '/' . $inv['date'] ?>" class="badge badge-primary">Details</a>
                                        </td>
                                    </tr>
                                <?php
                                    $before = $inv['transaction_id'];
                                    $i++;
                                } else {
                                } ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    } else { ?>
        <div class="alert alert-primary mb-3" role="alert">There's no standing purchase order at the moment!</div>
    <?php }
    ?>

    <p class="h5 text-gray-800">Received Purchase Order</p>
    <?php if ($inventory_item_received != null) {
        $i = 1;
        $temp = 0;
        $before = '';
    ?>
        <div class="card border-left-primary mb-3">
            <div class="row mx-4 my-3">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>PO Number</th>
                                <th>Date</th>
                                <th>Supplier</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            $temp = 0; ?>
                            <?php foreach ($inventory_item_received as $inv_rcv) :
                                if ($before != $inv_rcv['transaction_id']) { ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $inv_rcv['transaction_id'] ?></td>
                                        <td><?= date('d F Y H:i:s', $inv_rcv['date']); ?></td>
                                        <td><?= $inv_rcv['supplier_name'] ?></td>
                                        <?php $value = $inv_rcv['price'] * $inv_rcv['in_stock'];
                                        $temp = $temp + $value;  ?>
                                        <!-- <td><?= number_format($value, 0, ',', '.') ?></td> -->
                                        <td>
                                            <a href="<?= base_url('purchasing/receive_details/') . $inv_rcv['transaction_id'] . '/' . $inv_rcv['supplier'] . '/' . $inv_rcv['date'] ?>" class="badge badge-primary">Details</a>
                                        </td>
                                    </tr>
                                <?php
                                    $before = $inv_rcv['transaction_id'];
                                    $i++;
                                } else {
                                } ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    } else { ?>
        <div class="alert alert-primary mb-3" role="alert">There's no received purchase order at the moment!</div>
    <? }
    ?>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->