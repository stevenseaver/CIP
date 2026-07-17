<!-- Begin Page Content -->
<div class="container-fluid">

    <div id="bulk-toast" style="
        display: none;
        position: fixed;
        top: 30%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        min-width: 300px;
        max-width: 500px;
    ">
        <div id="bulk-toast-inner" class="alert mb-0 shadow-lg text-center" role="alert">
            <i id="bulk-toast-icon" class="fas fa-exclamation-circle mr-2"></i>
            <span id="bulk-toast-message"></span>
        </div>
    </div>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <!-- back button -->
    <?php $periode = getPeriodeByDate($getID['date']); ?>
    <a href="<?= base_url('production/inputRoll/index?' . http_build_query(['start_date' => $periode['start_date'], 'end_date'   => $periode['end_date'], 'name' => $periode['id'],])) ?>" class="btn btn-white btn-icon-split mb-3">
        <span class="icon text-dark">
            <i class="bi bi-arrow-left text-dark"></i>
        </span>
        <span class="text text-dark">Back</span>
    </a>

    <a href="<?= base_url('production/add_roll/') . $po_id?>" class="btn btn-warning btn-icon-split mb-3" rel="noopener noreferrer">
        <span class="icon text-white">
            <i class="bi bi-pencil-fill"></i>
        </span>
        <span class="text">Edit</span>
    </a>

    <div class="card rounded shadow border-0 mb-3">
        <div class="card-body mb-0">
            <div class="row">
                <div class="col-lg-6">
                    <p class="text-dark mb-1">Prod Order Ref : </p>
                    <p class="text-dark font-weight-bold"> <?= $getID['transaction_id'] ?></p>
                    <p class="text-dark mb-1">Date : </p>
                    <p class="text-dark font-weight-bold"> <?= date('d F Y H:i:s', $getID['date']) ?></p>
                    <p class="text-dark mb-1">Product : </p>
                    <p class="text-dark font-weight-bold"> <?= $getID['product_name'] ?></p>
                    <p class="text-dark mb-1">Batch : </p>
                    <p class="text-dark font-weight-bold"> <?= $getID['description'] ?></p>
                    <p class="text-dark mb-1">Status : </p>
                    <?php if($getID['transaction_status'] == 1){ ?>
                        <td><p class="badge badge-secondary">Order dibuat</p></td>
                    <?php } else if($getID['transaction_status'] == 2){ ?>
                        <td><p class="badge badge-info">Mulai roll</p></td>
                    <?php } else if($getID['transaction_status'] == 3){ ?>
                        <td><p class="badge badge-primary">Roll selesai</p></td>   
                    <?php } else if($getID['transaction_status'] == 4){ ?>
                        <td><p class="badge badge-warning">Mulai potong</p></td>   
                    <?php } else if($getID['transaction_status'] == 5){ ?>
                        <td><p class="badge badge-success">Selesai</p></td>   
                    <?php } else if($getID['transaction_status'] == 6){ ?>
                        <td><p class="badge badge-danger">Butuh perhatian</p></td>   
                    <?php }; ?>
                </div>
                <div class="col-lg-6 text-lg-right">
                    <p class="text-dark mb-1 small">Production ID QR Code</p>
                    <div id="roll-prodID" class="d-inline-block border p-1 rounded"></div>
                    <p class="text-muted small mt-1 mb-0"><?= $getID['transaction_id'] ?></p>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new QRCode(document.getElementById('roll-prodID'), {
                text: "<?= $getID['transaction_id'] ?>",
                width: 100,
                height: 100,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        });
    </script>

    <div class="table-responsive my-3">
        <table class="table table-hover" id="table1" width="100%" cellspacing="0">
            <thead>
                <div class="h5 text-primary">Materials</div>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Item</th>
                    <th>Amount Used</th>
                    <th>Unit Price (IDR)</th>
                    <th class="text-right">Subtotal (IDR)</th>
                    <th>Mix Amount</th>
                    <th>Formula</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $temp = 0;
                $temp_weight= 0;
                ?>
                <?php foreach ($inventory_selected as $ms) : ?>
                    <?php
                    if ($ms['transaction_id'] != $po_id) {
                        continue;
                    } else {
                    }
                    $formula = $ms['outgoing']/($ms['item_desc'])
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= date('d F Y H:i', $ms['date']);?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= number_format($ms['outgoing'], 2, ',', '.') . ' ' . $ms['unit_satuan'];; ?></td>
                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                        <?php $subtotal = $ms['outgoing'] * $ms['price'] ?>
                        <td class="text-right"><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <td><?= $ms['item_desc'] ?></td>
                        <td><?= $formula ?></td>
                    </tr>
                    <?php 
                    $temp = $temp + $subtotal;  
                    if($ms['unit_satuan'] == 'kg') {
                        $temp_weight = $temp_weight + $ms['outgoing'];
                    } else {
                        
                    } ?>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="2"> </td>
                    <td class="text-right"><strong>Total Weight</strong></td>
                    <?php $totalWeight = $temp_weight; ?>
                    <td class="text-left"><?= $this->cart->format_number($totalWeight, '2', ',', '.'); ?> kg</td>
                    <td class="text-right"><strong>Total Value</strong></td>
                    <?php $total = $temp; ?>
                    <td class="text-right">IDR <?= $this->cart->format_number($total, '2', ',', '.'); ?></td>
                    <td class="text-right"><strong>Cost of Materials</strong></td>
                    <?php $hpp = $total/$temp_weight; ?>
                    <td class="text-right">IDR <?= $this->cart->format_number($hpp, '2', ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="table-responsive my-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="h5 text-primary mb-0">Rolls</div>
            <a href="javascript:void(0)" id="printAllRollsBtn" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-70">
                    <i class="fas fa-print"></i>
                </span>
                <span class="text">Print All Rolls</span>
            </a>
        </div>
        <table class="table table-hover" id="table2" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Item</th>
                    <th>Code</th>
                    <th>Weight</th>
                    <th>Lipatan</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th>Batch</th>
                    <th>Roll Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $temp = 0;
                $temp_value = 0;
                $waste = 0;
                $percent_waste = 0;
                $depreciation = 0;
                $percent_depreciation = 0;
                
                $data['items'] = $this->db->get_where('settings', ['parameter' => 'process_waste'])->row_array();
                $max_process_waste = $data['items']['value'];
                $data['items'] = $this->db->get_where('settings', ['parameter' => 'max_waste'])->row_array();
                $max_waste = $data['items']['value'];
                ?>
                <?php foreach ($rollType as $ms) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= date('d F Y H:i', $ms['date']);?></td>
                        <td><?= $ms['name'] ?></td>
                        <td><?= $ms['code'] ?></td>
                        <td><?= $ms['weight'] ?></td>
                        <td><?= $ms['lipatan'] ?></td>
                        <?php if($ms['transaction_desc'] == 'Bulk cut'){ ?>
                            <td class="text-danger">-<?= number_format($ms['outgoing'], 2, ',', '.'); ?> kg</td>
                        <? } else {  ?>
                            <td class="text-primary"><?= number_format($ms['incoming'], 2, ',', '.'); ?> kg</td>
                        <?php }; ?>
                        <td><?= number_format($ms['price'], 2, ',', '.'); ?></td>
                        <?php 
                            $subtotal = $ms['incoming'] * $ms['price'];
                        ?>
                        <td><?= number_format($subtotal, 2, ',', '.'); ?></td>
                        <!-- <td><input id="materialAmount-<?= $ms['id'] ?>" class="material-qty text-left form-control" data-id="<?= $ms['id']; ?>" data-prodID="<?= $ms['transaction_id'] ?>" value="<?= number_format($ms['incoming'], 2, ',', '.'); ?>"></td> -->
                        <td><?= $ms['batch'] ?></td>
                        <td><?= $ms['transaction_desc'] ?></td>
                        <td>
                            <a data-toggle="modal" data-target="#printDetails"
                                data-po="<?= $ms['transaction_id'] ?>"
                                data-id="<?= $ms['id'] ?>"
                                data-batch="<?= $ms['batch'] ?>"
                                data-name="<?= $ms['name'] ?>"
                                data-itemcode="<?= $ms['code'] ?>"
                                data-amount="<?= $ms['incoming'] ?>"
                                data-weight="<?= $ms['weight'] ?>"
                                data-lipatan="<?= $ms['lipatan'] ?>"
                                data-desc="<?= $ms['transaction_desc'] ?>"
                                class="badge badge-primary clickable mr-1 printLabelLink">
                                <i class="fas fa-print mr-1"></i>Print
                            </a>
                        </td>
                    </tr>
                    <?php 
                        $temp = $temp + $ms['incoming'];
                        $temp_value = $temp_value + $subtotal;

                        $avalan = "avalan";
                        $prongkolan = "prongkolan";
                        $avalan_name = "AVALAN ROLL";
                        $prongkolan_name = "PRONGKOLAN ROLL";

                        $sim_av = similar_text($ms['transaction_desc'], $avalan, $percent_av);
                        $sim_prong = similar_text($ms['transaction_desc'], $prongkolan, $percent_prong);

                        if($percent_av > 50 or $percent_prong > 50 or $ms['name'] == $avalan_name or $ms['name'] == $prongkolan_name){
                            $waste = $waste + $ms['incoming'];
                        };

                        $i++;
                    ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="text-right">
                <tr class="align-items-center">
                    <td colspan="5"> </td>
                    <td class="text-left"><strong>Total Weight</strong></td>
                    <?php $total = $temp; ?>
                    <td class="text-left"><?= $this->cart->format_number($total, '2', ',', '.'); ?> kg</td>
                    <td class="text-right"><strong>Production Value</strong></td>
                    <?php $grandTotal = $temp_value; ?>
                    <td class="text-left">Rp <?= $this->cart->format_number($grandTotal, '2', ',', '.'); ?></td>
                    <td class="text-right"><strong>Process Waste</strong></td>
                    <?php $depreciation = $temp-$totalWeight;
                    $percent_depreciation = ($depreciation / $totalWeight) * 100;
                    if ($percent_depreciation <= $max_process_waste) {?>
                        <td class="text-left text-danger"><?= $this->cart->format_number($depreciation, '2', ',', '.'); ?> kg or <?= $this->cart->format_number($percent_depreciation, '2', ',', '.'); ?>%</td>
                    <?php } else { ?>
                         <td class="text-left text-success"><?= $this->cart->format_number($depreciation, '2', ',', '.'); ?> kg or <?= $this->cart->format_number($percent_depreciation, '2', ',', '.'); ?>%</td>
                    <?php }?>
                </tr>
                <tr class="align-items-center">
                    <td colspan="5"> </td>
                    <td class="text-left"><strong>Net Roll Weight</strong></td>
                    <?php $net_weight = $total - $waste; ?>
                    <td class="text-left text-primary"><?= number_format($net_weight, '2', ',', '.'); ?> kg</td>
                    <td colspan="2"> </td>
                    <td class="text-right"><strong>Extrusion Waste</strong></td>
                    <?php $percent_waste = ($waste / $totalWeight) * 100; 
                    if ($percent_waste >= $max_waste) {?>
                        <td class="text-left text-danger"><?= number_format($waste, '2', ',', '.'); ?> kg or <?= number_format($percent_waste, '2', ',', '.'); ?>%</td>
                    <?php } else { ?>
                        <td class="text-left text-success"><?= number_format($waste, '2', ',', '.'); ?> kg or <?= number_format($percent_waste, '2', ',', '.'); ?>%</td>
                    <?php }?>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal For Print -->
<div class="modal fade" id="printDetails" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-print mr-2"></i>Print Label Roll</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <p class="mx-3 mt-3 mb-0 text-muted">Double check data before printing!</p>
            <form action="<?= base_url('production/print_general_ticket') ?>" method="get">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="field-label">Production ID</label>
                        <input type="text" class="form-control" id="po_id_print" name="po_id" readonly>
                        <input type="hidden" id="id_print" name="id">

                        <label class="field-label mt-3">Batch</label>
                        <input type="text" class="form-control" id="print_batch" name="batch" readonly>

                        <label class="field-label mt-3">Item</label>
                        <input type="text" class="form-control" id="name_print" name="name" readonly>

                        <label class="field-label mt-3">Code</label>
                        <input type="text" class="form-control" id="code_print" name="code" readonly>

                        <label class="field-label mt-3">Gramatur</label>
                        <input type="text" class="form-control" id="gram_print" name="gram" readonly>

                        <label class="field-label mt-3">Gusset / Lipatan</label>
                        <input type="text" class="form-control" id="guset_print" name="guset" readonly>

                        <label class="field-label mt-3">Net Weight</label>
                        <div class="input-group">
                            <input type="number" step=".01" class="form-control" id="amount_print" name="amount" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>

                        <label class="field-label mt-3">Description</label>
                        <input type="text" class="form-control" id="desc_print" name="desc" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"></i>Tutup</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-print mr-1"></i>Print</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var table1 = $('#table1').DataTable({
        paging: true,
        select: {
            style: 'single'
        },
        columnDefs: [
            {
                targets:[0,1,2,3],
                orderable: true,
                searchable: true
            }
        ]

    });
    var table2 = $('#table2').DataTable({
        paging: true,
        select: {
            style: 'single'
        },
        columnDefs: [
            {
                targets:[0,1,2,3],
                orderable: true,
                searchable: true
            }
        ]

    });

    //print via new tab iframe
    $('#printDetails form').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);

        var tempForm = $('<form>', {
            action: '<?= base_url('production/print_general_ticket') ?>',
            method: 'POST',
            target: '_blank'
        });

        // Add type field
        $('<input>').attr({ type: 'hidden', name: 'type', value: '2' }).appendTo(tempForm);

        // Copy all fields
        form.find('input, select, textarea').each(function() {
            $('<input>').attr({
                type: 'hidden',
                name: $(this).attr('name'),
                value: $(this).val()
            }).appendTo(tempForm);
        });

        tempForm.appendTo('body').submit().remove();
        $('#printDetails').modal('hide');
    });

    $('#printAllRollsBtn').on('click', function () {
        var items = [];

        $('#table2 tbody tr').each(function () {
            var $link = $(this).find('a.printLabelLink');
            if ($link.length === 0) return;

            var name = ($link.data('name') || '').toString().toUpperCase();
            var desc = ($link.data('desc') || '').toString().toLowerCase();

            // Exclude AVALAN / PRONGKOLAN / BULK CUT rows
            var isExcluded =
                name === 'AVALAN ROLL' ||
                name === 'PRONGKOLAN ROLL' ||
                desc.indexOf('avalan') !== -1 ||
                desc.indexOf('prongkolan') !== -1 ||
                desc === 'bulk cut';

            if (isExcluded) return;

            items.push({
                id:     $link.data('id'),
                po_id:  $link.data('po'),
                batch:  $link.data('batch'),
                name:   $link.data('name'),
                code:   $link.data('itemcode'),
                amount: $link.data('amount'),
                gram:   $link.data('weight'),
                guset:  $link.data('lipatan'),
                desc:   $link.data('desc')
            });
        });

        if (items.length === 0) {
            // alert('No printable rolls found (all rows are Avalan, Prongkolan, or Bulk cut).');
            showBulkAlert('No printable rolls found (all rows are Avalan, Prongkolan, or Bulk cut).', 'danger');
            return;
        }

        var tempForm = $('<form>', {
            action: '<?= base_url('production/print_general_ticket') ?>',
            method: 'POST',
            target: '_blank'
        });

        $('<input>').attr({ type: 'hidden', name: 'type', value: '3' }).appendTo(tempForm);
        $('<input>').attr({ type: 'hidden', name: 'items', value: JSON.stringify(items) }).appendTo(tempForm);

        tempForm.appendTo('body').submit().remove();
    });
</script>