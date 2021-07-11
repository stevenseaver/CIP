<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
            <!-- Topbar - Brand -->
            <a class="navbar-brand d-flex align-items-center justify-content-center" href="<?= base_url('web') ?>">
                <div class="navbar-brand-icon ml-2">
                    <i class="fas fa-recycle"></i>
                </div>
                <div class="navbar-brand-text mx-2 text-primary font-weight-bold">UD. Cakra Inti Plastik</div>
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
                                <span class="ml-1"><?= $wm['title']; ?></span>
                            </a>
                            </li>
                        <?php endforeach; ?>
                </ul>
                <!-- Divider -->
                <div class="topbar-divider d-none d-sm-block"></div>

                <ul class="navbar-nav">
                    <!-- Nav Item - login Button -->
                    <?php if (!$user['nik']) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('auth'); ?>" target="_blank">
                                <i class="fas fa-fw fa-cart-plus"></i>
                                <span class="ml-1">Shop</span>
                            </a>
                        </li>
                    <?php else : ?>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user['name']; ?></span>
                                <img class="img-profile rounded-circle" src="<?= base_url('asset/img/Profile/') . $user['image'] ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= base_url('user') ?>">
                                    <i class="fas fa-home fa-fw mr-2 text-gray-400"></i>
                                    My Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('auth/logout') ?>" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

        </nav>
        <!-- End of Topbar -->