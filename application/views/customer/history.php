<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900"><?= $title ?></h1>
    <div class="row">
        <div class="col mb-0">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <?php if ($dataCart != null) {
        $i = 1;
        $temp = 0;
        $before = '';

        foreach ($dataCart as $items) :
            if ($items['status'] == '0') { //show other than status = 0
                continue;
            } else {  
                if ($before != $items['ref']) { ?>
                    <div class="card rounded border-0 shadow mb-3">
                        <div class="card-body justify-content-center">
                            <div class="row text-center align-items-center">
                                <div class="col-lg-7 mb-0 text-lg-left text-xs-center">
                                    <div class="">
                                        <h5 class="text-primary font-weight-bold mb-1"><?= $items['ref']; ?></h5>
                                    </div>
                                    <div class="">
                                        <p class="small mb-0"><?= date('d F Y H:i', $items['date']);  ?></p>
                                    </div>
                                </div>
                                <div class="col-lg-3 text-lg-right text-xs-center">
                                    <?php if($items['status'] == 1){ ?> 
                                        <p class="mr-3 my-3">
                                            <span class="icon text-warning mx-2">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </span>
                                            <span class="text-warning">In Progress</span>
                                        </p>
                                    <?php } else if($items['status'] == 2){ ?> 
                                        <p class="mr-3 my-3">
                                            <span class="icon text-primary mx-2">
                                                <i class="bi bi-truck"></i>
                                            </span>
                                            <span class="text-primary">Delivering</span>
                                        </p>
                                    <?php } else if($items['status'] == 3){ ?> 
                                        <p class="mr-3 my-3">
                                            <span class="icon text-success mx-2">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </span>
                                            <span class="text-success">Delivered</span>
                                        </p>
                                    <?php } else if($items['status'] == 4){ ?> 
                                        <p class="mr-3 my-3">
                                            <span class="icon text-danger mx-2">
                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                            </span>
                                            <span class="text-danger">Declined</span>
                                        </p>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-2 d-flex align-items-center justify-content-center text-center">
                                    <a href="<?= base_url('customer/history_details/') . $items['ref'] . '/' . $items['date'] . '/' . $items['status'] ?>">
                                        <div class="">
                                            <i class="bi bi-question-circle" style="font-size: 1rem;"></i>
                                        </div>
                                        <div class="text-xs-center text-lg-right">
                                           More info
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                    $before = $items['ref'];
                    $i++;
                }
            }
        endforeach; ?>
    <?php
    } else { ?>
        <div class="row mx-3 my-0 justify-content-center">
            <h1 class="text-gray-400"><i class="bi bi-cash-coin fa-5x"></i></h1>
        </div>
        <div class="row mx-3 justify-content-center">
            <div class="" role="alert">Your haven't made any transaction! Let's make some <a href="<?= base_url('customer/') ?>">here. </a></div>
        </div>
    <? }
    ?>
</div>

</div>
<!-- /.container-fluid -->