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
                        <div class="card-body">
                            <div class="row text-left">
                                <div class="col-1 d-flex mx-2">
                                    <h1 class=""> <?= $i ?></h1>
                                </div>
                                <div class="col d-flex flex-column justify-content-center mb-0">
                                    <div class="">
                                        <h5 class="text-primary font-weight-bold mb-1"><?= $items['ref']; ?></h5>
                                    </div>
                                    <div class="">
                                        <p class="small mb-0"><?= date('d F Y H:i', $items['date']);  ?></p>
                                    </div>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center mx-3">
                                    <?php if($items['status'] == 1){ ?> 
                                        <p class="mr-3 my-3 text-center">
                                            <span class="icon text-warning mx-2">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </span>
                                            <span class="text-warning">Confirming</span>
                                        </p>
                                    <?php } else if($items['status'] == 2){ ?> 
                                        <p class="mr-3 my-3 text-center">
                                            <span class="icon text-primary mx-2">
                                                <i class="bi bi-truck"></i>
                                            </span>
                                            <span class="text-primary">Delivering</span>
                                        </p>
                                    <?php } else if($items['status'] == 3){ ?> 
                                        <p class="mr-3 my-3 text-center">
                                            <span class="icon text-success mx-2">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </span>
                                            <span class="text-success">Delivered</span>
                                        </p>
                                    <?php } else if($items['status'] == 4){ ?> 
                                        <p class="mr-3 my-3 text-center">
                                            <span class="icon text-danger mx-2">
                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                            </span>
                                            <span class="text-danger">Declined</span>
                                        </p>
                                    <?php } ?>
                                    <a href="<?= base_url('customer/history_details/') . $items['ref'] . '/' . $items['date'] . '/' . $items['status'] ?>">
                                        <i class="bi bi-list-check" style="font-size: 2rem;"></i>
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