<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark mb-4">
            <!-- Topbar - Brand -->
            <a class="navbar-brand d-flex align-items-center justify-content-center" href="<?= base_url('web') ?>">
                <div class="navbar-brand-icon ml-2">
                    <i class="fas fa-recycle"></i>
                </div>
                <div class="navbar-brand-text mx-2 text-white font-weight-bold">UD. Cakra Inti Plastik</div>
            </a>
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Topbar Navbar Items for Menu-->
                <ul class="navbar-nav ml-auto">
                    <?php foreach ($webmenu as $wm) : ?>
                        <?php if ($title == $wm['title']) : ?>
                            <li class="nav-item active">
                            <?php else : ?>
                            <li class="nav-item">
                            <?php endif; ?>
                            <a class="nav-link" href="<?= base_url($wm['url']) ?>">
                                <i class="<?= $wm['icon']; ?>"></i>
                                <span><?= $wm['title']; ?></span>
                            </a>
                            </li>
                        <?php endforeach; ?>
                </ul>
                <!-- Divider -->
                <div class="topbar-divider d-none d-sm-block"></div>

                <ul class="navbar-nav">
                    <!-- Nav Item - login Button -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('auth'); ?>" target="_blank">
                            <i class="bi bi-cart"></i>
                            <span>Shop</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End of Topbar -->