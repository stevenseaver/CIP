<!-- Begin Page Content -->
<div class="no-gutter pt-5 mt-5 bg-light">
    <!-- Core Value Prop 1 -->
    <!-- <div class="no-gutter bg-light mt-1 mb-4">
        <div class="row align-items-center">
            <div class="col-lg text-center">
                <img class="img-fluid rounded" style="width: 100rem;" src="<?= base_url('asset/img/webpage/lebaran2024.png') ?>" alt="Main Cards">
            </div>
        </div>
    </div> -->
    <div class="row mb-2">
        <div class="col-lg mx-3">
            <div class="card shadow border-0 mb-3">
                <div class="card-header align-items-center">
                    <h3 class="font-weight-bold text-primary mb-0">RSVP</h3>
                </div>
                <div class="card-body">
                <form action="<?= base_url('events/add_guest') ?>" method="post">
                    <div class="modal-body">
                        <!-- input event ID -->
                        <div class="form-group">
                            <label for="event_id" class="col-form-label">Event ID</label>
                            <input type="text" readonly class="form-control" id="event_id" name="event_id" value="<?= $event_id; ?>">
                            <?= form_error('event_id', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- input guest ID -->
                        <?php 
                            //randomize guest_id
                            $date = time();
                            $year = date('y');
                            $week = date('W');

                            $n = 3;
                            $result = $year . $week . bin2hex(random_bytes($n));
                            $token = hash('crc32c', $result);
                            $guest_id = 'G'. $token;
                        ?>
                        <div class="form-group">
                            <label for="guest_id" class="col-form-label">Guest ID</label>
                            <input type="text" class="form-control" id="guest_id" name="guest_id" value="<?= $guest_id; ?>">
                            <?= form_error('guest_id', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- input nama -->
                        <div class="form-group">
                            <label for="full_name" class="col-form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Full Name" value="<?= set_value('full_name'); ?>">
                            <?= form_error('full_name', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- input num_pax -->
                        <div class="form-group">
                            <label for="num_pax" class="col-form-label">Number of Pax</label>
                            <input type="number" class="form-control" min="0" id="num_pax" name="num_pax" value="<?= set_value('num_pax'); ?>">
                            <?= form_error('num_pax', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- input seating -->
                        <div class="form-group">
                            <label for="seating" class="col-form-label">Seating</label>
                            <input type="text" class="form-control" id="seating" name="seating" placeholder="Seating/table" value="<?= set_value('seating'); ?>">
                            <?= form_error('seating', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- input address -->
                        <div class="form-group">
                            <label for="address" class="col-form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Guest's address" value="<?= set_value('address'); ?>">
                            <?= form_error('address', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- input email -->
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Guest's email" value="<?= set_value('email'); ?>">
                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- input address -->
                        <div class="form-group">
                            <label for="phone" class="col-form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Guest's phone" value="<?= set_value('phone'); ?>">
                            <?= form_error('phone', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <!-- input user_role -->
                        <div class="form-group">
                            <label for="rsvp_status" class="col-form-label">RSVP</label>
                            <select name="rsvp_status" id="rsvp_status" class="form-control">
                                <option value="">--Select RSVP Status--</option>
                                <option value="0">Pending</option>
                                <option value="1">Confirmed</option>
                                <option value="2">Declined</option>
                            </select>
                            <?= form_error('rsvp_status', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-lg">
                            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                            <button type="submit" class="btn btn-primary">Save RSVP</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="desktop">
        
    </div>
    <!-- For mobile layout -->
    <div class="mobile">
        
    </div>
</div>
<!-- /container-fluid -->