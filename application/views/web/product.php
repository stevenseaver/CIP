<!-- Begin Page Content -->
<div class="container-fluid pt-4 mt-5">
    <div class="row row-cols-1 justify-content-center">
        <?php foreach ($products as $pl) : ?>
            <div class="card mb-3" style="max-width:720px;">
                <div class="row no-gutters">
                    <div class="col-lg-3">
                        <img class="card-img" src="<?= base_url('asset/') . $pl['image']; ?>" width="170" height="200">
                    </div>
                    <div class="col-lg-9">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><?= $pl['title']; ?></h5>
                            <p class="card-text"><?= $pl['text']; ?></p>
                            <a href="<?= base_url('') . $pl['url'];  ?>">Learn More &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->