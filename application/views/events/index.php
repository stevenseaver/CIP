<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="card border-left-primary mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-10">
                <div class="card-body">
                    <!-- <h5 class="card-text mb-2">Delivery Address</h5> -->
                    <p class="card-text font-weight-bold text-dark mb-1"><?= $user['event_id']; ?></p>
                    <p class="card-text text-dark mb-1"><?= $user['event_name']; ?></p>
                    <p class="card-text text-dark mb-1"><?= date('d F Y H:i:s', $user['event_start_date']);?></p>
                    <p class="card-text text-dark mb-1"><?= date('d F Y H:i:s', $user['event_end_date']);?></p>
                    <p class="card-text text-dark mb-1"><?= $user['event_location']; ?></p>
                    <p class="card-text text-dark mb-1"><?= $user['event_description']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->