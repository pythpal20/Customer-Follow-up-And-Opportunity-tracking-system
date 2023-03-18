<?php
    $tim = $this->db->get_where('user_role', ['role_id'=>$user['role_id']])->row_array();
?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="" src="<?= base_url('upload/'); ?>logo/logo.png" />
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold"><?= $user['user_nama'] ?></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="#"><?= $tim['role'] ?></a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    SIFU
                </div>
            </li>
            <hr class="hr-line-solid divider">
            <!-- query menu -->
            <?php
            $roleID = $this->session->userdata('role_id');
            $queryMenu = "SELECT `user_menu`.`id`, `menu`
                FROM `user_menu` JOIN `user_access_menu`
                ON `user_menu`.`id` = `user_access_menu`.`menu_id`
            WHERE `user_access_menu`.`role_id` = $roleID
            ORDER BY `user_menu`.`nourut` ASC";
            $menu = $this->db->query($queryMenu)->result_array();
            ?>
            <!-- Looping data Menu -->
            <?php foreach ($menu as $m) : ?>
                <div class="nav-label ml-2">
                    <?= $m['menu'] ?>
                </div>
                <!-- submenu -->
                <?php
                $menuID = $m['id'];
                $querySubMenu = "SELECT * FROM `user_sub_menu` JOIN `user_menu` ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                WHERE `user_sub_menu`.`menu_id` = $menuID
                AND `user_sub_menu`.`is_active` = '1' ORDER BY nourutan ASC";

                $subMenu = $this->db->query($querySubMenu)->result_array();
                ?>
                <?php foreach ($subMenu as $sm) : ?>
                    <?php if ($title == $sm['title']) : ?>
                        <li class="nav-item active">
                    <?php else : ?>
                        <li>
                    <?php endif; ?>
                    <a href="<?= base_url($sm['url']) ?>">
                        <i class="<?= $sm['icon'] ?>"></i> 
                        <span class="nav-label"><?= $sm['title'] ?></span>
                    </a>
                    </li>
                <?php endforeach; ?>
                <hr class="nav-divider nav-fill">
            <?php endforeach; ?>
        </ul>

    </div>
</nav>