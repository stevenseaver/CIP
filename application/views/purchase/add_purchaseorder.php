<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('approval'); ?>
        </div>
    </div>

    <?php
    $date = time();
    $year = date('y');
    $month = date('m');
    $serial = rand(1000, 9990);
    //ref invoice
    $po_id = 'PO-' . $year . $month . '-' . $serial;
    // $po_id = 'PO-2210-2586';
    ?>

    <!-- <?= form_open_multipart(base_url('purchasing/add_po')); ?> -->
    <div class="form-group">
        <!-- Item code -->
        <label for="po_id" class="col-form-label">Purchase Order ID</label>
        <input type="text" class="form-control mb-1" id="po_id" name="po_id" readonly value="<?= $po_id ?>">
        <?= form_error('po_id', '<small class="text-danger pl-2">', '</small>') ?>
    </div>
    <div class="form-group">
        <!-- Item name -->
        <label for="supplier" class="col-form-label">Supplier</label>
        <select name="supplier" id="supplier" class="form-control" value="<?= set_value('supplier') ?>">
            <option value="">--Select Supplier--</option>
            <?php foreach ($supplier as $sup) : ?>
                <option value="<?= $sup['id'] ?>"><?= $sup['supplier_name'] ?></option>
            <?php endforeach; ?>
        </select>
        <?= form_error('supplier', '<small class="text-danger pl-2">', '</small>') ?>
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
    <input type="button" class="btn-add-item btn btn-primary mb-3" data-po="<?= $po_id; ?>">Add Item</input>
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
                <?php foreach ($inventory_item as $ms) : ?>
                    <?php
                    if ($ms['transaction_id'] != $po_id) {
                        continue;
                    } else {
                    }
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= $ms['incoming'] ?></td>
                        <td><?= $ms['price'] ?></td>
                        <?php $subtotal = $ms['incoming'] * $ms['price'] ?>
                        <td><?= $subtotal ?></td>
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
    </form>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->