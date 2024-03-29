<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900"><?= $title ?></h1>
    <?= $this->session->flashdata('message'); ?>

    <a href="<?= base_url('blog/blogpost') ?>" class="btn btn-primary btn-icon-split mb-3">
        <span class="icon text-white-50">
            <i class="bi bi-arrow-left"></i>
        </span>
        <span class="text">Back</span>
    </a>

    <div class="card border-left-primary mb-3">
        <div class="card-body pt-0">
            <?= form_open_multipart('blog/add_post'); ?>
            <div class="form-group">
                <input type="text" class="form-control" id="author_id" name="author_id" placeholder="<?= $user['id'] ?>" value="<?= $user['id'] ?>" style="display:none">
            </div>
            <div class="form-group">
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
                <textarea class="form-control" id="blog_content" name="blog_content" placeholder="Pour your ideas here..." value="<?= set_value('blog_content'); ?>"></textarea>
                <?= form_error('blog_content', '<small class="text-danger pl-2">', '</small>') ?>
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
            <div class="">
                <button type="submit" class="btn btn-primary">Save Post</button>
            </div>
            </form>
        </div>
    </div>

    <!-- /.container-fluid -->
</div>
</div>
<!-- End of Main Content -->