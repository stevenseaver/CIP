<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="h3 text-gray-800"><?= $title ?></div>
        <?php 
            $data['items'] = $this->db->get_where('settings', ['parameter' => 'header_color'])->row_array();
            $color = $data['items']['value'];
        ?>
    
        <div class="dropdown text-center my-2">
            <!-- <button class="btn text-<?= $color?> bi bi-caret-left-fill" onclick="left_click()" type="button">
            </button> -->
            <button class="btn btn-<?= $color?> dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                <a id="periode_show" name="periode_show"><?= $current_periode ?></a>
            </button>
            <!-- <button class="btn text-<?= $color?> bi bi-caret-right-fill" onclick="right_click()" type="button">
            </button> -->
    
            <div class="dropdown-menu">
                <?php $j = 0; 
                foreach($periode as $per) : ?>
                    <a class="dropdown-item" href="<?= base_url('production/usage?start_date=' . $per['start_date'] . '&end_date=' . $per['end_date'] . '&name=' . $per['id'])?>" onclick="select_date($per['id'])"><?= $per['period'];?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    
    <?php if ($usagePerItem != null) {
        $i = 1;
        $temp = 0;
        $temp1 = 0;
        $total_weight = 0;
        $total_item = 0;
        $before = '';
    ?>
    <div class="card rounded border-0 shadow mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Production Usage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usagePerItem as $items) :
                                if ($before != $items['name']) { ?>
                                <tr>
                                    <td><?= $items['name']; ?></td>
                                    <td>
                                        <?php 
                                            foreach ($usagePerItem as $amount) :
                                                if ($amount['name'] == $items['name'] and $amount['unit_satuan'] == 'kg') {
                                                    $temp = $temp + $amount['outgoing']; 
                                                } else if($amount['name'] == $items['name']){
                                                    $temp1 = $temp1 + $amount['outgoing']; 
                                                };
                                            endforeach;
                                            if ($items['unit_satuan'] == 'kg') {
                                                echo number_format($temp , 2, ',', '.') . ' '. $items['unit_satuan']; 
                                            } else { 
                                                echo number_format($temp1 , 2, ',', '.') . ' '. $items['unit_satuan']; 
                                            };
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                    $before = $items['name'];
                                    $total_weight = $total_weight + $temp;
                                    $total_item = $total_item + $temp1;
                                    $temp = 0;
                                    $temp1 = 0;
                                    $i++;
                            } else {
                            };
                            endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right"><strong>Total</strong></td>
                                <td><?= number_format($total_weight, 2, ',', '.') . ' kg and ' . number_format($total_item, 2, ',', '.') . ' pcs'; ?></td>
                            </tr>
                        </tfoot>
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
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Yipikay yay!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="mx-3 mt-3 mb-0">Are you sure this is paid?</p>
            <form action="<?= base_url('purchasing/paid/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- item id -->
                        <label for="url" class="col-form-label">Invoice ID</label>
                        <input type="text" class="form-control" id="ref_id" name="ref_id" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Pay</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function left_click() {
        document.getElementById("periode_show").innerHTML = 'LEFT';
    }

    function right_click() {
        document.getElementById("periode_show").innerHTML = 'RIGHT';
    }
</script>