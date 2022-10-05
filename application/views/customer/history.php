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
            if ($items['status'] == '0') { //show only with status = 1
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
                                <div class="col-1 d-flex justify-content-center align-items-center mx-3">
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
                } else {
                }
            }
        // }
        // 
        endforeach; ?>
    <?php
    } else { ?>
        <div class="alert alert-danger" role="alert">Your haven't made any transaction! Let's make some <a href="<?= base_url('customer/') ?>">here. </a></div>
    <? }
    ?>
</div>

</div>
<!-- /.container-fluid -->