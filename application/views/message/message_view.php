<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col">
            <?= $this->session->flashdata('message'); ?>

            <div class="card shadow border-left-primary mb-4">
                <div class="card-header py-2">
                    <h5 class="m-0 font-weight-bold text-primary">Message</h5>
                </div>
                <div class="card-body">
                    <a href="<?= base_url("contact/"); ?>" class="btn btn-primary mb-3 text-white">Refresh</a>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($message as $m) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td><?= $m['name']; ?></td>
                                        <td><?= $m['email']; ?></td>
                                        <td><?= $m['message']; ?></td>
                                        <td>
                                            <a data-toggle="modal" data-target="#replyModal" class="badge badge-primary text-white clickable" data-email="<?= $m['email']; ?>">Reply</a>
                                            <a href="<?= base_url('contact/deletemessage/') . $m['id'] ?>" class="badge badge-danger">Delete</a>
                                        </td>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                        <small class="text-primary pb-1">*) Message are shown from database. </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<!-- Modal For Reply Message -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">Add New Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('contact/send_message') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- TO:email -->
                        <label for="email" class="">Send email to:</label>
                        <input type="text" class="form-control" id="email" name="email" readonly>
                        <?= form_error('menu', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Subject -->
                        <label for="subject" class="">Subject:</label>
                        <input type="text" class="form-control" id="subject" name="subject">
                        <?= form_error('menu', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Message -->
                        <label for="message" class="">Message:</label>
                        <textarea type="text" class="form-control" id="message" name="message" rows="3" placeholder=""></textarea>
                        <?= form_error('menu', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>