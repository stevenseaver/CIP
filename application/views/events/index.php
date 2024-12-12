<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <!-- Button to edit events data -->
    <a href="" class="btn btn-warning btn-icon-split mb-3" data-toggle="modal" data-target="#editEventData">
        <span class="icon text-white-50">
            <i class="bi bi-pencil-fill"></i>
        </span>
        <span class="text">Edit Events Data</span>
    </a>
    <!-- Button to edit guest lists data -->
    <a href="<?= base_url('events/guest_list'); ?>" class="btn btn-primary btn-icon-split mb-3 ml-1">
        <span class="icon text-white-50">
            <i class="bi bi-pencil-fill"></i>
        </span>
        <span class="text">Edit Guest List</span>
    </a>

    <div class="card rounded shadow border-0 border-left-primary mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-10">
                <div class="card-body">
                    <p class="text-dark mb-1">Event ID : </p>
                    <p class="card-text font-weight-bold text-dark mb-1"><?= $user['event_id']; ?></p>
                    <p class="text-dark mb-1">Event Name : </p>
                    <p class="card-text font-weight-bold text-dark mb-1"><?= $user['event_name']; ?></p>
                    <p class="text-dark mb-1">Start Date : </p>
                    <p class="card-text font-weight-bold text-dark mb-1"><?= date('d F Y H:i:s', $user['event_start_date']);?></p>
                    <p class="text-dark mb-1">End Date : </p>
                    <p class="card-text font-weight-bold text-dark mb-1"><?= date('d F Y H:i:s', $user['event_end_date']);?></p>
                    <p class="text-dark mb-1">Event Location : </p>
                    <p class="card-text font-weight-bold text-dark mb-1"><?= $user['event_location']; ?></p>
                    <p class="card-text text-dark mb-1"><?= $user['address'] . ', ' . $user['city'] . ', ' . $user['province'] . ', ' . $user['country'] . ', ' . $user['postal'] ; ?></p>
                    <p class="text-dark mb-1">Event Description : </p>
                    <p class="card-text font-weight-bold text-dark mb-1"><?= $user['event_description']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 text-start input-group mb-3">
            <input readonly type="text" id="refCode1" class="form-control" value="<?= base_url('web/rsvp?event_id=' . $user['event_id']);?>">
            <button onclick="copyToClipboard()" class="btn btn-outline-secondary">Copy Referal Code</button>
        </div>
    </div>

    <!-- Modal for add items -->
    <div class="modal fade" id="editEventData" tabindex="-1" aria-labelledby="editEventDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventDataLabel">Edit Event Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('events/edit_event_data/') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group row">
                            <!-- event id -->
                            <label for="event_id" class="col-sm-3 col-form-label">Event ID</label>
                            <div class="col-sm-9">
                                <input type="text" readonly class="form-control" id="event_id" name="event_id" value="<?= $user['event_id']; ?>">
                                <?= form_error('event_id', '<small class="text-danger pl-2">', '</small>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- edit event name -->
                            <label for="event_name" class="col-sm-3 col-form-label">Event Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="event_name" name="event_name" value="<?= $user['event_name']; ?>">
                                <?= form_error('event_name', '<small class="text-danger pl-2">', '</small>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- edit event name -->
                            <label for="event_description" class="col-sm-3 col-form-label">Event Description</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="event_description" name="event_description" value="<?= $user['event_description']; ?>">
                                <?= form_error('event_description', '<small class="text-danger pl-2">', '</small>') ?>
                            </div>
                        </div>
                        <?php
                            $start_date = date('Y-m-d\TH:i', $user['event_start_date']);
                            $end_date = date('Y-m-d\TH:i', $user['event_end_date']);
                        ?>
                        <div class="form-group row">
                            <!-- edit event start date -->
                            <label for="event_start_date" class="col-sm-3 col-form-label">Start Date</label>
                            <div class="col-sm-9">
                                <input type="datetime-local" class="form-control" id="event_start_date" name="event_start_date" value="<?= $start_date ?>">
                                <?= form_error('event_start_date', '<small class="text-danger pl-2">', '</small>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- edit event end date -->
                            <label for="event_end_date" class="col-sm-3 col-form-label">End Date</label>
                            <div class="col-sm-9">
                                <input type="datetime-local" class="form-control" id="event_end_date" name="event_end_date" value="<?= $end_date; ?>">
                                <?= form_error('event_end_date', '<small class="text-danger pl-2">', '</small>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- edit address -->
                            <label for="event_location" class="col-sm-3 col-form-label">Location</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="event_location" name="event_location" value="<?= $user['event_location']; ?>">
                                <?= form_error('event_location', '<small class="text-danger pl-2">', '</small>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- edit detailed address -->
                            <label for="address" class="col-sm-3 col-form-label">Address</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="address" name="address" value="<?= $user['address']; ?>">
                                <?= form_error('address', '<small class="text-danger pl-2">', '</small>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label">City/Province</label>
                            <div class="col-sm-4 mb-1">
                                <input type="text" class="form-control form-control-user" id="city" name="city" placeholder="City" value="<?= $user['city']; ?>">
                                <?= form_error('city', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <!-- state/province -->
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-user" id="province" name="province" placeholder="Province or State" value="<?= $user['province']; ?>">
                                <?= form_error('province', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label">Country/Postal</label>
                            <div class="col-sm-6 mb-2">
                                <input type="text" class="form-control form-control-user" id="country" name="country" placeholder="Country" value="<?= $user['country']; ?>">
                                <?= form_error('country', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <!-- zipcode -->
                            <div class="col-sm-3 mb-2">
                                <input type="text" class="form-control form-control-user" id="postal" name="postal" placeholder="Postal Code" value="<?= $user['postal']; ?>">
                                <?= form_error('postal', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>
    function copyToClipboard() {
        // Get the text field
        var copyText = document.getElementById("refCode1");

        // Select the text field
        copyText.select();
        // copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);
    }
</script>