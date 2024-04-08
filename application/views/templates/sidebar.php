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
                    <i class="bi bi-box-fill"></i>
                </div>
                <div class="sidebar-brand-text mx-1">Stocky</div>
            </a>

            <!-- Divider -->
            <!-- Query Nama Menu dari database menu yang boleh diakses user bersangkutan-->
            <?php
            $role_id = $this->session->userdata('role_id');
            $queryMenu = "SELECT `user_menu`.*, `menu`
                            FROM `user_menu` JOIN `user_access_menu`
                              ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                           WHERE `user_access_menu`.`role_id` = $role_id
                        ORDER BY `user_access_menu`.`menu_id` ASC
                        ";
            $menu = $this->db->query($queryMenu)->result_array();
            // var_dump($menu);
            ?>

            <!-- LOOPING MENU -->
            <?php
            $i = 0;
            foreach ($menu as $m) : ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapse-<?= $i ?>" aria-expanded="true" aria-controls="collapse-<?= $i ?>">
                        <i class="<?= $m['menu_icon']; ?> text-<?= $icon ?>"></i>
                        <span><?= $m['menu']; ?></span>
                    </a>

                    <!-- get sub menu content -->
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

                    <div id="collapse-<?= $i; ?>" class="collapse" aria-labelledby="heading-<?= $i; ?>" data-parent="#accordionSidebar">
                        <div class="bg-<?= $icon ?> collapse-inner rounded">
                            <?php foreach ($subMenu as $sm) : ?>
                                <a class="collapse-item" href="<?= base_url($sm['url']) ?>">
                                    <i class="<?= $sm['icon']; ?> text-<?= $text ?>"></i>
                                    <span class="text-wrap text-<?= $text?>"><?= $sm['title']; ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </li>
                <!-- <hr class="sidebar-divider px"> -->
            <?php $i++;
            endforeach; ?>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline mt-4">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->