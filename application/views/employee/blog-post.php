<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900"><?= $title ?></h1>
    <?= $this->session->flashdata('message'); ?>

    <!-- Add new asset inventory -->
    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newPostModal">
        <span class="icon text-white-50">
            <i class="bi bi-plus-lg"></i>
        </span>
        <span class="text">Add New Post</span>
    </a>

    <div class="card border-left-primary mb-4">
        <div class="card-body">
            <a href="<?= base_url("blog/blogpost"); ?>" class="btn btn-primary mb-3 text-white">Refresh</a>
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Author</th>
                            <th>Type</th>
                            <th>Title</th>
                            <th>Meta</th>
                            <th>Summary</th>
                            <th>Date Created</th>
                            <th>Date Uploaded</th>
                            <th>Content</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php
                        if ($user['role_id'] == 1) { ?>
                            <?php foreach ($blogdata as $bd) : ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $bd['name'] ?></td>
                                    <td><?= $bd['type_name']; ?></td>
                                    <td><?= $bd['title']; ?></td>
                                    <td><?= $bd['metaTitle']; ?></td>
                                    <td><?= $bd['summary']; ?></td>
                                    <td><?= date('d F Y', $bd['date_created']) ?></td>
                                    <td><?= date('d F Y', $bd['updated_at']) ?></td>
                                    <td><?= $bd['content']; ?></td>
                                    <td><img class="img-fluid rounded" src="<?= base_url() . $bd['image'] ?>" alt="" style="width: 15rem;"></td>
                                    <td>
                                        <?php if ($bd['status'] == 1) {
                                            echo '<p class="badge badge-success">Approved</p>';
                                        } else if ($bd['status'] == 0) {
                                            echo '<p class="badge badge-warning">Reviewing</p>';
                                        } else if ($bd['status'] == 2) {
                                            echo '<p class="badge badge-danger">Declined</p>';
                                        } ?>
                                    </td>
                                    <td>
                                        <a data-toggle="modal" data-target="#editPostModal" data-id="<?= $bd['id'] ?>" data-title="<?= $bd['title'] ?>" data-meta="<?= $bd['metaTitle'] ?>" data-summary="<?= $bd['summary'] ?>" data-content="<?= $bd['content'] ?>" class="badge badge-warning clickable">Edit</a>
                                        <a data-toggle="modal" data-target="#deletePostModal" data-id="<?= $bd['id'] ?>" data-title="<?= $bd['title'] ?>" class="badge badge-danger clickable">Delete</a>
                                        <?php
                                        if ($user['role_id'] == '1') { ?>
                                            <a href="<?= base_url('employee/approve/') . $bd['id'] ?>" class="badge badge-success clickable">Approve Upload</a>
                                            <a href="<?= base_url('employee/decline/') . $bd['id'] ?>" class="badge badge-danger clickable">Decline Upload</a>
                                        <?php } else { ?>

                                        <?php }
                                        ?>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        <? } else { ?>
                            <?php foreach ($blogdata as $bd) : ?>
                                <?php
                                if ($bd['author_id'] != $user['name']) {
                                    continue;
                                } else {
                                }
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $bd['author_id'] ?></td>
                                    <td><?= $bd['type_name']; ?></td>
                                    <td><?= $bd['title']; ?></td>
                                    <td><?= $bd['metaTitle']; ?></td>
                                    <td><?= $bd['summary']; ?></td>
                                    <td><?= date('d F Y', $bd['date_created']) ?></td>
                                    <td><?= date('d F Y', $bd['updated_at']) ?></td>
                                    <td><?= $bd['content']; ?></td>
                                    <td><img class="img-fluid rounded" src="<?= base_url() . $bd['image'] ?>" alt="" style="width: 15rem;"></td>
                                    <td>
                                        <?php if ($bd['status'] == 1) {
                                            echo '<p class="badge badge-success">Approved</p>';
                                        } else if ($bd['status'] == 0) {
                                            echo '<p class="badge badge-warning">Reviewing</p>';
                                        } else if ($bd['status'] == 2) {
                                            echo '<p class="badge badge-danger">Declined</p>';
                                        } ?>
                                    </td>
                                    <td>
                                        <a data-toggle="modal" data-target="#editPostModal" data-id="<?= $bd['id'] ?>" data-title="<?= $bd['id'] ?>" data-summary="<?= $bd['summary'] ?>" data-meta="<?= $bd['metaTitle'] ?>" data-content="<?= $bd['content'] ?>" class="badge badge-warning text-white clickable">Edit</a>
                                        <a data-toggle="modal" data-target="#deletePostModal" data-id="<?= $bd['id'] ?>" data-title="<?= $bd['title'] ?>" class="badge badge-danger clickable">Delete</a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        <? } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<!-- Modal For Add Data -->
<div class="modal fade" id="newPostModal" tabindex="-1" aria-labelledby="newPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPostModalLabel">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <form action="<?= base_url('employee/add_post') ?>" method="post" id="form_id"> -->
            <div class="modal-body">
                <?= form_open_multipart('employee/add_post'); ?>
                <div class="form-group">
                    <input type="text" class="form-control" id="author_id" name="author_id" placeholder="<?= $user['id'] ?>" value="<?= $user['id'] ?>" value="<?= set_value('author_id'); ?>" style="display:none">
                </div>
                <div class=" form-group">
                    <!-- asset type -->
                    <label for="type" class="col-form-label">Post Type</label>
                    <div class="mb-1">
                        <select name="type" id="type" class="form-control" value="<?= set_value('type') ?>">
                            <option value="">--Select Type--</option>
                            <?php foreach ($post_type as $type) : ?>
                                <option value="<?= $type['id'] ?>"><?= $type['type_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('type', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="form-group">
                    <!-- Post Title -->
                    <label for="title" class="col-form-label">Post Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Create unique and memorable title for your post" value="<?= set_value('title'); ?>">
                    <?= form_error('title', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class="form-group">
                    <!-- Meta Title -->
                    <label for="meta" class="col-form-label">Meta Title</label>
                    <input type="meta" class="form-control" id="meta" name="meta" placeholder="Meta for SEO and stuffs" value="<?= set_value('meta'); ?>">
                    <?= form_error('meta', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class="form-group">
                    <!-- Summary -->
                    <label for="summary" class="col-form-label">Summary</label>
                    <input type="text" class="form-control" id="summary" name="summary" placeholder="What's this post mainly about?" value="<?= set_value('summary'); ?>">
                    <?= form_error('summary', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class="form-group">
                    <!-- Content -->
                    <label for="content" class="col-form-label">Content</label>
                    <!-- <div type="text" class="form-control" id="content_rich" name="content_rich"></div> -->
                    <textarea type="text" class="form-control" id="content" name="content" placeholder="Pour your ideas here..."></textarea>
                    <?= form_error('content', '<small class="text-danger pl-2">', '</small>') ?>
                    <pre><code id=""></code></pre>
                </div>
                <div class="form-group">
                    <label for="image" class="col-form-label">Image</label>
                    <div class="custom-file">
                        <!-- Image -->
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                        <small class="text-primary">Maximum 5 MB</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Post</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal For Edit Data -->
<div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPostModalLabel">Edit Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open_multipart('employee/edit_post'); ?>
                <div class="form-group">
                    <!-- Post Title -->
                    <label for="title" class="col-form-label">Post ID</label>
                    <input readonly type="text" class="form-control" id="id" name="id">
                    <?= form_error('id', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class=" form-group">
                    <!-- post type -->
                    <label for="type" class="col-form-label">Post Type</label>
                    <div class="mb-1">
                        <select name="type" id="type" class="form-control" value="<?= set_value('type') ?>">
                            <option value="">--Select Type--</option>
                            <?php foreach ($post_type as $type) : ?>
                                <option value="<?= $type['id'] ?>"><?= $type['type_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('type', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                </div>
                <div class="form-group">
                    <!-- Post Title -->
                    <label for="title" class="col-form-label">Post Title</label>
                    <input type="text" class="form-control" id="title" name="title">
                    <?= form_error('title', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class="form-group">
                    <!-- Meta Title -->
                    <label for="meta" class="col-form-label">Meta Title</label>
                    <input type="meta" class="form-control" id="meta" name="meta">
                    <?= form_error('meta', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class="form-group">
                    <!-- Summary -->
                    <label for="summary" class="col-form-label">Summary</label>
                    <input type="text" class="form-control" id="summary" name="summary">
                    <?= form_error('summary', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class="form-group">
                    <!-- Content -->
                    <label for="content" class="col-form-label">Content</label>
                    <textarea type="text" class="form-control" id="content" name="content"></textarea>
                    <?= form_error('content', '<small class="text-danger pl-2">', '</small>') ?>
                </div>
                <div class="form-group">
                    <label for="image" class="col-form-label">Image</label>
                    <div class="custom-file">
                        <!-- Image -->
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                        <small class="text-primary">Maximum 5 MB</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Edit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal For Delete Data -->
<div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="deletePostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePostModalLabel">Delete Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('employee/delete_post') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Post ID -->
                        <label for="id" class="col-form-label">Post ID</label>
                        <input type="text" class="form-control mb-1" readonly id="delete_id" name="delete_id">
                        <?= form_error('id', '<small class="text-danger pl-2">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <!-- Asset Title -->
                        <label for="url" class="col-form-label">Post Title</label>
                        <input type="text" readonly class="form-control mb-1" id="delete_title" name="delete_title">
                        <?= form_error('title', '<small class="text-danger pl-2">', '</small>') ?>
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

<!-- Rich Text Editor Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- Initialize Quill editor -->
<script>
    var quill = new Quill('#content_rich', {
        theme: 'snow'
    });


    quill.on('text-change', function(delta, source) {
        updateHtmlOutput()
    })

    // When the convert button is clicked, update output
    $('#btn-convert').on('click', () => {
        updateHtmlOutput()
    })

    // Return the HTML content of the editor
    function getQuillHtml() {
        return quill.root.innerHTML;
    }

    // Highlight code output
    function updateHighlight() {
        hljs.highlightBlock(document.querySelector('#output-html'))
    }


    function updateHtmlOutput() {
        let html = getQuillHtml();
        console.log(html);
        document.getElementById('output-html').innerText = html;
        updateHighlight();
    }


    updateHtmlOutput()
</script>