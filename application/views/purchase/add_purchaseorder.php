<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <form action="<?= base_url('purchasing/add_item_po/') . $po_id . '/8/1' ?>" method="post">
        <div class="form-group">
            <!-- Item code -->
            <label for="po_id" class="col-form-label">Purchase Order ID</label>
            <input type="text" class="form-control mb-1" id="po_id" name="po_id" readonly value="<?= $po_id ?>">
            <?= form_error('po_id', '<small class="text-danger pl-2">', '</small>') ?>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <!-- Item categories -->
                    <label for="material" class="col-form-label">Add Item</label>
                    <select name="material" id="material" class="form-control" value="<?= set_value('material') ?>">
                        <option value="">--Select Categories--</option>
                        <?php foreach ($inventory_wh as $mt) : ?>
                            <option value="<?= $mt['id'] ?>"><?= $mt['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('material', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="price" class="col-form-label">Price</label>
                    <input type="currency" class="form-control mb-1" id="price" name="price" placeholder="Input price">
                    <?= form_error('price', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <!-- Item code -->
                    <label for="amount" class="col-form-label">Amount</label>
                    <input type="text" class="form-control mb-1" id="amount" name="amount" placeholder="Input amount..">
                    <?= form_error('amount', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
            </div>
        </div>
        <input class="btn-add-item btn btn-primary mb-3" type="submit"></input>
    </form>

    <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th>Subtotal</th>
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
                        <td><?= number_format($subtotal, 2, ',', '.'); ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save PO</button>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->