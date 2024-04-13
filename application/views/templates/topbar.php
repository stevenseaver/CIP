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

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <!-- <small>Notifications</small> -->
                        <i class="bi bi-dropbox"></i>
                        <!-- Counter - Alerts -->
                        <?php
                            $userName = $user['id'];
                            $dataNotif = $this->db->get_where('stock_material', ['status' => 7])->result_array();
                            // var_dump($dataNotif);
                            $amount = 0;
                            $i = 0;
                            foreach ($dataNotif as $dn) :
                                $min_val = (float) $dn['item_desc'];
                                if ($dn['in_stock'] < $min_val) {
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
                            Low Material Notifications
                        </h6>
                        <?php
                        if($amount != 0) { 
                            foreach ($dataNotif as $dn) :
                                $min_val = (float) $dn['item_desc'];
                                if ($dn['in_stock'] < $min_val) { ?>
                                    <a class="dropdown-item text-left align-items-center" href="#">
                                        <div class="row align-items-center text-left">
                                            <div class="col-lg-2">
                                                <i class="bi bi-exclamation-triangle-fill text-danger h3"></i>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="font-weight-bold"><?= $dn['name'] ?></span>
                                            </div>
                                            <div class="col-lg-4">
                                                <span class="font-weight-bold"><?= number_format($dn['in_stock'], 2, '.', ',') . ' ' . $dn['unit_satuan'] ?></span>
                                            </div>
                                        </div>
                                    </a>
                            <?php
                                } else { 
                                }
                            endforeach;
                        } else { ?>
                            <a class="dropdown-item d-flex text-left align-items-center" href="#">
                                <div class="col-lg-12">
                                    <span class="">Nothing here</span>
                                </div>
                            </a>
                        <?php }; ?>
                    </div>
                </li>

                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <!-- <small>Notifications</small> -->
                        <i class="bi bi-box-fill"></i>
                        <!-- Counter - Alerts -->
                        <?php
                            $userName = $user['id'];
                            $dataFG = $this->db->get_where('stock_finishedgoods', ['status' => 7])->result_array();
                            // var_dump($dataFG);
                            $amount = 0;
                            $i = 0;
                            foreach ($dataFG as $df) :
                                $min_val = (float) $df['description'];
                                if ($df['in_stock'] < $min_val) {
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
                            Low Finished Goods Notifications
                        </h6>
                        <?php
                        if($amount != 0) { 
                            foreach ($dataFG as $df) :
                                $min_val = (float) $df['description'];
                                if ($df['in_stock'] < $min_val) { ?>
                                    <a class="dropdown-item text-left align-items-center" href="#">
                                        <div class="row align-items-center text-left">
                                            <div class="col-lg-2">
                                                <i class="bi bi-exclamation-triangle-fill text-danger h3"></i>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="font-weight-bold"><?= $df['name'] ?></span>
                                            </div>
                                            <div class="col-lg-4">
                                                <span class="font-weight-bold"><?= number_format($df['in_stock'], 2, '.', ',') . ' ' . $df['unit_satuan'] ?></span>
                                            </div>
                                        </div>
                                    </a>
                            <?php
                                } else { 
                                }
                            endforeach;
                        } else { ?>
                            <a class="dropdown-item d-flex text-left align-items-center" href="#">
                                <div class="col-lg-12">
                                    <span class="">Nothing here</span>
                                </div>
                            </a>
                        <?php }; ?>
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
                        <a class="dropdown-item mb-2" href="<?= base_url('user/changepassword') ?>">
                            <i class="bi bi-unlock-fill mr-2 text-gray-400"></i>
                            Change Password
                        </a>
                        <a class="dropdown-item" href="<?= base_url('admin/settings') ?>">
                            <i class="bi bi-gear-wide-connected mr-2 text-gray-400"></i>
                            Settings
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