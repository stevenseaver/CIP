        <!-- Sidebar -->
        <?php 
            $data['items'] = $this->db->get_where('settings', ['parameter' => 'header_color'])->row_array();
            $color = $data['items']['value'];
            if ($color != 'light') {
                $text = 'dark';
                $icon = 'light';
            } else {
                $text = 'light';
                $icon = 'dark';
            }
        ?>

        <ul class="navbar-nav bg-gradient-<?= $color ?> sidebar sidebar-<?= $text ?> accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('user') ?>">
                <div class="sidebar-brand-icon">
                    <i class="bi bi-cart"></i>
                </div>
                <div class="sidebar-brand-text mx-1">IT System</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Query Nama Menu dari database menu yang boleh diakses user bersangkutan-->
            <?php
            $role_id = $this->session->userdata('role_id');
            $queryMenu = "SELECT `user_menu`.`id`, `menu`
                            FROM `user_menu` JOIN `user_access_menu`
                              ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                           WHERE `user_access_menu`.`role_id` = $role_id
                        ORDER BY `user_access_menu`.`menu_id` ASC
                        ";
            $menu = $this->db->query($queryMenu)->result_array();
            ?>

            <!-- LOOPING MENU -->
            <?php
            $i = 0;
            foreach ($menu as $m) : ?>
                <div class="sidebar-heading">
                    <?= $m['menu']; ?>
                </div>
                <!-- <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#<?= $i; ?>" aria-expanded="true" aria-controls="collapseTwo">
                    <?= $m['menu']; ?>
                </a> -->
                <!-- Submenu Looping according to sub-menu database -->
                <?php
                $menuId = $m['id'];
                $querySubMenu = "SELECT *
                                   FROM `user_sub_menu` JOIN `user_menu`
                                     ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                                  WHERE `user_sub_menu`.`menu_id` = $menuId
                                    AND `user_sub_menu`.`is_active` = 1
                    ";
                $subMenu = $this->db->query($querySubMenu)->result_array();
                ?>

                <?php foreach ($subMenu as $sm) : ?>
                    <?php if ($title == $sm['title']) : ?>
                        <li class="nav-item active">
                        <?php else : ?>
                        <li class="nav-item">
                        <?php endif; ?>
                        <a class="nav-link pb-0" href="<?= base_url($sm['url']) ?>">
                            <i class="<?= $sm['icon']; ?> text-<?= $icon ?>"></i>
                            <span><?= $sm['title']; ?></span>
                        </a>
                        <!-- <div id="<?= $i; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <i class="<?= $sm['icon']; ?>"></i>
                                <span><?= $sm['title']; ?></span>
                            </div>
                        </div> -->
                        </li>
                    <?php endforeach; ?>
                    <!-- Divider -->
                    <hr class="sidebar-divider mt-3">
                <?php endforeach; ?>

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

        </ul>
        <!-- End of Sidebar -->