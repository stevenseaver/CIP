<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-dark"><?= $title ?> Calculator</h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="card border-left-primary mb-3">
        <!-- <div class="input-group mx-3 my-3">
            <text class="text-dark mr-3 mb-3">Edit number of materials:</text>
            <span class="input-group">
                <button type="button" class="quantity-left-minus btn btn-danger btn-circle" data-type="minus" data-field="">
                    <span class="bi bi-dash-lg"></span>
                </button>
                <div class="form-group mx-3">
                    <input type="text" class="form-control" id="quantity" name="quantity" value="5" min="1" max="100">
                    <?= form_error('campuran', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
                <button type="button" class="quantity-right-plus btn btn-success btn-circle" data-type="plus" data-field="">
                    <span class="bi bi-plus-lg"></span>
                </button>
            </span>
        </div> -->

        <div class="row input-group mx-3 mt-3">
            <div class="form-group col-lg-5 mr-2">
                <text class="mb-1" for="roll-type">Goods</text>
                <select name="rolltype" id="rolltype" class="form-control">
                    <option value="">--Select [ROLL] Product--</option>
                    <?php foreach ($rollType as $rt) : ?>
                        <?php if ($rt['status'] != 7) {
                            continue;
                        } else {
                        }
                        ?>
                        <option class="#rolltype" value="<?= $rt['id'] ?>" data-code="<?= $rt['code'] ?>" data-weight="<?= $rt['weight'] ?>" data-lipatan="<?= $rt['lipatan'] ?>"><?= $rt['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-lg-2 mr-3">
                <text class="mb-1" for="code">Code</text>
                <input type="text" class="form-control" id="code" name="code" readonly>
            </div>
            <div class="form-group col-lg-2 mr-3">
                <text class="mb-1" for="weight">Weight</text>
                <input type="text" class="form-control" id="weight" name="weight" readonly>
            </div>
            <div class="form-group col-lg-2 mr-3">
                <text class="mb-1" for="lipatan">Lip</text>
                <input type="text" class="form-control" id="lipatan" name="lipatan" readonly>
            </div>
        </div>


        <form class="user" method="post" action="<?= base_url('Production/calculateCOGS') ?>">
            <div class="row input-group mx-3">
                <div class="form-group col-lg-5">
                    <span>Materials</span>
                    <select name="materialSelect" id="materialSelect" class="form-control" value="<?= set_value('materialSelect'); ?>">
                        <option value="">--Select Material--</option>
                        <?php foreach ($materialStock as $ms) : ?>
                            <?php if ($ms['status'] == 7) { ?>
                                <!-- <option value="<?= $ms['name'] ?>"><?= $ms['name'] ?></option> -->
                                <option class="#materialSelect" value="<?= $ms['name'] ?>" data-price="<?= $ms['price'] ?>" data-stock="<?= $ms['in_stock'] ?>"><?= $ms['name'] ?></option>
                            <?php } else {
                            } ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-1">
                    <span>Formula</span>
                    <input type="text" class="form-control" id="inputFormula" name="inputFormula" value="<?= set_value('inputFormula'); ?>">
                </div>
                <div class="form-group col-lg-1">
                    <span>Weight</span>
                    <input type="text" class="form-control" id="weight" name="weight" readonly value="<?= set_value('weight'); ?>">
                </div>
                <div class="form-group col-lg-1">
                    <span>Stock</span>
                    <input type="text" class="form-control" id="stock" name="stock" readonly value="<?= set_value('stock'); ?>">
                </div>
                <div class="form-group col-lg-1">
                    <span>Price</span>
                    <input type="text" class="form-control" id="price" name="price" readonly value="<?= set_value('price'); ?>">
                </div>
                <div class="form-group col-lg-2">
                    <span>Sub Total</span>
                    <input type="text" class="form-control" id="subtotal" name="subtotal" readonly value="<?= set_value('subtotal'); ?>">
                </div>
            </div>
            <button type="submit" onclick="" class="btn btn-primary mx-4 my-2">Calculate Data</button>
        </form>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->