<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center">
    <div class="sidebar-brand-icon">
        <img src="<?= base_url('assets/img/logo.png') ?>" width="70px" height="70px" class="rounded-circle" alt="">
    </div>
    <div class="sidebar-brand-text mx-3">SIMPLE</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider">

    <?php $role = $this->session->userdata('role_id');
    $queryMenu = "SELECT `user_menu`.`id`, `menu`
        FROM `user_menu` JOIN `user_access_menu` 
        ON `user_menu`.`id` = `user_access_menu`.`menu_id`
        WHERE `user_access_menu`.`role_id` = '$role'
        ORDER BY `user_access_menu`.`menu_id` ASC";
        $menu = $this->db->query($queryMenu)->result_array();
        
    ?>
    <?php foreach ($menu as $m) : ?>
        <div class="sidebar-heading">
            <?= $m['menu'] ?>
        </div>
        <?php $menuId= $m['id'];
            $querySubMenu = "SELECT *
                            FROM user_sub_menu JOIN user_menu
                                ON user_sub_menu.menu_id = user_menu.id
                            WHERE user_sub_menu.menu_id = $menuId
                                AND user_sub_menu.is_active = 1 " ; 
         $subMenu=$this->db->query($querySubMenu)->result_array();?>
        <?php foreach($subMenu as $sm) : ?>
        <?php if ($title == $sm['title']) : {
            } ?>
                <!-- Nav Item - Dashboard -->
                    <li class="nav-item active">
            <?php else : ?>
                <li class="nav-item ">
            <?php endif ; ?>
                        <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
                            <i class="<?= $sm['icon'];  ?>"></i>
                            <span><?= $sm['title']; ?></span></a>
                    </li>
        <?php endforeach;?>
        <hr class="sidebar-divider mt-3">
    <?php endforeach; ?>
                



<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>