<!-- Begin Page Content -->
<!-- Page Heading -->
<div class="no-gutter pt-4 mt-5 bg-light">
    <div class="row d-flex justify-content-center align-items-center bg-light">
        <?php foreach ($post_type as $bt) : ?>
            <a href="<?= base_url() . $bt['url'] ?>" class="nav-link strecthed text-dark text-center pt-3 pb-3 px-4">
                <figure class="nav-icon <?= $bt['icon']; ?>  fa-2x mb-1"></figure>
                <span class="nav-label"><?= $bt['type_name']; ?></span>
            </a>
        <?php endforeach; ?>
    </div>

    <h1 class="h3 ml-3 mb-4 text-gray-800"><?= $title ?></h1>
</div>
<!-- End of Main Content -->