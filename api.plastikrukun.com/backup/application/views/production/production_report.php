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
                $current_time = time();
                $year = 0; 
                $year = date('Y', $current_time);
                foreach($periode as $per) : 
                    if($per['year'] == $year or $per['year'] == '0') { ?>
                        <a class="dropdown-item" href="<?= base_url('production/index?start_date=' . $per['start_date'] . '&end_date=' . $per['end_date'] . '&name=' . $per['id'])?>" onclick="select_date($per['id'])"><?= $per['period'];?></a>
                    <?php
                    }
                    else { 

                    };
                endforeach; ?>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <?php
        $date = time();
        $year = date('y');
        $week = date('W');
        $day = date('d');
        // $serial = rand(1000, 9999);

        // ref invoice
        $n = 2;
        $result = bin2hex(random_bytes($n));
        $po_id = 'P' . $year . $day . $result . $week;
    ?>

    <a href="<?= base_url('production/add_prod/') . $po_id ?>" class="btn btn-primary btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Production Order</span>
    </a>

    <?php if ($materialStock != null) {
        $i = 1;
        $temp = 0;
        $before = '';
    ?>
    
    <div class="card border-left-primary mb-3">
        <div class="row mx-4 my-3">
            <div class="table-responsive">
                <table class="table table-hover" id="prodTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Production ID</th>
                            <th>Date</th>
                            <th>Product Name</th>
                            <th>Batch</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        $temp = 0; ?>
                        <?php foreach ($materialStock as $inv) :
                            if ($before != $inv['transaction_id']) { ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $inv['transaction_id'] ?></td>
                                    <td><?= date('d F Y H:i:s', $inv['date']); ?></td>
                                    <td><?= $inv['product_name'] ?></td>
                                    <td><?= $inv['description'] ?></td>
                                    <?php $value = $inv['price'] * $inv['in_stock'];
                                    $temp = $temp + $value;  ?>
                                    <?php if($inv['transaction_status'] == 1){ ?>
                                        <td><p class="badge badge-secondary">Order dibuat</p></td>
                                    <?php } else if($inv['transaction_status'] == 2){ ?>
                                        <td><p class="badge badge-info">Mulai roll</p></td>
                                    <?php } else if($inv['transaction_status'] == 3){ ?>
                                        <td><p class="badge badge-primary">Roll selesai</p></td>   
                                    <?php } else if($inv['transaction_status'] == 4){ ?>
                                        <td><p class="badge badge-warning">Mulai potong</p></td>   
                                    <?php } else if($inv['transaction_status'] == 5){ ?>
                                        <td><p class="badge badge-success">Selesai</p></td>   
                                    <?php } else if($inv['transaction_status'] == 6){ ?>
                                        <td><p class="badge badge-danger">Butuh perhatian</p></td>   
                                    <?php }; ?>
                                    <td>
                                        <a href="<?= base_url('production/prod_details/') . $inv['transaction_id'] ?>" class="badge badge-primary clickable"><i class="bi bi-info-circle-fill"> </i>Details</a>
                                        <a href="<?= base_url('production/edit_prod/') . $inv['transaction_id'] ?>" class="badge badge-warning clickable"><i class="bi bi-pencil-fill"> </i>Edit</a>
                                        <?php if ($inv['transaction_status'] == 1){ ?>
                                            <a data-toggle="modal" data-target="#deletePOModal" data-po="<?= $inv['transaction_id']  ?>" class="badge badge-danger clickable"><i class="bi bi-trash-fill"> </i>Delete Production Order</a>
                                        <?php } else { ?>
                                            <a href="" class="badge badge-secondary clickable" disabled><i class="bi bi-trash-fill"> </i>Delete Production Order</a>
                                        <?php }; ?>
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
            <p class="mx-3 mt-3 mb-0">Deleting active production order are illegal and would be treated under penalty of treason. Unless this is an inactive production order, are you sure to delete?</p>
            <form action="<?= base_url('production/delete_all_prod_order/') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- item id -->
                        <label for="delete_po_id" class="col-form-label">Production Order ID</label>
                        <input type="text" class="form-control" id="delete_po_id" name="delete_po_id" readonly>
                    </div>
                    <div class="form-group">
                        <!-- confirm key -->
                        <label for="confirm_key" class="col-form-label">Confirm Key</label>
                        <p for="confirm_key" class="col-form-label">Mohon tulis "hapus" di kolom dibawah ini:</p>
                        <input type="text" class="form-control" id="confirm_key" name="confirm_key">
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
    var table = $('#prodTable').DataTable({
        order: [2, 'asc']
    });
</script>