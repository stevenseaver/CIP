<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <!-- href="<?= base_url('customer/cart') ?>" -->
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <small>Cart</small>
                        <i class="bi bi-cart-fill fa-fw"></i>
                        <!-- Counter - Alerts -->
                        <?php
                        $userName = $user['id'];
                        $amount = 0;
                        $i = 0;
                        foreach ($dataCart as $cd) :
                            if ($cd['customer_id'] == $userName and $cd['status'] == '0') {
                                $i++;
                                $amount = $i;
                            } else {
                            }
                        endforeach;
                        if ($amount == 0) :
                        ?>
                        <?php else : ?>
                            <h5 class="badge badge-danger badge-counter large"><?= $amount ?></h5>
                        <?php endif; ?>
                    </a>
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                        <h6 class="dropdown-header">
                            Cart Items
                        </h6>
                        <?php $temp = 0;
                        $grandTotal = 0;
                        foreach ($dataCart as $cd) :
                            if ($cd['customer_id'] == $userName and $cd['status'] == '0') { ?>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <!-- <div class="mx-1">
                                        <div class="icon-circle bg-primary">
                                            <i class="bi bi-cart text-white"></i>
                                        </div>
                                    </div> -->
                                    <div class="col-lg-10">
                                        <span class="font-weight-bold"><?= $cd['item_name'] ?></span>
                                        <div class="small text-gray-500">IDR <?= number_format($cd['subtotal'], 2, ',', '.'); ?></div>
                                        <?php $temp = $temp + $cd['subtotal']; ?>
                                    </div>
                                    <div class="col-lg-2">
                                        <span class="font-weight-bold"> <?= number_format($cd['qty'], 2, ',', '.'); ?></span>
                                    </div>
                                </a>
                        <?php
                                $grandTotal = $temp;
                            } else {
                            }
                        endforeach; ?>
                        <span class="dropdown-item text-center font-weight-bold">Total in cart (excl. tax): <?= 'IDR ' . number_format($grandTotal, 2, ',', '.'); ?></span>
                        <a class="dropdown-item text-center text-gray-800" href="<?= base_url('customer/cart') ?>"><i class="bi bi-cart text-dark mr-2"></i>Open Cart</a>
                    </div>
                </li>

                <!-- divider -->
                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user['name']; ?></span>
                        <img class="img-profile rounded-circle" src="<?= base_url('asset/img/profile/') . $user['image'] ?>">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item mb-2" href="<?= base_url('user') ?>">
                            <i class="bi bi-speedometer mr-2 text-gray-400"></i>
                            Dashboard
                        </a>
                        <a class="dropdown-item mb-2" href="<?= base_url('user/my_profile') ?>">
                            <i class="bi bi-person-fill mr-2 text-gray-400"></i>
                            My Profile
                        </a>
                        <a class="dropdown-item" href="<?= base_url('user/changepassword') ?>">
                            <i class="bi bi-unlock-fill mr-2 text-gray-400"></i>
                            Change Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= base_url('auth/logout') ?>" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->