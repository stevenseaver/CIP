<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-dark"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-6 mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="card border-left-primary mb-3">
        <div class="input-group mx-3 my-3">
            <h5 class="text-dark mr-3 mb-3">Edit number of materials:</h5>
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
        </div>

        <div class="row input-group mx-3">
            <div class="form-group col-lg-5 mr-2">
                <text class="mb-1" for="roll-type">Type</text>
                <select name="rolltype" id="rolltype" class="form-control select-roll">
                    <option value="">--Select [ROLL] Product--</option>
                    <?php foreach ($rollType as $rt) : ?>
                        <option data-target="#rolltype" data-code="<?= $rt['code'] ?>" value="<?= $rt['id'] ?>"><?= $rt['name'] ?></option>
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

        <!-- <div class="row input-group mx-3">
            <div class="form-group col-lg-6">
                <input type="text" class="form-control" id="materials" name="quantity">
            </div>
            <div class="form-group col-lg-3">
                <input type="text" class="form-control" id="formula" name="formula">
            </div>
            <div class="form-group col-lg-1">
                <input type="text" class="form-control" id="total-weight" name="total-weight">
            </div>
            <div class="form-group col-lg-1">
                <input type="text" class="form-control" id="total-price" name="total-price">
            </div>
        </div> -->
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->